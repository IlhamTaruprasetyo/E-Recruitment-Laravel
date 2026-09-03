<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\QuestionBank;
use Illuminate\Support\Facades\DB;

class EmployeeTestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'department_ids' => 'nullable|array',
            'department_ids.*' => 'exists:departments,id',
            'target_employee_type' => 'nullable|string|in:all,permanent,contract,internship',
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

            // Handle department_ids (multi-select) or legacy single department_id
            $departmentIds = $request->input('department_ids', []);
            if (empty($departmentIds) && $request->filled('department_id')) {
                $departmentIds = [$request->department_id];
            }
            $departmentIds = array_values(array_filter($departmentIds));
            $primaryDepartmentId = !empty($departmentIds) ? $departmentIds[0] : null;

            $test = Test::create([
                'test_type' => 'employee',
                'job_id' => null,
                'department_id' => $primaryDepartmentId,
                'target_employee_type' => $request->filled('target_employee_type') ? $request->target_employee_type : 'all',
                'category_id' => $request->category_id,
                'title' => $request->title,
                'duration_minutes' => $request->duration_minutes,
                'passing_score' => $request->passing_score,
                'total_questions' => $totalQuestions,
                'is_random' => $request->boolean('is_random'),
            ]);

            // Sync many-to-many departments
            $test->departments()->sync($departmentIds);

            if (!empty($selectedQuestions)) {
                $syncData = [];
                foreach ($selectedQuestions as $index => $qId) {
                    $syncData[$qId] = ['order_number' => $index + 1];
                }
                $test->questions()->sync($syncData);
            }

            DB::commit();

            return redirect()->route('admin.employee_test')
                ->with('create', 'Paket Asesmen Karyawan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.employee_test')
                ->with('error', 'Gagal membuat paket asesmen karyawan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $test = Test::where('test_type', 'employee')->findOrFail($id);

        $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'department_ids' => 'nullable|array',
            'department_ids.*' => 'exists:departments,id',
            'target_employee_type' => 'nullable|string|in:all,permanent,contract,internship',
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

            // Handle department_ids (multi-select) or legacy single department_id
            $departmentIds = $request->input('department_ids', []);
            if ($request->has('department_ids')) {
                $departmentIds = array_values(array_filter($departmentIds));
            } elseif ($request->filled('department_id')) {
                $departmentIds = [$request->department_id];
            } else {
                $departmentIds = [];
            }
            $primaryDepartmentId = !empty($departmentIds) ? $departmentIds[0] : null;

            $test->update([
                'department_id' => $primaryDepartmentId,
                'target_employee_type' => $request->filled('target_employee_type') ? $request->target_employee_type : 'all',
                'category_id' => $request->category_id,
                'title' => $request->title,
                'duration_minutes' => $request->duration_minutes,
                'passing_score' => $request->passing_score,
                'total_questions' => $totalQuestions,
                'is_random' => $request->boolean('is_random'),
            ]);

            // Sync many-to-many departments
            $test->departments()->sync($departmentIds);

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

            return redirect()->route('admin.employee_test')
                ->with('create', 'Paket Asesmen Karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.employee_test')
                ->with('error', 'Gagal memperbarui paket asesmen: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $test = Test::where('test_type', 'employee')->findOrFail($id);
            $test->departments()->detach();
            $test->questions()->detach();
            $test->delete();

            return redirect()->route('admin.employee_test')
                ->with('delete', 'Paket Asesmen Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.employee_test')
                ->with('error', 'Gagal menghapus paket asesmen: ' . $e->getMessage());
        }
    }
}
