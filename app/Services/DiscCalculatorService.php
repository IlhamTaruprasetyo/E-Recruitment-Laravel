<?php

namespace App\Services;

use App\Models\DiscNorm;
use App\Models\DiscProfile;
use App\Models\DiscTestResult;
use App\Models\TestAttempt;
use Illuminate\Support\Facades\DB;

class DiscCalculatorService
{
    /**
     * Calculate DISC test attempt scores, graph conversions, pattern profile, and save result.
     */
    public function calculate(TestAttempt $attempt): ?DiscTestResult
    {
        // 1. Fetch all answers for this test attempt
        $answers = $attempt->answers()->with(['option', 'question'])->get();

        $discAnswers = $answers->filter(function ($ans) {
            return ($ans->question && $ans->question->question_type === 'disc')
                || in_array(strtolower($ans->answer_type ?? ''), ['most', 'least', 'p', 'k', '1', '2']);
        });

        if ($discAnswers->isEmpty()) {
            DiscTestResult::where('test_attempt_id', $attempt->id)->delete();
            return null;
        }

        $line1Raw = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, '*' => 0];
        $line2Raw = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, '*' => 0];

        foreach ($answers as $ans) {
            $ansType = strtolower($ans->answer_type ?? '');
            if ($ansType === 'most' || $ansType === 'p' || $ansType === '1') {
                $tag = strtoupper($ans->option?->most_tag ?? $ans->option?->attribute_tag ?? '');
                if (!in_array($tag, ['D', 'I', 'S', 'C'])) {
                    $tag = '*';
                }
                $line1Raw[$tag] = ($line1Raw[$tag] ?? 0) + 1;
            } elseif ($ansType === 'least' || $ansType === 'k' || $ansType === '2') {
                $tag = strtoupper($ans->option?->least_tag ?? $ans->option?->attribute_tag ?? '');
                if (!in_array($tag, ['D', 'I', 'S', 'C'])) {
                    $tag = '*';
                }
                $line2Raw[$tag] = ($line2Raw[$tag] ?? 0) + 1;
            }
        }

        // 2. Line 3 Raw (Difference = Line 1 - Line 2)
        $line3Raw = [
            'D' => $line1Raw['D'] - $line2Raw['D'],
            'I' => $line1Raw['I'] - $line2Raw['I'],
            'S' => $line1Raw['S'] - $line2Raw['S'],
            'C' => $line1Raw['C'] - $line2Raw['C'],
        ];

        // 3. Lookup converted scores from disc_norms
        $line1Converted = $this->convertLineScores(1, $line1Raw);
        $line2Converted = $this->convertLineScores(2, $line2Raw);
        $line3Converted = $this->convertLineScores(3, $line3Raw);

        // Package scores structure
        $line1Data = [
            'raw' => $line1Raw,
            'converted' => $line1Converted,
        ];
        $line2Data = [
            'raw' => $line2Raw,
            'converted' => $line2Converted,
        ];
        $line3Data = [
            'raw' => $line3Raw,
            'converted' => $line3Converted,
        ];

        // 4. Determine pattern and profile using Official Standard DISC 40 Patterns
        $evalService = app(DiscStandardEvaluationService::class);
        $patternResult = $evalService->evaluate($line3Converted);
        $patternIndex = $patternResult['index'] ?? 1;

        // Find matching profile by index / ID
        $profile = DiscProfile::find($patternIndex)
            ?? DiscProfile::where('title', $patternResult['title'] ?? '')->first()
            ?? DiscProfile::where('pattern_code', $patternResult['code'] ?? '')->first()
            ?? DiscProfile::first();

        // 5. Update or Create DiscTestResult
        return DiscTestResult::updateOrCreate(
            ['test_attempt_id' => $attempt->id],
            [
                'disc_profiles_id' => $profile?->id,
                'line_1_scores' => $line1Data,
                'line_2_scores' => $line2Data,
                'line_3_scores' => $line3Data,
            ]
        );
    }

    /**
     * Helper to lookup converted scores for a specific line type.
     */
    protected function convertLineScores(int $lineType, array $rawScores): array
    {
        $converted = [];
        foreach (['D', 'I', 'S', 'C'] as $attr) {
            $raw = (int) ($rawScores[$attr] ?? 0);
            
            // Lookup norm from database
            $norm = DiscNorm::where('line_type', $lineType)
                ->where('attribute', $attr)
                ->where('raw_score', $raw)
                ->first();

            if (!$norm) {
                // Fallback for clamped bounds
                if ($lineType === 1 || $lineType === 2) {
                    $clamped = max(0, min(20, $raw));
                } else {
                    $clamped = max(-22, min(22, $raw));
                }
                $norm = DiscNorm::where('line_type', $lineType)
                    ->where('attribute', $attr)
                    ->where('raw_score', $clamped)
                    ->first();
            }

            $converted[$attr] = $norm ? (float) $norm->converted_score : (float) $raw;
        }

        return $converted;
    }
}
