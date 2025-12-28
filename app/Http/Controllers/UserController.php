<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::with('role')->orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        return view('users.create', [
            'roles' => Role::orderBy('role')->get()
        ]);
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'role_id'   => 'required|exists:roles,id',
            'password'  => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        return view('users.edit', [
            'user'  => User::findOrFail($id),
            'roles' => Role::orderBy('role')->get()
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role_id' => 'required|exists:roles,id',
            'password'=> 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        // password hanya diubah jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // optional: cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
