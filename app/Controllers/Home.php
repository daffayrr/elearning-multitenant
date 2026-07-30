<?php

namespace App\Controllers;

use App\Models\TenantModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    public function index(): string
    {
        return view('t_landing');
    }

    public function globalLogin(): string
    {
        return view('global_login');
    }

    public function registerInstitution(): string
    {
        return view('register_institution');
    }

    public function storeInstitution(): RedirectResponse
    {
        $tenantModel = new TenantModel();
        $userModel = new UserModel();
        
        $rules = [
            'tenant_name'    => 'required|min_length[3]|max_length[150]|trim',
            'url_string'     => [
                'rules' => 'required|alpha_dash|min_length[3]|max_length[100]|is_unique[tenants.tenant_string_id]',
                'errors' => [
                    'is_unique'  => 'URL Identifier sudah digunakan oleh institusi lain.',
                    'alpha_dash' => 'URL Identifier hanya boleh berisi huruf, angka, strip, dan underscore.',
                ],
            ],
            'domain'         => 'permit_empty|valid_url_strict|max_length[255]',
            'admin_name'     => 'required|min_length[3]|max_length[100]|trim',
            'admin_email'    => 'required|valid_email|max_length[255]',
            'admin_password' => [
                'rules' => 'required|min_length[8]|max_length[128]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
                ],
            ],
            'admin_password_confirm' => 'required|matches[admin_password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tenantName   = trim($this->request->getPost('tenant_name'));
        $urlString    = strtolower(trim($this->request->getPost('url_string')));
        $domain       = $this->request->getPost('domain') ?: null;
        $adminName    = trim($this->request->getPost('admin_name'));
        $adminEmail   = strtolower(trim($this->request->getPost('admin_email')));
        $adminPassword= (string) $this->request->getPost('admin_password');

        $emailExistsAsAdmin = $userModel
            ->where('email', $adminEmail)
            ->where('role', 'tenant_admin')
            ->first();

        if ($emailExistsAsAdmin) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['admin_email' => 'Email admin sudah digunakan oleh institusi lain.']);
        }

        $db = db_connect();
        $db->transStart();

        try {
            $tenantId = $tenantModel->insert([
                'name'             => $tenantName,
                'tenant_string_id' => $urlString, 
                'domain'           => $domain,
                'status'           => 'active',
            ], true);

            if (! $tenantId) {
                throw new \RuntimeException('Gagal menyimpan data institusi.');
            }

            $userInserted = $userModel->insert([
                'tenant_id'     => $tenantId,
                'full_name'     => $adminName, 
                'username'      => $urlString . '_admin', 
                'email'         => $adminEmail,
                'password_hash' => password_hash($adminPassword, PASSWORD_BCRYPT, ['cost' => 12]), 
                'role'          => 'tenant_admin',
                'is_blocked'    => 0,
            ]);

            if (! $userInserted) {
                throw new \RuntimeException('Gagal menyimpan akun Admin.');
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi database gagal di-commit.');
            }

            return redirect()->to('/' . $urlString . '/login')
                ->with('message', "Institusi '{$tenantName}' berhasil didaftarkan. Silakan login sebagai Admin.");

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }
}
