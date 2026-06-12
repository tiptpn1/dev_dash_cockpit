<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomUser;

class PasswordController extends Controller
{
    /**
     * Show the form to change the user password.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.min' => 'Password baru minimal harus 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::guard('custom')->user();

        // Cek apakah password lama sesuai
        // Menggunakan Hash::check() dan juga fallback plain-text sesuai di CustomUserProvider
        $currentPasswordMatch = false;
        if (Hash::check($request->current_password, $user->password) || $user->password === $request->current_password) {
            $currentPasswordMatch = true;
        }

        if (!$currentPasswordMatch) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        // Update password baru
        $dbUser = CustomUser::find($user->id);
        $dbUser->password = Hash::make($request->new_password);
        $dbUser->save();

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
