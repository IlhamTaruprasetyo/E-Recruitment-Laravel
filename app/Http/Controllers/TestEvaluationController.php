<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestAttempt;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\DB;

class TestEvaluationController extends Controller
{
    public function updateGrade(Request $request, string $id)
    {
        $attempt = TestAttempt::with(['answers.question', 'test'])->findOrFail($id);

        $request->validate([
            'essay_scores' => 'nullable|array',
            'essay_scores.*' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $reviewerId = auth()->id();
            $essayScores = $request->input('essay_scores', []);

            foreach ($essayScores as $answerId => $scoreValue) {
                if ($scoreValue !== null && $scoreValue !== '') {
                    $answer = TestAnswer::where('attempt_id', $attempt->id)
                        ->where('id', $answerId)
                        ->first();

                    if ($answer) {
                        $maxPoints = $answer->question->points ?? 1;
                        $finalScore = min((float) $scoreValue, (float) $maxPoints);

                        $answer->update([
                            'score' => $finalScore,
                            'reviewed_by' => $reviewerId,
                        ]);
                    }
                }
            }

            // Recalculate essay score sum
            $essayScoreSum = TestAnswer::where('attempt_id', $attempt->id)
                ->whereHas('question', function ($q) {
                    $q->where('question_type', 'essay');
                })
                ->sum('score');

            // Recalculate objective score sum if not set
            $objectiveScoreSum = TestAnswer::where('attempt_id', $attempt->id)
                ->whereHas('question', function ($q) {
                    $q->where('question_type', 'multiple_choice');
                })
                ->sum('score');

            $totalScore = $objectiveScoreSum + $essayScoreSum;

            $passingScore = $attempt->test ? (float) $attempt->test->passing_score : 0;
            $status = ($passingScore > 0 && $totalScore >= $passingScore) ? 'passed' : 'failed';

            $attempt->update([
                'objective_score' => $objectiveScoreSum,
                'essay_score' => $essayScoreSum,
                'total_score' => $totalScore,
                'status' => $status,
            ]);

            DB::commit();

            return redirect()->route('admin.test_evaluation')
                ->with('update', 'Penilaian essay pelamar berhasil disimpan dan total skor telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.test_evaluation')
                ->with('error', 'Gagal menyimpan penilaian essay: ' . $e->getMessage());
        }
    }
}
