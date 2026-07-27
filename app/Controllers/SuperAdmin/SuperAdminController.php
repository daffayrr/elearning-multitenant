<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\TenantModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\RedirectResponse;

class SuperAdminController extends BaseController
{
    protected TenantModel $tenantModel;
    protected UserModel   $userModel;

    public function __construct()
    {
        $this->tenantModel = new TenantModel();
        $this->userModel   = new UserModel();
    }

    // ═════════════════════════════════════════════════════════════════════
    // DASHBOARD
    // ═════════════════════════════════════════════════════════════════════
    public function index(): string
    {
        $db = db_connect();

        // Statistik ringkasan — query COUNT langsung agar efisien
        // Ubah is_active, 1 menjadi status, 'active'
        $stats = [
            'total_tenants'  => $this->tenantModel->countAll(),
            'active_tenants' => $this->tenantModel->where('status', 'active')->countAllResults(),
            'total_users'    => $this->userModel->where('role !=', 'super_admin')->countAllResults(),
            'total_courses'  => $db->table('courses')->countAll(),
        ];

        // List tenant terbaru (10 terakhir)
        $tenants = $this->tenantModel
            ->orderBy('created_at', 'DESC')
            ->findAll(10);

        // Jumlah user per tenant (untuk ditampilkan di tabel)
        $userCounts = [];
        foreach ($tenants as $tenant) {
            // Akses object properti ->id (karena returnType 'object')
            $userCounts[$tenant->id] = $this->userModel
                ->where('tenant_id', $tenant->id)
                ->countAllResults();
        }

        return view('superadmin/dashboard', [
            'stats'       => $stats,
            'tenants'     => $tenants,
            'userCounts'  => $userCounts,
            'pageTitle'   => 'Super Admin Dashboard',
        ]);
    }

    // ═════════════════════════════════════════════════════════════════════
    // TENANT LIST
    // ═════════════════════════════════════════════════════════════════════
    public function tenantList(): string
    {
        $tenants = $this->tenantModel
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('superadmin/tenant_list', [
            'tenants'   => $tenants,
            'pager'     => $this->tenantModel->pager,
            'pageTitle' => 'Daftar Tenant',
        ]);
    }

    // ═════════════════════════════════════════════════════════════════════
    // CREATE TENANT — tampilkan form
    // ═════════════════════════════════════════════════════════════════════
    public function createTenant(): string
    {
        return view('superadmin/tenant_create', [
            'pageTitle'  => 'Tambah Tenant Baru',
            'validation' => service('validation'),
        ]);
    }

    // ═════════════════════════════════════════════════════════════════════
    // STORE TENANT — simpan dengan transaction
    // ═════════════════════════════════════════════════════════════════════
    public function storeTenant(): RedirectResponse
    {
        // ─── Aturan validasi ──────────────────────────────────────────────
        $rules = [
            'tenant_name'    => [
                'label' => 'Nama Tenant',
                'rules' => 'required|min_length[3]|max_length[150]|trim',
            ],
            'url_string'     => [
                'label' => 'URL Identifier',
                'rules' => 'required|alpha_dash|min_length[3]|max_length[100]'
                         . '|is_unique[tenants.tenant_string_id]', // <--- UBAH DI SINI
                'errors' => [
                    'is_unique'  => 'URL Identifier sudah digunakan oleh tenant lain.',
                    'alpha_dash' => 'URL Identifier hanya boleh berisi huruf, angka, strip, dan underscore.',
                ],
            ],
            'domain'         => [
                'label' => 'Domain (opsional)',
                'rules' => 'permit_empty|valid_url_strict|max_length[255]',
            ],
            // ─── Data Tenant Admin perdana ────────────────────────────────
            'admin_name'     => [
                'label' => 'Nama Admin',
                'rules' => 'required|min_length[3]|max_length[100]|trim',
            ],
            'admin_email'    => [
                'label' => 'Email Admin',
                'rules' => 'required|valid_email|max_length[255]',
                'errors' => [
                    'valid_email' => 'Format email Admin tidak valid.',
                ],
            ],
            'admin_password' => [
                'label' => 'Password Admin',
                'rules' => 'required|min_length[8]|max_length[128]'
                         . '|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
                ],
            ],
            'admin_password_confirm' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[admin_password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // ─── Ambil data yang sudah lolos validasi ─────────────────────────
        $tenantName   = trim($this->request->getPost('tenant_name'));
        $urlString    = strtolower(trim($this->request->getPost('url_string')));
        $domain       = $this->request->getPost('domain') ?: null;
        $adminName    = trim($this->request->getPost('admin_name'));
        $adminEmail   = strtolower(trim($this->request->getPost('admin_email')));
        $adminPassword= (string) $this->request->getPost('admin_password');

        // ─── Cek duplikat email admin di level global ─────────────────────
        // (is_unique di validasi hanya berlaku untuk kolom tenant, bukan users)
        $emailExistsAsAdmin = $this->userModel
            ->where('email', $adminEmail)
            ->where('role', 'tenant_admin')
            ->first();

        if ($emailExistsAsAdmin) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['admin_email' => 'Email admin sudah digunakan di tenant lain.']);
        }

