<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\CourseEnrollmentModel;
use App\Models\CourseModuleModel;
use App\Models\AssignmentModel;

class CourseController extends BaseController
{
    public function index($tenant)
    {
        $courseModel = new CourseModel();
        $enrollmentModel = new CourseEnrollmentModel();
        
        $studentId = session()->get('user_id');
        
        $enrollments = $enrollmentModel->where('student_id', $studentId)
                                       ->where('status', 'approved')
                                       ->findAll();
                                       
        $courseIds = array_column($enrollments, 'course_id');
        
        $courses = [];
        if (!empty($courseIds)) {
            $courses = $courseModel->whereIn('id', $courseIds)->findAll();
        }
        
        return view('student/courses', [
            'courses' => $courses,
            'tenant' => $tenant,
            'pageTitle' => 'Kelasku'
        ]);
    }

    public function allCourses($tenant)
    {
        $courseModel = new CourseModel();
        $enrollmentModel = new CourseEnrollmentModel();
        
        $tenantId = session()->get('current_tenant_id');
        $studentId = session()->get('user_id');
        
        $allCourses = $courseModel->where('tenant_id', $tenantId)->findAll();
        
        $myEnrollments = $enrollmentModel->where('student_id', $studentId)->findAll();
        
        // Map to quickly check enrollment status
        $enrollmentStatus = [];
        foreach ($myEnrollments as $e) {
            $enrollmentStatus[$e->course_id] = $e->status;
        }

        return view('student/all_courses', [
            'courses' => $allCourses,
            'enrollmentStatus' => $enrollmentStatus,
            'tenant' => $tenant,
            'pageTitle' => 'Semua Kelas'
        ]);
    }

    public function enroll($tenant, $courseId)
    {
        $courseModel = new CourseModel();
        $enrollmentModel = new CourseEnrollmentModel();
        
        $studentId = session()->get('user_id');
        
        $course = $courseModel->find($courseId);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Check if already enrolled/pending
        $existing = $enrollmentModel->where('course_id', $courseId)
                                    ->where('student_id', $studentId)
                                    ->first();
                                    
        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar di kelas ini.');
        }

        $inputKey = $this->request->getPost('enrollment_key');
        
        if (!empty($course->enrollment_key)) {
            if ($inputKey !== $course->enrollment_key) {
                return redirect()->back()->with('error', 'Enrollment key salah.');
            }
            
            // Correct key, approve instantly
            $enrollmentModel->insert([
                'course_id' => $courseId,
                'student_id' => $studentId,
                'status' => 'approved'
            ]);
            return redirect()->back()->with('success', 'Berhasil bergabung ke kelas!');
        } else {
            // No key, requires approval
            $enrollmentModel->insert([
                'course_id' => $courseId,
                'student_id' => $studentId,
                'status' => 'pending'
            ]);
            return redirect()->back()->with('success', 'Permintaan pendaftaran terkirim. Menunggu persetujuan instruktur.');
        }
    }

    public function show($tenant, $courseId)
    {
        $courseModel = new CourseModel();
        $enrollmentModel = new CourseEnrollmentModel();
        $moduleModel = new CourseModuleModel();
        $assignmentModel = new AssignmentModel();
        
        $studentId = session()->get('user_id');
        
        $enrollment = $enrollmentModel->where('course_id', $courseId)
                                      ->where('student_id', $studentId)
                                      ->where('status', 'approved')
                                      ->first();
                                      
        if (!$enrollment) {
            return redirect()->to("/{$tenant}/student/all-courses")->with('error', 'Akses ditolak. Anda belum disetujui di kelas ini.');
        }
        
        $course = $courseModel->find($courseId);
        $modules = $moduleModel->where('course_id', $courseId)->orderBy('order', 'ASC')->findAll();
        $assignments = $assignmentModel->where('course_id', $courseId)->findAll();
        
        // Fetch student submissions for these assignments
        $submissionModel = new \App\Models\StudentSubmissionModel();
        $assignmentIds = array_column($assignments, 'id');
        $submissions = [];
        if (!empty($assignmentIds)) {
            $studentSubmissions = $submissionModel->whereIn('assignment_id', $assignmentIds)
                                                  ->where('student_id', $studentId)
                                                  ->findAll();
            foreach ($studentSubmissions as $sub) {
                $submissions[$sub->assignment_id] = $sub;
            }
        }
        
        return view('student/course_detail', [
            'course' => $course,
            'modules' => $modules,
            'assignments' => $assignments,
            'submissions' => $submissions,
            'tenant' => $tenant
        ]);
    }
}
