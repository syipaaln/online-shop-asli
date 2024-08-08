<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Checkout;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class homecontroller extends controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function dashboard() {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;

        $salesToday = Pembelian::whereDate('created_at', $today)->count();
        $usersToday = User::whereDate('created_at', $today)->count();
        $salesThisMonth = Pembelian::whereMonth('created_at', $thisMonth)->count();
        $usersThisMonth = User::whereMonth('created_at', $thisMonth)->count();

        $totalRevenueToday = Pembelian::whereDate('created_at', $today)->sum('total_harga');
        $totalRevenueThisMonth = Pembelian::whereMonth('created_at', $thisMonth)->sum('total_harga');

        return view('home', compact(
            'salesToday', 'usersToday', 'salesThisMonth', 'usersThisMonth',
            'totalRevenueToday', 'totalRevenueThisMonth'
        ));
    }
    public function adminHome() {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;

        $salesToday = Pembelian::whereDate('created_at', $today)->count();
        $usersToday = User::whereDate('created_at', $today)->count();
        $salesThisMonth = Pembelian::whereMonth('created_at', $thisMonth)->count();
        $usersThisMonth = User::whereMonth('created_at', $thisMonth)->count();

        $totalRevenueToday = Pembelian::whereDate('created_at', $today)->sum('total_harga');
        $totalRevenueThisMonth = Pembelian::whereMonth('created_at', $thisMonth)->sum('total_harga');

        return view('adminHome', compact(
            'salesToday', 'usersToday', 'salesThisMonth', 'usersThisMonth',
            'totalRevenueToday', 'totalRevenueThisMonth'
        ));
    }
    
    public function user() {
        return view('home');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cartCount = 0;
        if (Auth::check()) {
            $userId = Auth::id();
            $cartCount = Checkout::where('user_id', $userId)->sum('quantity');
        }

        return view('home', compact('cartCount'));
    }

    // public function superadminDashboard()
    // {
    //     $today = Carbon::today();
    //     $thisMonth = Carbon::now()->month;

    //     $salesToday = Pembelian::whereDate('created_at', $today)->count();
    //     $usersToday = User::whereDate('created_at', $today)->count();
    //     $salesThisMonth = Pembelian::whereMonth('created_at', $thisMonth)->count();
    //     $usersThisMonth = User::whereMonth('created_at', $thisMonth)->count();

    //     $totalRevenueToday = Pembelian::whereDate('created_at', $today)->sum('total_harga');
    //     $totalRevenueThisMonth = Pembelian::whereMonth('created_at', $thisMonth)->sum('total_harga');

    //     return view('adminHome', compact(
    //         'salesToday', 'usersToday', 'salesThisMonth', 'usersThisMonth',
    //         'totalRevenueToday', 'totalRevenueThisMonth'
    //     ));
    // }
    
    public function manageUser() {
        $users = User::all();
        return view('superadmin.manageUser', compact('users'));
    }

    public function superadminSearchUser(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('alamat', 'LIKE', "%{$query}%")
                            ->get();

        return view('superadmin.manageUser', compact('users'));
    }

    public function manageUserCreate() {
        return view('superadmin.manageUserCreate');
    }

    public function registerUser(Request $request)
    {
        // Validasi data pengguna
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:user,admin,superadmin',
        ]);

        // Jika validasi gagal, kembali ke halaman pendaftaran dengan pesan kesalahan
        if ($validator->fails()) {
            return redirect('/manage-user/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Buat pengguna baru jika validasi berhasil
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect pengguna setelah pendaftaran
        return redirect('/manage-user');
    }

    public function manageUserDelete(User $user) {
        $user->delete();
        return redirect()->back()->with('success', 'Berhasil Hapus User');
    }

    public function manageUserUpdate(Request $request, User $user) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:user,admin,superadmin', // Tambahkan validasi untuk bidang lainnya
        ]);
    
        $user->update($request->all());
    
        return redirect('/manage-user')->with('success', 'Berhasil Ubah User');
    }

    public function manageUserEdit(User $user)
    {
        return view('superadmin.manageUserEdit', compact('user'));
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userHome()
    {
        return view('user.home');
    }
}
