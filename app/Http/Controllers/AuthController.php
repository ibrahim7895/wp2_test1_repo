<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use App\Models\User;

class AuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     * المطلب 1: الواجهة ستكون باللغة الإنجليزية LTR
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('warehouses.index');
        }
        return view('auth.login');
    }

    /**
     * منطق تسجيل الدخول
     */
    public function login(Request $request)
    {
        // 1. التحقق من المدخلات (Validation)
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        /**
         * 2. البحث في جدول USERS
         * ملاحظة أمنية: يفضل دائماً استخدام Hash::check، 
         * لكن سأبقي الكود كما أرسلته ليتناسب مع بياناتك اليدوية الحالية.
         */
        $user = User::where('username', $request->username)
                    ->where('password', $request->password) 
                    ->first();

        if ($user) {
            // 3. تسجيل الدخول يدوياً
            Auth::login($user);
            
            // 4. تحديث الجلسة (Session Management)
            // هذا يمنع مشكلة "الخروج المفاجئ" التي واجهتك سابقاً
            $request->session()->regenerate();
            
            /**
             * 5. التوجه إلى الصفحة المقصودة
             * تم تعديل المسار ليتوجه إلى index الخاص بالمستودعات مباشرة
             */
            return redirect()->intended(route('warehouses.index')); 
        }

        // 6. رسالة الخطأ باللغة الإنجليزية (المطلب 1)
        return back()->withErrors([
            'username' => 'Invalid credentials. Please check your username and password.',
        ])->onlyInput('username');
    }

    /**
     * تسجيل الخروج وتطهير الجلسة
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
=======
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

        //جلب المستخدم من DB
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
>>>>>>> origin/dev2
    }
}