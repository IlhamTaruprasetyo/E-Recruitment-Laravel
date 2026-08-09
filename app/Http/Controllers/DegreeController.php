<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;

class DegreeController extends Controller
{
    public function index()
    {
        return response()->json(Degree::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name',
            'rank' => 'nullable|integer|min:0',
        ]);

        $data = Degree::create([
            'name' => $request->name,
            'rank' => $request->rank ?? 0,
        ]);

        if (!$data) {
            return redirect()->route('admin.degree')
                ->with('error', 'Tingkat pendidikan gagal dibuat');
        }

        return redirect()->route('admin.degree')
            ->with('create', 'Tingkat pendidikan berhasil dibuat');
    }

    public function show(string $id)
    {
        $data = Degree::findOrFail($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $data = Degree::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name,' . $id,
            'rank' => 'nullable|integer|min:0',
        ]);

        $data->update([
            'name' => $request->name,
            'rank' => $request->rank ?? 0,
        ]);

        return redirect()->route('admin.degree')
            ->with('update', 'Tingkat pendidikan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $data = Degree::findOrFail($id);

        if (!$data->delete()) {
            return redirect()->route('admin.degree')
                ->with('error', 'Tingkat pendidikan gagal dihapus');
        }

        return redirect()->route('admin.degree')
            ->with('delete', 'Tingkat pendidikan berhasil dihapus');
    }
}
