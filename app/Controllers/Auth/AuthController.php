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
    // TENANT ROOT INDEX
    // ─────────────────────────────────────────────────────────────────────
    public function tenantIndex(string $tenantStringId): RedirectResponse
    {
        $tenant = $this->tenantModel->where('tenant_string_id', $tenantStringId)->where('status', 'active')->first();
        if (!$tenant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan.');
        }

        if (session()->has('user_id')) {
            // Sudah login — redirect ke area sesuai role
            return $this->redirectByRole($tenantStringId);
        }

        // Belum login — redirect ke login page
        return redirect()->to("/$tenantStringId/login");
    }

    // ─────────────────────────────────────────────────────────────────────
    // LOGIN FORM
    // Fix P1006 & PHP0408: return type diubah ke ResponseInterface|string
    // karena method bisa return redirect (RedirectResponse) ATAU view (string)
    // ─────────────────────────────────────────────────────────────────────
    public function loginForm(string $tenantStringId): RedirectResponse|string
    {
        $tenant = $this->tenantModel->where('tenant_string_id', $tenantStringId)->where('status', 'active')->first();
        if (!$tenant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan.');
        }

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
            'password' => 'required|max_length[128]',
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
            ->where('tenant_string_id', $tenantStringId)
            ->where('status', 'active')
            ->first();

        if (! $tenant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan.');
        }

        // ─── Cari user: email + tenant_id (isolasi multi-tenant) ─────────
        $user = $this->userModel
            ->where('email', $email)
            ->where('tenant_id', $tenant->id)
            ->where('is_blocked', 0)
            ->first();

        // ─── Verifikasi password (bcrypt) ─────────────────────────────────
        // Pesan error generik agar tidak membocorkan info validasi
        if (! $user || ! password_verify($password, $user->password_hash)) {
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
            'user_id'           => $user->id,
            'tenant_id'         => $user->tenant_id,
            'role'              => $user->role,
            'name'              => $user->full_name,
            'email'             => $user->email,
            'tenant_string_id'  => $tenantStringId,
            'is_logged_in'      => true,
        ]);

        log_message('info', sprintf(
            '[Auth] Login sukses. User ID: %s | Role: %s | Tenant: %s | IP: %s',
            $user->id,
            $user->role,
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
        $tenant = $this->tenantModel->where('tenant_string_id', $tenantStringId)->where('status', 'active')->first();
        if (!$tenant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan.');
        }

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
            ->where('tenant_string_id', $tenantStringId)
            ->where('status', 'active')
            ->first();

        if (! $tenant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan.');
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
            ->where('tenant_id', $tenant->id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah terdaftar di tenant ini.');
        }

        $this->userModel->insert([
            'tenant_id'     => $tenant->id,
            'full_name'     => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_BCRYPT,
                ['cost' => 12]
            ),
            'role'          => 'student',
            'is_blocked'    => 0,
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
            'super_admin'  => '/superadmin/dashboard',
            'tenant_admin' => "/{$tenantStringId}/admin_tenant/dashboard",
            'instructor'   => "/{$tenantStringId}/instructor/dashboard",
            'student'      => "/{$tenantStringId}/student/dashboard",
        ];

        if (!isset($map[$role])) {
            session()->destroy();
            return redirect()->to("/{$tenantStringId}/login")->with('error', 'Sesi tidak valid, silakan login kembali.');
        }

        return redirect()->to($map[$role]);
    }
}