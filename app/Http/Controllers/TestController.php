<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\QuestionBank;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'category_id' => 'required|exists:test_categories,id',
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'total_questions' => 'required|integer|min:1',
            'is_random' => 'nullable|boolean',
            'selected_questions' => 'nullable|array',
            'selected_questions.*' => 'exists:question_banks,id',
        ]);

        try {
            DB::beginTransaction();

            $selectedQuestions = $request->input('selected_questions', []);
            $totalQuestions = count($selectedQuestions) > 0 
                ? count($selectedQuestions) 
                : (int) $request->total_questions;

            $test = Test::create([
                'job_id' => $request->job_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'duration_minutes' => $request->duration_minutes,
                'passing_score' => $request->passing_score,
                'total_questions' => $totalQuestions,
                'is_random' => $request->boolean('is_random'),
            ]);

            if (!empty($selectedQuestions)) {
                $syncData = [];
                foreach ($selectedQuestions as $index => $qId) {
                    $syncData[$qId] = ['order_number' => $index + 1];
                }
                $test->questions()->sync($syncData);
            }

            DB::commit();

            return redirect()->route('admin.test')
                ->with('create', 'Paket Ujian berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.test')
                ->with('error', 'Gagal membuat paket ujian: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $test = Test::findOrFail($id);

        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'category_id' => 'required|exists:test_categories,id',
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'total_questions' => 'required|integer|min:1',
            'is_random' => 'nullable|boolean',
            'selected_questions' => 'nullable|array',
            'selected_questions.*' => 'exists:question_banks,id',
        ]);

        try {
            DB::beginTransaction();

            $selectedQuestions = $request->input('selected_questions', []);
            $totalQuestions = count($selectedQuestions) > 0 
                ? count($selectedQuestions) 
                : (int) $request->total_questions;

            $test->update([
                'job_id' => $request->job_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'duration_minutes' => $request->duration_minutes,
                'passing_score' => $request->passing_score,
                'total_questions' => $totalQuestions,
                'is_random' => $request->boolean('is_random'),
            ]);

            if (!empty($selectedQuestions)) {
                $syncData = [];
                foreach ($selectedQuestions as $index => $qId) {
                    $syncData[$qId] = ['order_number' => $index + 1];
                }
                $test->questions()->sync($syncData);
            } else {
                $test->questions()->detach();
            }

            DB::commit();

            return redirect()->route('admin.test')
                ->with('update', 'Paket Ujian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.test')
                ->with('error', 'Gagal memperbarui paket ujian: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $test = Test::findOrFail($id);

        if (!$test->delete()) {
            return redirect()->route('admin.test')
                ->with('error', 'Paket Ujian gagal dihapus.');
        }

        return redirect()->route('admin.test')
            ->with('delete', 'Paket Ujian berhasil dihapus.');
    }
}
