<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Admin: lihat semua user
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'is_aktif', 'nip')->get();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    // Admin: buat user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:user,operator,admin',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'is_aktif' => $request->is_aktif ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dibuat!',
            'data'    => $user
        ], 201);
    }

    // Admin: update data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role'  => 'sometimes|in:user,operator,admin',
        ]);

        $data = $request->only(['name', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui!',
            'data'    => $user
        ]);
    }

    // Admin: aktifkan/nonaktifkan user
    public function toggleStatus(Request $request, User $user)
    {
        $request->validate([
            'is_aktif' => 'required|boolean',
        ]);

        $user->update(['is_aktif' => $request->is_aktif]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diperbarui!',
            'data'    => $user
        ]);
    }

    // Admin: hapus user
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus!'
        ]);
    }
}