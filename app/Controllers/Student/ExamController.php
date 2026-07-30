<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class ExamController extends BaseController
{
    public function index($tenantStringId)
    {
        return view('student/exams/index', [
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Ujian / CBT'
        ]);
    }

    public function start($tenantStringId, $assignmentId)
    {
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($assignmentId);
        
        if (!$assignment) {
            return redirect()->back()->with('error', 'Ujian tidak ditemukan.');
        }

        $questions = [];
        if ($assignment->question_bank_id) {
            $questionModel = new \App\Models\QuestionModel();
            $questions = $questionModel->where('question_bank_id', $assignment->question_bank_id)->findAll();
        }

        return view('student/exams/start', [
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'CBT: ' . $assignment->title,
            'assignment' => $assignment,
            'questions' => $questions
        ]);
    }

    public function submit($tenantStringId, $assignmentId)
    {
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($assignmentId);
        
        if (!$assignment) {
            return redirect()->back()->with('error', 'Ujian tidak ditemukan.');
        }

        $answers = $this->request->getPost('answer') ?? []; // array of question_id => answer
        
        $questionModel = new \App\Models\QuestionModel();
        $questions = $questionModel->where('question_bank_id', $assignment->question_bank_id)->findAll();
        
        $totalPoints = 0;
        $earnedPoints = 0;
        
        foreach ($questions as $q) {
            $totalPoints += $q->points;
            if ($q->type === 'multiple_choice') {
                $studentAnswer = $answers[$q->id] ?? null;
                if ($studentAnswer && $studentAnswer === $q->correct_answer) {
                    $earnedPoints += $q->points;
                }
            }
            // Essay questions can be reviewed by instructor later.
        }
        
        $score = 0;
        if ($totalPoints > 0) {
            $score = round(($earnedPoints / $totalPoints) * 100);
        }
        
        $submissionModel = new \App\Models\StudentSubmissionModel();
        $studentId = session()->get('user_id');
        
        $data = [
            'assignment_id' => $assignmentId,
            'student_id'    => $studentId,
            'score'         => $score,
            'essay_answer'  => json_encode($answers),
        ];
        
        $existing = $submissionModel->where('assignment_id', $assignmentId)
                                    ->where('student_id', $studentId)
                                    ->first();
                                    
        if ($existing) {
            $submissionModel->update($existing->id, $data);
        } else {
            $submissionModel->insert($data);
        }

        return redirect()->to('/' . $tenantStringId . '/student/courses')->with('success', 'Ujian berhasil diselesaikan! Nilai sementara Anda: ' . $score);
    }
}
