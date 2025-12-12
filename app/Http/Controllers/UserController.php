<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }


    public function create()
    {
        return view('users.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'department' => 'required', // <--- TAMBAHKAN VALIDASI INI
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department' => $request->department, // <--- TAMBAHKAN BARIS INI
            // 'avatar' => null (jika ada)
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

 
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

 
   public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'department' => 'required', // <--- TAMBAHKAN VALIDASI INI
        ]);

        // Siapkan data update
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department' => $request->department, // <--- TAMBAHKAN BARIS INI
        ];

        // Cek jika password diisi (jika kosong, jangan update password)
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }    
    public function destroy(User $user)
    {
        if (Auth::id() == $user->id) {
             return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function show($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);
        
        // Tampilkan view detail
        return view('users.show', compact('user'));
    }
}