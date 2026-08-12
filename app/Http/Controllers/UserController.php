<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'nik'      => 'nullable|string|max:20',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nik'      => $request->nik,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return redirect()->route('admin.user')->with('error', 'Pengguna gagal ditambahkan');
        }

        return redirect()->route('admin.user')->with('create', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nik'      => 'nullable|string|max:20',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'nik'     => $request->nik,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user')->with('create', 'Pengguna berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('admin.user')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user')->with('delete', 'Pengguna berhasil dihapus');
    }
}
