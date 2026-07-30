<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index($tenantStringId)
    {
        $enrollmentModel = new \App\Models\CourseEnrollmentModel();
        $announcementModel = new \App\Models\AnnouncementModel();

        $tenantId = session('current_tenant_id');
        $studentId = session('user_id');

        $activeCourses = $enrollmentModel->where('student_id', $studentId)
                                         ->where('status', 'approved')
                                         ->countAllResults();

        $totalAnnouncements = $announcementModel->where('tenant_id', $tenantId)
                                                ->whereIn('target_role', ['all', 'student'])
                                                ->countAllResults();

        return view('student/dashboard', [
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Dashboard Siswa',
            'activeCourses' => $activeCourses,
            'totalAnnouncements' => $totalAnnouncements
        ]);
    }
}
