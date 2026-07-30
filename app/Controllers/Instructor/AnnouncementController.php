<?php

namespace App\Controllers\Instructor;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;

class AnnouncementController extends BaseController
{
    public function index($tenantStringId)
    {
        $announcementModel = new AnnouncementModel();
        $tenantId = session('current_tenant_id');
        $userId = session('user_id');

        // Instructors can see:
        // 1. Announcements targeted to 'instructor' or 'all'
        // 2. Announcements they authored
        $announcements = $announcementModel->select('announcements.*, users.full_name as author_name')
            ->join('users', 'users.id = announcements.author_id')
            ->where('announcements.tenant_id', $tenantId)
            ->groupStart()
                ->whereIn('announcements.target_role', ['all', 'instructor'])
                ->orWhere('announcements.author_id', $userId)
            ->groupEnd()
            ->orderBy('announcements.created_at', 'DESC')
            ->findAll();

        return view('instructor/announcements/index', [
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
            'target_role' => 'student' // Instructors can only share to students
        ];
        
        $announcementModel->insert($data);
        return redirect()->back()->with('success', 'Informasi berhasil dibagikan ke Siswa.');
    }

    public function delete($tenantStringId, $id)
    {
        $announcementModel = new AnnouncementModel();
        $announcement = $announcementModel->find($id);
        
        if ($announcement && $announcement->author_id == session('user_id')) {
            $announcementModel->delete($id);
            return redirect()->back()->with('success', 'Informasi dihapus.');
        }
        
        return redirect()->back()->with('error', 'Akses ditolak.');
    }
}
