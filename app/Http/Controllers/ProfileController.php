<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Halaman profil saya
    public function show()
    {
        $user = User::findOrFail(Auth::id());

        return view('profile.show', ['user' => $user]);
    }

    // Form pengaturan akun (ubah nama/email)
    public function edit()
    {
        $user = User::findOrFail(Auth::id());

        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->fill($validated);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    // Form ubah kata sandi
    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Kata sandi berhasil diubah.');
    }

    // Riwayat aktivitas milik pengguna yang sedang login (bukan seluruh audit log)
    public function activity(Request $request)
    {
        $logs = AuditLog::where('user_name', User::findOrFail(Auth::id())->name)
            ->latest()
            ->paginate(15);

        return view('profile.activity', compact('logs'));
    }
}