        $db = db_connect();

        // ─── DATABASE TRANSACTION ─────────────────────────────────────────
        // Jika insert user gagal, insert tenant juga di-rollback otomatis
        $db->transStart();

        try {
            // 1. Insert tenant
           // Ubah 'is_active' => 1 menjadi 'status' => 'active'
           $tenantId = $this->tenantModel->insert([
            'name'               => $tenantName,
            'tenant_string_id'   => $urlString, // Sesuai DDL (jika di DB Anda menggunakan url_string, biarkan url_string)
            'domain'             => $domain,
            'status'             => 'active',
        ], true);

            if (! $tenantId) {
                throw new \RuntimeException('Gagal menyimpan data tenant.');
            }

            // 2. Insert tenant admin perdana
            // Tidak melalui model callback hashPassword karena password
            // sudah di-hash eksplisit di sini untuk kontrol penuh
            $userInserted = $this->userModel->insert([
                'tenant_id'  => $tenantId,
                'full_name'  => $adminName, // Disesuaikan dengan struktur tabel users: full_name (bukan name)
                'username'   => $urlString . '_admin', // Menambahkan default username karena wajib di database
                'email'      => $adminEmail,
                'password_hash' => password_hash($adminPassword, PASSWORD_BCRYPT, ['cost' => 12]), // Disesuaikan ke password_hash
                'role'       => 'tenant_admin',
                'is_blocked' => 0,
            ]);

            if (! $userInserted) {
                throw new \RuntimeException('Gagal menyimpan akun Tenant Admin.');
            }

            // 3. Commit jika semua berhasil
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi database gagal di-commit.');
            }

            log_message('info', sprintf(
                '[SuperAdmin] Tenant baru dibuat. ID: %d | Name: %s | Admin: %s | Oleh: %s',
                $tenantId,
                $tenantName,
                $adminEmail,
                session()->get('email') ?? 'Super Admin'
            ));

            return redirect()->to('/superadmin/tenants')
                ->with('success', "Tenant '{$tenantName}' berhasil dibuat beserta akun admin.");

        } catch (\RuntimeException $e) {
            $db->transRollback();
            log_message('error', '[SuperAdmin] storeTenant gagal: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat tenant: ' . $e->getMessage());

        } catch (DatabaseException $e) {
            $db->transRollback();
            log_message('error', '[SuperAdmin] DatabaseException storeTenant: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database. Silakan coba lagi.');

        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', '[SuperAdmin] Exception tidak terduga storeTenant: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan tidak terduga. Silakan coba lagi.');
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // TOGGLE BLOCK TENANT
    // ═════════════════════════════════════════════════════════════════════
    public function toggleBlockTenant(int $id): RedirectResponse
    {
        $tenant = $this->tenantModel->find($id);

        if (! $tenant) {
            return redirect()->to('/superadmin/tenants')
                ->with('error', 'Tenant tidak ditemukan.');
        }

        // Toggle status: 'active' → 'blocked'
        $newStatus  = $tenant->status === 'active' ? 'blocked' : 'active';
        $statusText = $newStatus === 'active' ? 'diaktifkan' : 'diblokir';

        $this->tenantModel->update($id, ['status' => $newStatus]);

        log_message('info', sprintf(
            '[SuperAdmin] Tenant ID %d (%s) %s oleh User ID %s.',
            $id,
            $tenant->name,
            $statusText,
            session()->get('user_id') ?? 'System'
        ));

        return redirect()->to('/superadmin/tenants')
            ->with('success', "Tenant '{$tenant->name}' berhasil {$statusText}.");
    }

    // ═════════════════════════════════════════════════════════════════════
    // SHOW TENANT DETAIL
    // ═════════════════════════════════════════════════════════════════════
    public function showTenant(int $id): string|RedirectResponse
    {
        $tenant = $this->tenantModel->find($id);

        if (! $tenant) {
            return redirect()->to('/superadmin/tenants')
                ->with('error', 'Tenant tidak ditemukan.');
        }

         $users = $this->userModel
            ->where('tenant_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('superadmin/tenant_detail', [
            'tenant'    => $tenant,
            'users'     => $users,
            'pageTitle' => 'Detail Tenant: ' . $tenant->name,
        ]);
    }
}