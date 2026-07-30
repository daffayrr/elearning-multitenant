<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;

class AnnouncementController extends BaseController
{
    public function index($tenantStringId)
    {
        $announcementModel = new AnnouncementModel();
        $tenantId = session('current_tenant_id');

        // Students can see announcements targeted to 'all' or 'student'
        $announcements = $announcementModel->select('announcements.*, users.full_name as author_name, users.role as author_role')
            ->join('users', 'users.id = announcements.author_id', 'left')
            ->where('announcements.tenant_id', $tenantId)
            ->whereIn('announcements.target_role', ['all', 'student'])
            ->orderBy('announcements.created_at', 'DESC')
            ->findAll();

        return view('student/announcements/index', [
            'announcements' => $announcements,
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Pusat Informasi'
        ]);
    }
}
