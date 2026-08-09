<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json(Department::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = Department::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if (!$data) {
            return redirect()->route('admin.department')
                ->with('error', 'Department gagal dibuat');
        }

        return redirect()->route('admin.department')
            ->with('create', 'Department berhasil dibuat');
    }

    public function show(string $id)
    {
        $data = Department::findOrFail($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $data = Department::findOrFail($id);

        $request->validate([
            'company_id' => 'sometimes|required|exists:companies,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $data->update([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.department')
            ->with('update', 'Department berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $data = Department::findOrFail($id);

        if (!$data->delete()) {
            return redirect()->route('admin.department')
                ->with('error', 'Department gagal dihapus');
        }

        return redirect()->route('admin.department')
            ->with('delete', 'Department berhasil dihapus');
    }
}
