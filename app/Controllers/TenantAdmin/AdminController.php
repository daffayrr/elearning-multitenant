<?php

namespace App\Controllers\TenantAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index(string $tenantStringId)
    {
        $userModel = new UserModel();
        $tenantId = session()->get('current_tenant_id');
        
        $admins = $userModel
            ->where('tenant_id', $tenantId)
            ->where('role', 'tenant_admin')
            ->findAll();
            
        return view('tenant_admin/admins/index', [
            'admins' => $admins, 
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Kelola Admin'
        ]);
    }

    public function store(string $tenantStringId)
    {
        $userModel = new UserModel();
        $tenantId = session()->get('current_tenant_id');
        
        $userModel->insert([
            'tenant_id'     => $tenantId,
            'role'          => 'tenant_admin',
            'full_name'     => $this->request->getPost('full_name'),
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);
        
        return redirect()->back()->with('message', 'Admin berhasil ditambahkan.');
    }

    public function delete(string $tenantStringId, int $id)
    {
        // Don't allow an admin to delete themselves for safety
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userModel = new UserModel();
        $userModel->delete($id);
        
        return redirect()->back()->with('message', 'Admin dihapus.');
    }
}
