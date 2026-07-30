<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InstructorController extends BaseController
{
    public function index()
    {
        $courseModel = new \App\Models\CourseModel();
        // Assuming user ID and tenant ID are stored in session after login
        $instructorId = session()->get('user_id') ?? 1; // Defaulting to 1 for demo if session not set
        $tenantId = session()->get('tenant_id') ?? 1;
        
        $courses = $courseModel->where('instructor_id', $instructorId)
                               ->where('tenant_id', $tenantId)
                               ->findAll();
                               
        return view('instructor/courses', ['courses' => $courses]);
    }

    public function storeCourse()
    {
        $courseModel = new \App\Models\CourseModel();
        
        $instructorId = session()->get('user_id') ?? 1;
        $tenantId = session()->get('tenant_id') ?? 1;

        $data = [
            'tenant_id' => $tenantId,
            'instructor_id' => $instructorId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        $courseModel->insert($data);

        return redirect()->to('/instructor/courses')->with('success', 'Course created successfully');
    }

    public function courseDetail($id)
    {
        $courseModel = new \App\Models\CourseModel();
        $moduleModel = new \App\Models\CourseModuleModel();
        $assignmentModel = new \App\Models\AssignmentModel();

        $course = $courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $modules = $moduleModel->where('course_id', $id)->orderBy('order', 'ASC')->findAll();
        $assignments = $assignmentModel->where('course_id', $id)->findAll();

        return view('instructor/course_detail', [
            'course' => $course,
            'modules' => $modules,
            'assignments' => $assignments
        ]);
    }

    public function storeModule($courseId)
    {
        $moduleModel = new \App\Models\CourseModuleModel();
        $s3Service = new \App\Libraries\AwsS3Service();

        $fileUrl = null;
        $file = $this->request->getFile('material_file');
        
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                // Move temporarily to writable/uploads
                $file->move(WRITEPATH . 'uploads', $newName);
                
                // Upload to S3
                $s3Url = $s3Service->uploadFile(WRITEPATH . 'uploads/' . $newName, 'materials/' . $newName);
                if ($s3Url) {
                    $fileUrl = $s3Url;
                    // Delete local temp file
                    unlink(WRITEPATH . 'uploads/' . $newName);
                } else {
                    return redirect()->back()->with('error', 'S3 Upload failed. Please check writable/logs/s3_error.txt for details.');
                }
            } else {
                return redirect()->back()->with('error', 'File upload error: ' . $file->getErrorString());
            }
        }

        $data = [
            'course_id' => $courseId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'order' => $this->request->getPost('order') ?: 0,
            'file_url' => $fileUrl,
        ];

        $moduleModel->insert($data);

        return redirect()->to('/instructor/course/' . $courseId)->with('success', 'Module added successfully');
    }

    public function storeAssignment($courseId)
    {
        $assignmentModel = new \App\Models\AssignmentModel();
        $s3Service = new \App\Libraries\AwsS3Service();

        $fileUrl = null;
        $file = $this->request->getFile('assignment_file');
        
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);
                $s3Url = $s3Service->uploadFile(WRITEPATH . 'uploads/' . $newName, 'assignments/' . $newName);
                if ($s3Url) {
                    $fileUrl = $s3Url;
                    unlink(WRITEPATH . 'uploads/' . $newName);
                } else {
                    return redirect()->back()->with('error', 'S3 Upload failed. Please check writable/logs/s3_error.txt for details.');
                }
            } else {
                return redirect()->back()->with('error', 'File upload error: ' . $file->getErrorString());
            }
        }

        $data = [
            'course_id' => $courseId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'), // submission or quiz
            'due_date' => $this->request->getPost('due_date'),
            'file_url' => $fileUrl,
        ];

        $assignmentModel->insert($data);

        return redirect()->to('/instructor/course/' . $courseId)->with('success', 'Assignment added successfully');
    }
}
