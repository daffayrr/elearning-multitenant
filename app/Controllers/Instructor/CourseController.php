<?php

namespace App\Controllers\Instructor;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CourseController extends BaseController
{
    public function index($tenant)
    {
        $courseModel = new \App\Models\CourseModel();
        
        $instructorId = session()->get('user_id') ?? 1;
        $tenantId = session()->get('tenant_id') ?? 1;
        
        $courses = $courseModel->where('instructor_id', $instructorId)
                               ->where('tenant_id', $tenantId)
                               ->findAll();
                               
        return view('instructor/courses', ['courses' => $courses, 'tenant' => $tenant]);
    }

    public function storeCourse($tenant)
    {
        $courseModel = new \App\Models\CourseModel();
        
        $instructorId = session()->get('user_id') ?? 1;
        $tenantId = session()->get('tenant_id') ?? 1;

        $data = [
            'tenant_id' => $tenantId,
            'instructor_id' => $instructorId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'enrollment_key' => $this->request->getPost('enrollment_key'),
        ];

        $courseModel->insert($data);

        return redirect()->to('/' . $tenant . '/instructor/courses')->with('success', 'Course created successfully');
    }

    public function courseDetail($tenant, $id)
    {
        $courseModel = new \App\Models\CourseModel();
        $moduleModel = new \App\Models\CourseModuleModel();
        $assignmentModel = new \App\Models\AssignmentModel();
        $questionBankModel = new \App\Models\QuestionBankModel();

        $course = $courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $modules = $moduleModel->where('course_id', $id)->orderBy('order', 'ASC')->findAll();
        $assignments = $assignmentModel->where('course_id', $id)->findAll();
        
        $instructorId = session()->get('user_id');
        $questionBanks = $questionBankModel->where('instructor_id', $instructorId)->findAll();

        return view('instructor/course_detail', [
            'course' => $course,
            'modules' => $modules,
            'assignments' => $assignments,
            'questionBanks' => $questionBanks,
            'tenant' => $tenant
        ]);
    }

    public function storeModule($tenant, $courseId)
    {
        $moduleModel = new \App\Models\CourseModuleModel();
        $s3Service = new \App\Libraries\AwsS3Service();

        $fileUrl = null;
        $file = $this->request->getFile('material_file');
        
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);
                
                $s3Url = $s3Service->uploadFile(WRITEPATH . 'uploads/' . $newName, 'materials/' . $newName);
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
            'order' => $this->request->getPost('order') ?: 0,
            'file_url' => $fileUrl,
        ];

        $moduleModel->insert($data);

        return redirect()->to('/' . $tenant . '/instructor/course/' . $courseId)->with('success', 'Module added successfully');
    }

    public function storeAssignment($tenant, $courseId)
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
            'type' => $this->request->getPost('type'), // submission, quiz, essay, cbt
            'question_bank_id' => $this->request->getPost('type') === 'cbt' ? $this->request->getPost('question_bank_id') : null,
            'due_date' => $this->request->getPost('due_date'),
            'file_url' => $fileUrl,
        ];

        $assignmentModel->insert($data);

        return redirect()->to('/' . $tenant . '/instructor/course/' . $courseId)->with('success', 'Assignment added successfully');
    }

    public function updateCourse($tenant, $id)
    {
        $courseModel = new \App\Models\CourseModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'enrollment_key' => $this->request->getPost('enrollment_key'),
        ];

        $courseModel->update($id, $data);

        return redirect()->to('/' . $tenant . '/instructor/courses')->with('success', 'Course updated successfully');
    }

    public function deleteCourse($tenant, $id)
    {
        $courseModel = new \App\Models\CourseModel();
        $courseModel->delete($id);

        return redirect()->to('/' . $tenant . '/instructor/courses')->with('success', 'Course deleted successfully');
    }

    public function previewCourse($tenant, $id)
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

        return view('instructor/course_preview', [
            'course' => $course,
            'modules' => $modules,
            'assignments' => $assignments,
            'tenant' => $tenant,
            'pageTitle' => 'Student Preview: ' . $course->title
        ]);
    }

    public function enrollments($tenant, $courseId)
    {
        $courseModel = new \App\Models\CourseModel();
        $enrollmentModel = new \App\Models\CourseEnrollmentModel();

        $course = $courseModel->find($courseId);
        if (!$course || $course->instructor_id != session()->get('user_id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $enrollments = $enrollmentModel->select('course_enrollments.*, users.full_name, users.email')
                                       ->join('users', 'users.id = course_enrollments.student_id')
                                       ->where('course_id', $courseId)
                                       ->orderBy('created_at', 'DESC')
                                       ->findAll();

        return view('instructor/course_enrollments', [
            'course' => $course,
            'enrollments' => $enrollments,
            'tenant' => $tenant
        ]);
    }

    public function approveEnrollment($tenant, $enrollmentId)
    {
        $enrollmentModel = new \App\Models\CourseEnrollmentModel();
        $enrollmentModel->update($enrollmentId, [
            'status' => 'approved',
            'enrolled_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('success', 'Pendaftaran disetujui.');
    }

    public function rejectEnrollment($tenant, $enrollmentId)
    {
        $enrollmentModel = new \App\Models\CourseEnrollmentModel();
        $enrollmentModel->update($enrollmentId, [
            'status' => 'rejected'
        ]);
        return redirect()->back()->with('success', 'Pendaftaran ditolak.');
    }
}
