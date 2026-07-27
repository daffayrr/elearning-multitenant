<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    protected UserModel $userModel;
    protected TenantModel $tenantModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->tenantModel = new TenantModel();
    }

    // ─────────────────────────────────────────────────────────────────────
    // LOGIN FORM
    // Fix P1006 & PHP0408: return type diubah ke ResponseInterface|string
    // karena method bisa return redirect (RedirectResponse) ATAU view (string)
    // ─────────────────────────────────────────────────────────────────────
    public function loginForm(string $tenantStringId): RedirectResponse|string
    {
        if (session()->has('user_id')) {
            // Sudah login — redirect ke area sesuai role
            return $this->redirectByRole($tenantStringId);
        }

        return view('auth/login', [
            'tenant_string_id' => $tenantStringId,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // LOGIN PROCESS
    // ─────────────────────────────────────────────────────────────────────
    public function loginProcess(string $tenantStringId): RedirectResponse
    {
        $rules = [
            'email'    => 'required|valid_email|max_length[255]',
            'password' => 'required|min_length[8]|max_length[128]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // ─── Validasi tenant dari URL ─────────────────────────────────────
        $tenant = $this->tenantModel
            ->where('url_string', $tenantStringId)
            ->where('is_active', 1)
            ->first();

        if (! $tenant) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tenant tidak valid.');
        }

        // ─── Cari user: email + tenant_id (isolasi multi-tenant) ─────────
        $user = $this->userModel
            ->where('email', $email)
            ->where('tenant_id', $tenant['id'])
            ->where('is_blocked', 0)
            ->first();

        // ─── Verifikasi password (bcrypt) ─────────────────────────────────
        // Pesan error generik agar tidak membocorkan info validasi
        if (! $user || ! password_verify($password, $user['password'])) {
            log_message('info', sprintf(
                '[Auth] Gagal login. Email: %s | Tenant: %s | IP: %s',
                $email,
                $tenantStringId,
                $this->request->getIPAddress()
            ));

            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password tidak valid.');
        }

        // ─── Regenerate session ID (cegah session fixation attack) ───────
        session()->regenerate(true);

        // ─── Set session ──────────────────────────────────────────────────
        session()->set([
            'user_id'           => $user['id'],
            'tenant_id'         => $user['tenant_id'],
            'role'              => $user['role'],
            'name'              => $user['name'],
            'email'             => $user['email'],
            'tenant_string_id'  => $tenantStringId,
            'is_logged_in'      => true,
        ]);

        log_message('info', sprintf(
            '[Auth] Login sukses. User ID: %s | Role: %s | Tenant: %s | IP: %s',
            $user['id'],
            $user['role'],
            $tenantStringId,
            $this->request->getIPAddress()
        ));

        return $this->redirectByRole($tenantStringId);
    }

    // ─────────────────────────────────────────────────────────────────────
    // LOGOUT
    // ─────────────────────────────────────────────────────────────────────
    public function logout(string $tenantStringId): RedirectResponse
    {
        session()->destroy();

        return redirect()->to("/{$tenantStringId}/login")
            ->with('message', 'Anda telah berhasil keluar.');
    }

    // ─────────────────────────────────────────────────────────────────────
    // REGISTER FORM
    // ─────────────────────────────────────────────────────────────────────
    public function registerForm(string $tenantStringId): string
    {
        return view('auth/register', [
            'tenant_string_id' => $tenantStringId,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // REGISTER PROCESS
    // ─────────────────────────────────────────────────────────────────────
    public function registerProcess(string $tenantStringId): RedirectResponse
    {
        $tenant = $this->tenantModel
            ->where('url_string', $tenantStringId)
            ->where('is_active', 1)
            ->first();

        if (! $tenant) {
            return redirect()->back()->with('error', 'Tenant tidak valid.');
        }

        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|max_length[255]',
            'password'         => 'required|min_length[8]|max_length[128]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $existing = $this->userModel
            ->where('email', $this->request->getPost('email'))
            ->where('tenant_id', $tenant['id'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah terdaftar di tenant ini.');
        }

        $this->userModel->insert([
            'tenant_id'  => $tenant['id'],
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash(
                $this->request->getPost('password'),
                PASSWORD_BCRYPT,
                ['cost' => 12]
            ),
            'role'       => 'tenant_student',
            'is_blocked' => 0,
        ]);

        return redirect()->to("/{$tenantStringId}/login")
            ->with('message', 'Registrasi berhasil. Silakan login.');
    }

    // ─────────────────────────────────────────────────────────────────────
    // HELPER: Redirect berdasarkan role
    // ─────────────────────────────────────────────────────────────────────
    private function redirectByRole(string $tenantStringId): RedirectResponse
    {
        $role = session()->get('role');

        $map = [
            'super_admin'       => '/superadmin/dashboard',
            'tenant_admin'      => "/{$tenantStringId}/admin_tenant/dashboard",
            'tenant_instructor' => "/{$tenantStringId}/instructor/dashboard",
            'tenant_student'    => "/{$tenantStringId}/student/dashboard",
        ];

        $destination = $map[$role] ?? "/{$tenantStringId}/login";

        return redirect()->to($destination);
    }
}