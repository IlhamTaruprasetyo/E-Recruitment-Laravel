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
        $attempt = TestAttempt::with(['answers.question', 'test', 'jobApplication'])->findOrFail($id);

        $request->validate([
            'essay_scores' => 'nullable|array',
            'essay_scores.*' => 'nullable|numeric|min:0',
            'application_status' => 'nullable|string|in:Submitted,Reviewed,Shortlisted,Interview,Accepted,Rejected',
            'application_notes' => 'nullable|string|max:1000',
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
            $hasDisc = $attempt->discTestResult || ($attempt->test && (str_contains(strtolower($attempt->test->title ?? ''), 'disc') || str_contains(strtolower($attempt->test->title ?? ''), 'personality')));

            if ($hasDisc || $passingScore <= 0) {
                $status = 'completed';
            } else {
                $status = ($totalScore >= $passingScore) ? 'passed' : 'failed';
            }

            $attempt->update([
                'objective_score' => $objectiveScoreSum,
                'essay_score' => $essayScoreSum,
                'total_score' => $totalScore,
                'status' => $status,
            ]);

            // Update status lamaran: prioritaskan pilihan manual HR jika dipilih, jika tidak dan lulus KKM otomatis Shortlisted
            if ($attempt->jobApplication) {
                $app = $attempt->jobApplication;
                $newStatus = $request->input('application_status');
                $customNotes = $request->input('application_notes');

                if (!empty($newStatus)) {
                    $notes = !empty($customNotes) 
                        ? $customNotes 
                        : 'Status lamaran diperbarui oleh HR melalui evaluasi ujian (Total Nilai: ' . number_format($totalScore, 1) . ').';

                    $app->update([
                        'status' => $newStatus,
                        'notes'  => $notes,
                    ]);

                    \App\Models\ApplicationStatusHistory::create([
                        'job_applications_id' => $app->id,
                        'status'              => $newStatus,
                        'notes'               => $notes,
                        'changed_by'          => $reviewerId ?? 1,
                        'changed_at'          => now(),
                    ]);
                } elseif ($status === 'passed' && in_array(strtolower($app->status), ['submitted', 'reviewed', 'pending'])) {
                    // Fallback otomatis jika lulus KKM
                    $app->update([
                        'status' => 'Shortlisted',
                        'notes'  => 'Lolos Ujian Seleksi Online (Nilai: ' . number_format($totalScore, 1) . ' / KKM: ' . number_format($passingScore, 0) . '). Siap untuk dijadwalkan wawancara.',
                    ]);

                    \App\Models\ApplicationStatusHistory::create([
                        'job_applications_id' => $app->id,
                        'status'              => 'Shortlisted',
                        'notes'               => 'Lolos Ujian Seleksi Online (Nilai: ' . number_format($totalScore, 1) . ' / KKM: ' . number_format($passingScore, 0) . ').',
                        'changed_by'          => $reviewerId ?? 1,
                        'changed_at'          => now(),
                    ]);
                }
            }

            $user = auth()->user();
            $isRecruiter = $user && ($user->role_id == 2 || strtolower($user->role?->name ?? '') === 'recruiter');
            $redirectRoute = $isRecruiter ? 'recruiter.test_evaluation' : 'admin.test_evaluation';

            DB::commit();

            return redirect()->route($redirectRoute)
                ->with('update', 'Penilaian essay pelamar berhasil disimpan dan total skor telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            $user = auth()->user();
            $isRecruiter = $user && ($user->role_id == 2 || strtolower($user->role?->name ?? '') === 'recruiter');
            $redirectRoute = $isRecruiter ? 'recruiter.test_evaluation' : 'admin.test_evaluation';

            return redirect()->route($redirectRoute)
                ->with('error', 'Gagal menyimpan penilaian essay: ' . $e->getMessage());
        }
    }
}
