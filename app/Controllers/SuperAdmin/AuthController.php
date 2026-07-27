<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function loginForm(): string|RedirectResponse
    {
        if (session()->has('user_id') && session()->get('role') === 'super_admin') {
            return redirect()->to('/superadmin/dashboard');
        }

        return view('superadmin/login', ['pageTitle' => 'Super Admin Login']);
    }

    public function loginProcess(): RedirectResponse
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $user = $userModel
            ->where('email', $this->request->getPost('email'))
            ->where('role', 'super_admin')
            ->where('is_blocked', 0)
            ->first();

        // Menggunakan $user->password_hash karena returnType pada UserModel adalah 'object'
        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user->password_hash)) {
            return redirect()->back()->withInput()
                ->with('error', 'Email atau password tidak valid.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id'      => $user->id,
            'tenant_id'    => null,
            'role'         => 'super_admin',
            'name'         => $user->full_name, // Disesuaikan dengan nama kolom di database
            'email'        => $user->email,
            'is_logged_in' => true,
        ]);

        return redirect()->to('/superadmin/dashboard');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/superadmin/login')
            ->with('message', 'Anda telah berhasil keluar.');
    }
}