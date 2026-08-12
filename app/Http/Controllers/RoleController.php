<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        if (!$role) {
            return redirect()->route('admin.role')->with('error', 'Role gagal ditambahkan');
        }

        return redirect()->route('admin.role')->with('create', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.role')->with('create', 'Role berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // Protect primary core roles from deletion
        if (in_array(strtolower($role->name), ['admin', 'applicant', 'recruiter'])) {
            return redirect()->route('admin.role')->with('error', 'Role utama sistem (' . $role->name . ') tidak dapat dihapus');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.role')->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh pengguna');
        }

        $role->delete();

        return redirect()->route('admin.role')->with('delete', 'Role berhasil dihapus');
    }
}
