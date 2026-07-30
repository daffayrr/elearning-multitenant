<?php

namespace App\Controllers\Instructor;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\AssignmentModel;
use App\Models\UserModel;
use App\Models\StudentSubmissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ScoringController extends BaseController
{
    public function index($tenantStringId)
    {
        $courseModel = new CourseModel();
        
        $instructorId = session()->get('user_id');
        $tenantId = session()->get('current_tenant_id');
        
        $courses = $courseModel->where('instructor_id', $instructorId)
                               ->where('tenant_id', $tenantId)
                               ->findAll();
                               
        return view('instructor/scoring/index', [
            'courses' => $courses,
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Penilaian Kelas'
        ]);
    }

    public function courseScoring($tenantStringId, $courseId)
    {
        $courseModel = new CourseModel();
        $assignmentModel = new AssignmentModel();
        $userModel = new UserModel();
        $submissionModel = new StudentSubmissionModel();
        
        $instructorId = session()->get('user_id');
        $tenantId = session()->get('current_tenant_id');

        $course = $courseModel->find($courseId);
        if (!$course || $course->instructor_id != $instructorId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $assignments = $assignmentModel->where('course_id', $courseId)->findAll();
        $students = $userModel->where('tenant_id', $tenantId)
                              ->where('role', 'student')
                              ->findAll();

        // Get all submissions for assignments in this course
        $assignmentIds = array_column($assignments, 'id');
        $submissions = [];
        if (!empty($assignmentIds)) {
            $subs = $submissionModel->whereIn('assignment_id', $assignmentIds)->findAll();
            foreach ($subs as $sub) {
                // Key format: studentId_assignmentId
                $submissions[$sub->student_id . '_' . $sub->assignment_id] = $sub;
            }
        }

        return view('instructor/scoring/table', [
            'course' => $course,
            'assignments' => $assignments,
            'students' => $students,
            'submissions' => $submissions,
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Tabel Penilaian: ' . $course->title
        ]);
    }

    public function exportScoring($tenantStringId, $courseId)
    {
        $courseModel = new CourseModel();
        $assignmentModel = new AssignmentModel();
        $userModel = new UserModel();
        $submissionModel = new StudentSubmissionModel();
        
        $course = $courseModel->find($courseId);
        if (!$course || $course->instructor_id != session()->get('user_id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $assignments = $assignmentModel->where('course_id', $courseId)->findAll();
        $students = $userModel->where('tenant_id', session()->get('current_tenant_id'))
                              ->where('role', 'student')
                              ->findAll();

        $assignmentIds = array_column($assignments, 'id');
        $submissions = [];
        if (!empty($assignmentIds)) {
            $subs = $submissionModel->whereIn('assignment_id', $assignmentIds)->findAll();
            foreach ($subs as $sub) {
                $submissions[$sub->student_id . '_' . $sub->assignment_id] = $sub;
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Siswa');
        $sheet->setCellValue('C1', 'Email');

        $col = 'D';
        foreach ($assignments as $ass) {
            $sheet->setCellValue($col . '1', $ass->title . "\n(" . ucfirst($ass->type) . ")");
            // Auto size
            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 2;
        $no = 1;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $student->full_name);
            $sheet->setCellValue('C' . $row, $student->email);
            
            $colIdx = 'D';
            foreach ($assignments as $ass) {
                $key = $student->id . '_' . $ass->id;
                $score = '-';
                if (isset($submissions[$key]) && $submissions[$key]->score !== null) {
                    $score = $submissions[$key]->score;
                }
                $sheet->setCellValue($colIdx . $row, $score);
                $colIdx++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'export') . '.xlsx';
        $writer->save($tempFilePath);
        
        $filename = 'Rekap_Nilai_' . preg_replace('/[^a-zA-Z0-9]+/', '_', $course->title) . '.xlsx';
        return $this->response->download($tempFilePath, null)->setFileName($filename);
    }
}
