<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan semua pengguna
    public function index()
    {
        $user = Auth::user(); 
        $users = User::select('users.*', 'customers.nomor_telepon AS customer_phone', 'fotografer.nomor_telepon AS fotografer_phone')
            ->leftJoin('customers', 'users.id', '=', 'customers.user_id')
            ->leftJoin('fotografer', 'users.id', '=', 'fotografer.user_id')
            ->whereIn('role', ['customer', 'fotografer', 'admin'])
            ->get();

        $title = "Data Pengguna";

        return view('admin.data.user', compact('users', 'title', 'user'));
    }

    // Menampilkan form untuk menambah pengguna
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan data pengguna
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:customer,admin,fotografer',
            'nomor_telepon' => 'required|string|max:15',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'customer') {
            Customer::create([
                'user_id' => $user->id,
                'nomor_telepon' => $request->nomor_telepon,
            ]);
        } elseif ($user->role === 'fotografer') {
            Fotografer::create([
                'user_id' => $user->id,
                'nomor_telepon' => $request->nomor_telepon,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|in:customer,fotografer,admin',
            'nomor_telepon' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6',
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Update password jika ada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan data user
        $user->save();

        // Update data tambahan berdasarkan role
        if ($request->role == 'customer') {
            $customer = Customer::updateOrCreate(
                ['user_id' => $user->id],
                ['nomor_telepon' => $request->nomor_telepon]
            );
        } elseif ($request->role == 'fotografer') {
            $fotografer = Fotografer::updateOrCreate(
                ['user_id' => $user->id],
                ['nomor_telepon' => $request->nomor_telepon]
            );
        }

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Mengupdate data pengguna
    public function updateProfile(Request $request, $id)
    {
        // Ambil data user
        $user = User::findOrFail($id);
    
        // Tentukan aturan validasi
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'nomor_telepon' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ];
    
        // Validasi input
        $request->validate($rules);
    
        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
    
        // Simpan atau update foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto'), $filename);
    
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path('uploads/foto/' . $user->foto))) {
                unlink(public_path('uploads/foto/' . $user->foto));
            }
    
            $user->update(['foto' => $filename]);
        }
    
        // Update data tambahan untuk customer atau fotografer
        if ($user->role === 'customer') {
            Customer::updateOrCreate(
                ['user_id' => $user->id],
                ['nomor_telepon' => $request->nomor_telepon]
            );
        } elseif ($user->role === 'fotografer') {
            Fotografer::updateOrCreate(
                ['user_id' => $user->id],
                ['nomor_telepon' => $request->nomor_telepon]
            );
        }
    
        // Redirect ke profil sesuai role
        if ($user->role === 'customer') {
            return redirect()->route('profile.customer')->with('success', 'Profile updated successfully');
        } elseif ($user->role === 'fotografer') {
            return redirect()->route('profile.fotografer')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('profile.admin')->with('success', 'Profile updated successfully');
        }
    }
    


    public function profileAdmin()
{
    $user = Auth::user();

    // Mengambil data admin jika ada (tidak memerlukan tabel tambahan karena admin biasanya hanya di tabel users)
    $title = "Profil Admin";

    return view('profile.admin', compact('user', 'title'));
}

public function profileFotografer()
{
    $user = Auth::user();

    // Mengambil data fotografer dengan nomor telepon dari tabel fotografer
    $fotografer = Fotografer::where('user_id', $user->id)->first();

    $title = "Profil Fotografer";

    return view('profile.fotografer', compact('user', 'fotografer', 'title'));
}

public function profileCustomer()
{
    $user = Auth::user();

    // Mengambil data customer dengan nomor telepon dari tabel customers
    $customer = Customer::where('user_id', $user->id)->first();

    $title = "Profil Customer";

    return view('profile.customer', compact('user', 'customer', 'title'));
}


    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->customer()->delete();
        $user->fotografer()->delete();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
