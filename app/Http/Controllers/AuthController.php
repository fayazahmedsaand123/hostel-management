<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller {

    // Show Login
    public function Login() {
        return view('auth.login');
    }

    // Login POST
    public function Login_Post(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];
        if(Auth::attempt($credentials, $request->remember)) {
            return redirect()->route('home');
        }
        return back()->with('error', 'Invalid email or password!');
    }

    // Show Register
    public function Register() {
        return view('auth.register');
    }

    // Register POST
    public function Register_Post(Request $request) {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('login')->with('success', 'Registered successfully! Please login.');
    }

    // Show Forgot Password
    public function Forgot() {
        return view('auth.forgot');
    }

    // Forgot POST — Send Email
    public function Forgot_Post(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Password reset link sent to your email!');
        }
        return back()->with('error', 'Failed to send email. Try again!');
    }

    // Show Reset Password
    public function Reset(Request $request, $token) {
        return view('auth.reset', ['token' => $token, 'email' => $request->email]);
    }

    // Reset POST — Save New Password
    public function Reset_Post(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token'    => 'required'
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
        if($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password reset successfully! Please login.');
        }
        return back()->with('error', 'Invalid or expired reset link!');
    }

    // Change Password
    public function Change_Password(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);
        $user = Auth::user();
        // Check current password correct
        if(!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect!'
            ], 422);
        }
        // Check new password same as old
        if(Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'New password cannot be same as current password!'
            ], 422);
        }
        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully!'
        ]);
    }

    // Logout
    public function Logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}