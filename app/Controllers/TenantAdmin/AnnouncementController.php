<?php

namespace App\Controllers\TenantAdmin;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;

class AnnouncementController extends BaseController
{
    public function index($tenantStringId)
    {
        $announcementModel = new AnnouncementModel();
        $tenantId = session('current_tenant_id');

        // Tenant Admin can see ALL announcements in the tenant
        $announcements = $announcementModel->select('announcements.*, users.full_name as author_name')
            ->join('users', 'users.id = announcements.author_id', 'left')
            ->where('announcements.tenant_id', $tenantId)
            ->orderBy('announcements.created_at', 'DESC')
            ->findAll();

        return view('tenant_admin/announcements/index', [
            'announcements' => $announcements,
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Pusat Informasi'
        ]);
    }

    public function store($tenantStringId)
    {
        $announcementModel = new AnnouncementModel();
        
        $data = [
            'tenant_id' => session('current_tenant_id'),
            'author_id' => session('user_id'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'target_role' => $this->request->getPost('target_role') // 'all', 'instructor', 'student'
        ];
        
        $announcementModel->insert($data);
        return redirect()->back()->with('success', 'Informasi berhasil dibagikan.');
    }

    public function delete($tenantStringId, $id)
    {
        $announcementModel = new AnnouncementModel();
        // Admin can delete any announcement
        $announcementModel->delete($id);
        return redirect()->back()->with('success', 'Informasi dihapus.');
    }
}
