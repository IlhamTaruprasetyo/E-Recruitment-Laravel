<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;

class MajorController extends Controller
{
    public function index()
    {
        return response()->json(Major::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:majors,name',
        ]);

        $data = Major::create([
            'name' => $request->name,
        ]);

        if (!$data) {
            return redirect()->route('admin.major')
                ->with('error', 'Jurusan gagal dibuat');
        }

        return redirect()->route('admin.major')
            ->with('create', 'Jurusan berhasil dibuat');
    }

    public function show(string $id)
    {
        $data = Major::findOrFail($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $data = Major::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:majors,name,' . $id,
        ]);

        $data->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.major')
            ->with('update', 'Jurusan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $data = Major::findOrFail($id);

        if (!$data->delete()) {
            return redirect()->route('admin.major')
                ->with('error', 'Jurusan gagal dihapus');
        }

        return redirect()->route('admin.major')
            ->with('delete', 'Jurusan berhasil dihapus');
    }
}
