<?php

namespace App\Controllers\TenantAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index(string $tenantStringId): string
    {
        $tenantId = session()->get('current_tenant_id');
        $userModel = new UserModel();

        $totalInstructors = $userModel->where('tenant_id', $tenantId)->where('role', 'instructor')->countAllResults();
        $totalStudents = $userModel->where('tenant_id', $tenantId)->where('role', 'student')->countAllResults();

        return view('tenant_admin/dashboard', [
            'pageTitle'        => 'Tenant Admin Dashboard',
            'tenantStringId'   => $tenantStringId,
            'totalInstructors' => $totalInstructors,
            'totalStudents'    => $totalStudents,
        ]);
    }
}
