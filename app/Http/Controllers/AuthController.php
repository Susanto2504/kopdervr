<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->has('pengguna_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required',
        ]);

        // Cari pengguna berdasarkan email
        $pengguna = Pengguna::where('email', $request->email)->first();

        // Periksa email dan password
        if (
            !$pengguna ||
            !Hash::check($request->kata_sandi, $pengguna->kata_sandi)
        ) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau kata sandi salah!');
        }

        // Periksa hak akses Admin
        if (strtolower(trim($pengguna->peran)) !== 'admin') {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Akun ini tidak memiliki akses Admin!');
        }

        // Regenerasi session
        $request->session()->regenerate();

        // Simpan informasi pengguna
        session([
            'pengguna_id' => $pengguna->id,
            'pengguna_nama' => $pengguna->nama,
            'pengguna_peran' => $pengguna->peran,
        ]);

        // Arahkan ke dashboard
        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang, ' . $pengguna->nama . '!');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout!');
    }
}
