<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        return response()->json(Position::with('department.company')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = Position::create([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if (!$data) {
            return redirect()->route('admin.position')
                ->with('error', 'Posisi / Jabatan gagal dibuat');
        }

        return redirect()->route('admin.position')
            ->with('create', 'Posisi / Jabatan berhasil dibuat');
    }

    public function show(string $id)
    {
        $data = Position::with('department.company')->findOrFail($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $data = Position::findOrFail($id);

        $request->validate([
            'department_id' => 'sometimes|required|exists:departments,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $data->update([
            'department_id' => $request->input('department_id', $data->department_id),
            'name' => $request->input('name', $data->name),
            'description' => $request->input('description', $data->description),
        ]);

        return redirect()->route('admin.position')
            ->with('update', 'Posisi / Jabatan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $data = Position::findOrFail($id);

        if (!$data->delete()) {
            return redirect()->route('admin.position')
                ->with('error', 'Posisi / Jabatan gagal dihapus');
        }

        return redirect()->route('admin.position')
            ->with('delete', 'Posisi / Jabatan berhasil dihapus');
    }
}
