<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Menampilkan halaman pengguna
    public function index()
    {
        $users = User::whereIn('role', ['customer', 'fotografer', 'admin'])->get();
        return view('admin.data.user', [
            'title' => 'Daftar Pengguna',
            'users' => $users
        ]);
    }

    // Menampilkan form untuk membuat pengguna baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:customer,fotografer,admin',
            'nomor_telepon' => 'nullable|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat pengguna baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->role == 'customer') {
            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->nomor_telepon = $request->nomor_telepon;
            $customer->save();
        } elseif ($request->role == 'fotografer') {
            $fotografer = new Fotografer();
            $fotografer->user_id = $user->id;
            $fotografer->nomor_telepon = $request->nomor_telepon;
            $fotografer->save();
        }

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,fotografer,admin',
            'nomor_telepon' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();

        if ($request->role == 'customer') {
            $user->customer->nomor_telepon = $request->nomor_telepon;
            $user->customer->save();
        } elseif ($request->role == 'fotografer') {
            $user->fotografer->nomor_telepon = $request->nomor_telepon;
            $user->fotografer->save();
        }

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Menampilkan detail pengguna
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($user->role == 'customer') {
            $user->customer()->delete();
        } elseif ($user->role == 'fotografer') {
            $user->fotografer()->delete();
        }

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
