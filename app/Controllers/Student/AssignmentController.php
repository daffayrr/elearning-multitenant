<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class AssignmentController extends BaseController
{
    public function index($tenantStringId)
    {
        return view('student/assignments/index', [
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Tugas Saya'
        ]);
    }

    public function submit($tenantStringId, $assignmentId)
    {
        $assignmentModel = new \App\Models\AssignmentModel();
        $submissionModel = new \App\Models\StudentSubmissionModel();
        
        $assignment = $assignmentModel->find($assignmentId);
        if (!$assignment) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
        }

        $data = [
            'assignment_id' => $assignmentId,
            'student_id' => session()->get('user_id'),
        ];

        if ($assignment->type === 'submission') {
            $file = $this->request->getFile('submission_file');
            
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $s3Service = new \App\Libraries\AwsS3Service();
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads', $newName);
                    
                    $s3Url = $s3Service->uploadFile(WRITEPATH . 'uploads/' . $newName, 'submissions/' . $newName);
                    if ($s3Url) {
                        $data['file_url'] = $s3Url;
                        unlink(WRITEPATH . 'uploads/' . $newName);
                    } else {
                        return redirect()->back()->with('error', 'S3 Upload failed. Please check writable/logs/s3_error.txt for details.');
                    }
                } else {
                    return redirect()->back()->with('error', 'File upload error: ' . $file->getErrorString());
                }
            } else {
                return redirect()->back()->with('error', 'Silakan pilih file untuk diunggah.');
            }
        } elseif ($assignment->type === 'essay') {
            $data['essay_answer'] = $this->request->getPost('essay_answer');
        }

        $submissionModel->insert($data);

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
