<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestCategory;

class TestCategoryController extends Controller
{
    public function index()
    {
        return response()->json(TestCategory::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:test_categories,name',
            'description' => 'nullable|string',
        ]);

        $data = TestCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if (!$data) {
            return redirect()->route('admin.test_category')
                ->with('error', 'Kategori soal gagal dibuat');
        }

        return redirect()->route('admin.test_category')
            ->with('create', 'Kategori soal berhasil dibuat');
    }

    public function show(string $id)
    {
        $data = TestCategory::findOrFail($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $data = TestCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:test_categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $data->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.test_category')
            ->with('update', 'Kategori soal berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $data = TestCategory::findOrFail($id);

        if (!$data->delete()) {
            return redirect()->route('admin.test_category')
                ->with('error', 'Kategori soal gagal dihapus');
        }

        return redirect()->route('admin.test_category')
            ->with('delete', 'Kategori soal berhasil dihapus');
    }
}
