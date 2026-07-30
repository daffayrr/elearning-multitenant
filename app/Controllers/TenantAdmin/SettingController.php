<?php

namespace App\Controllers\TenantAdmin;

use App\Controllers\BaseController;
use App\Models\TenantModel;

class SettingController extends BaseController
{
    public function index(string $tenantStringId)
    {
        $tenantModel = new TenantModel();
        $tenantId = session()->get('current_tenant_id');
        
        $tenant = $tenantModel->find($tenantId);
        
        return view('tenant_admin/settings/index', [
            'tenant' => $tenant, 
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Pengaturan Institusi'
        ]);
    }

    public function update(string $tenantStringId)
    {
        $tenantModel = new TenantModel();
        $tenantId = session()->get('current_tenant_id');
        
        $tenantModel->update($tenantId, [
            'name'   => $this->request->getPost('name'),
            'domain' => $this->request->getPost('domain'),
        ]);
        
        return redirect()->back()->with('message', 'Settings updated successfully');
    }
}
