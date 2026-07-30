<?php

namespace App\Controllers\Instructor;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index($tenantStringId)
    {
        $courseModel = new \App\Models\CourseModel();
        $userModel = new \App\Models\UserModel();
        $bankModel = new \App\Models\QuestionBankModel();

        $tenantId = session('current_tenant_id');
        $userId = session('user_id');

        $total_courses = $courseModel->where('tenant_id', $tenantId)->where('instructor_id', $userId)->countAllResults();
        $total_students = $userModel->where('tenant_id', $tenantId)->where('role', 'student')->countAllResults();
        $total_banks = $bankModel->where('tenant_id', $tenantId)->where('instructor_id', $userId)->countAllResults();

        return view('instructor/dashboard', [
            'pageTitle'      => 'Instructor Dashboard',
            'tenantStringId' => $tenantStringId,
            'total_courses'  => $total_courses,
            'total_students' => $total_students,
            'total_banks'    => $total_banks,
        ]);
    }
}
