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
    public function calculate(TestAttempt $attempt): DiscTestResult
    {
        // 1. Fetch all answers for this test attempt
        $answers = $attempt->answers()->with('option')->get();

        $line1Raw = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, '*' => 0];
        $line2Raw = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, '*' => 0];

        foreach ($answers as $ans) {
            $tag = strtoupper($ans->option?->attribute_tag ?? '');
            if (!in_array($tag, ['D', 'I', 'S', 'C'])) {
                $tag = '*';
            }

            $ansType = strtolower($ans->answer_type ?? '');
            if ($ansType === 'most' || $ansType === 'p' || $ansType === '1') {
                $line1Raw[$tag] = ($line1Raw[$tag] ?? 0) + 1;
            } elseif ($ansType === 'least' || $ansType === 'k' || $ansType === '2') {
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

        // 4. Determine pattern code based on highest Line 3 converted scores
        $patternCode = $this->determinePatternCode($line3Converted);

        // Find matching profile
        $profile = DiscProfile::where('pattern_code', $patternCode)->first()
            ?? DiscProfile::where('pattern_code', 'LIKE', substr($patternCode, 0, 1) . '%')->first()
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
            $raw = $rawScores[$attr] ?? 0;
            $norm = DiscNorm::where('line_type', $lineType)
                ->where('attribute', $attr)
                ->where('raw_score', $raw)
                ->first();

            $converted[$attr] = $norm ? (float) $norm->converted_score : (float) $raw;
        }

        return $converted;
    }

    /**
     * Determine pattern code (e.g. "D", "I", "S", "C", "D-I", etc.) from Line 3 converted scores.
     */
    protected function determinePatternCode(array $line3Converted): string
    {
        // Sort dimensions by converted score descending
        arsort($line3Converted);
        $keys = array_keys($line3Converted);
        $highest = $keys[0];
        $second = $keys[1];

        // If top 2 are close in score (difference <= 1.5), combine them
        if (($line3Converted[$highest] - $line3Converted[$second]) <= 1.5 && $line3Converted[$second] > 0) {
            return $highest . '-' . $second;
        }

        return $highest;
    }
}
