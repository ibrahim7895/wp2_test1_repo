<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




// تحديث وقت النشاط
session(['last_activity' => time()]);

class AuthController extends Controller
{
    // عرض صفحة اللوجين
    public function showLogin()
    {
        return view('login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // 🔥 جلب المستخدم من DB
        $user = DB::table('user')
            ->where('username', $username)
            ->first();

        // تحقق
        if ($user && $user->password == $password) {

            // تخزين بالسيشن
            session([
                'user' => $user,
                'last_activity' => time()
            ]);
            return redirect()->route('hr.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }
    
    // تسجيل الخروج
    public function logout()
    {
        session()->forget('user');
        return redirect('/login');
    }
}