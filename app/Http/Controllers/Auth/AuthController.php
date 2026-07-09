<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ParentUser;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $user = Auth::user();

        // Guru dengan status pending ditolak walau kredensial benar (SRS-05: approveTeacher).
        if (! $user->isActive()) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda belum aktif atau masih menunggu persetujuan admin.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathForRole($user->role));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:teacher,student,parent'],
            'nis' => ['nullable', 'required_if:role,student', 'string', 'max:30', 'unique:students,nis'],
            'nip' => ['nullable', 'required_if:role,teacher', 'string', 'max:30', 'unique:teachers,nip'],
        ]);

        // Guru: status pending menunggu approval admin (ELIW-03 / SRS-05).
        // Murid & Wali murid: langsung aktif (sesuai use case scenario Register, C200 Tabel 2.3).
        $status = $data['role'] === 'teacher' ? 'pending' : 'active';

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => $status,
        ]);

        match ($data['role']) {
            'teacher' => Teacher::create([
                'user_id' => $user->id,
                'nip' => $data['nip'],
            ]),
            'student' => Student::create([
                'user_id' => $user->id,
                'nis' => $data['nis'],
                'academic_status' => 'active',
            ]),
            'parent' => ParentUser::create([
                'user_id' => $user->id,
            ]),
        };

        if ($data['role'] === 'teacher') {
            return redirect()->route('login')->with(
                'status',
                'Registrasi berhasil. Akun guru Anda menunggu persetujuan admin sebelum bisa login.'
            );
        }

        Auth::login($user);

        return redirect($this->redirectPathForRole($user->role));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function redirectPathForRole(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'student' => route('student.dashboard'),
            'parent' => route('parent.dashboard'),
            default => route('login'),
        };
    }
}
