<?php

namespace App\Controllers\TenantAdmin;

use App\Controllers\BaseController;
use App\Models\CourseModel;

class CourseController extends BaseController
{
    public function index(string $tenantStringId)
    {
        $courseModel = new CourseModel();
        $tenantId = session()->get('current_tenant_id');
        
        $courses = $courseModel
            ->where('tenant_id', $tenantId)
            ->findAll();
            
        return view('tenant_admin/courses/index', [
            'courses' => $courses, 
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Kelola Course'
        ]);
    }

    public function create(string $tenantStringId)
    {
        return view('tenant_admin/courses/create', [
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Tambah Course'
        ]);
    }

    public function store(string $tenantStringId)
    {
        $courseModel = new CourseModel();
        $tenantId = session()->get('current_tenant_id');
        
        $courseModel->insert([
            'tenant_id'     => $tenantId,
            'instructor_id' => $this->request->getPost('instructor_id'),
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
        ]);
        
        return redirect()->back()->with('message', 'Course berhasil ditambahkan.');
    }

    public function show(string $tenantStringId, int $id)
    {
        $courseModel = new CourseModel();
        $tenantId = session()->get('current_tenant_id');
        
        $course = $courseModel
            ->where('tenant_id', $tenantId)
            ->find($id);
            
        return view('tenant_admin/courses/show', [
            'course' => $course, 
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Detail Course'
        ]);
    }
}
