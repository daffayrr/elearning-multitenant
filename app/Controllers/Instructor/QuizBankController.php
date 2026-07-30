<?php

namespace App\Controllers\Instructor;

use App\Controllers\BaseController;
use App\Models\QuestionBankModel;
use App\Models\QuestionModel;

class QuizBankController extends BaseController
{
    public function index($tenantStringId)
    {
        $bankModel = new QuestionBankModel();
        
        $instructorId = session()->get('user_id');
        $tenantId = session()->get('current_tenant_id');
        
        $banks = $bankModel->where('instructor_id', $instructorId)
                           ->where('tenant_id', $tenantId)
                           ->findAll();
                           
        return view('instructor/quiz_bank/index', [
            'banks' => $banks,
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Bank Soal CBT'
        ]);
    }

    public function storeBank($tenantStringId)
    {
        $bankModel = new QuestionBankModel();
        
        $data = [
            'tenant_id' => session()->get('current_tenant_id'),
            'instructor_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];
        
        $bankModel->insert($data);
        return redirect()->back()->with('success', 'Bank soal berhasil dibuat.');
    }

    public function deleteBank($tenantStringId, $id)
    {
        $bankModel = new QuestionBankModel();
        $bankModel->delete($id);
        return redirect()->back()->with('success', 'Bank soal dihapus.');
    }

    public function showBank($tenantStringId, $id)
    {
        $bankModel = new QuestionBankModel();
        $questionModel = new QuestionModel();
        
        $bank = $bankModel->find($id);
        if(!$bank || $bank->instructor_id != session()->get('user_id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $questions = $questionModel->where('question_bank_id', $id)->findAll();
        
        return view('instructor/quiz_bank/show', [
            'bank' => $bank,
            'questions' => $questions,
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Kelola Pertanyaan: ' . $bank->title
        ]);
    }

    public function storeQuestion($tenantStringId, $bankId)
    {
        $questionModel = new QuestionModel();
        
        $type = $this->request->getPost('type');
        $options = null;
        $correctAnswer = null;
        
        if ($type === 'multiple_choice') {
            $optionsArr = [
                'A' => $this->request->getPost('option_a'),
                'B' => $this->request->getPost('option_b'),
                'C' => $this->request->getPost('option_c'),
                'D' => $this->request->getPost('option_d')
            ];
            $options = json_encode($optionsArr);
            $correctAnswer = $this->request->getPost('correct_answer');
        } else {
            // Essay
            $correctAnswer = $this->request->getPost('essay_answer_key');
        }
        
        $data = [
            'question_bank_id' => $bankId,
            'type' => $type,
            'question_text' => $this->request->getPost('question_text'),
            'options' => $options,
            'correct_answer' => $correctAnswer,
            'points' => $this->request->getPost('points') ?? 10
        ];
        
        $questionModel->insert($data);
        return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }
    
    public function updateQuestion($tenantStringId, $id)
    {
        $questionModel = new QuestionModel();
        
        $type = $this->request->getPost('type');
        $options = null;
        $correctAnswer = null;
        
        if ($type === 'multiple_choice') {
            $optionsArr = [
                'A' => $this->request->getPost('option_a'),
                'B' => $this->request->getPost('option_b'),
                'C' => $this->request->getPost('option_c'),
                'D' => $this->request->getPost('option_d')
            ];
            $options = json_encode($optionsArr);
            $correctAnswer = $this->request->getPost('correct_answer');
        } else {
            // Essay
            $correctAnswer = $this->request->getPost('essay_answer_key');
        }
        
        $data = [
            'type' => $type,
            'question_text' => $this->request->getPost('question_text'),
            'options' => $options,
            'correct_answer' => $correctAnswer,
            'points' => $this->request->getPost('points') ?? 10
        ];
        
        $questionModel->update($id, $data);
        return redirect()->back()->with('success', 'Pertanyaan berhasil diupdate.');
    }

    public function deleteQuestion($tenantStringId, $id)
    {
        $questionModel = new QuestionModel();
        $questionModel->delete($id);
        return redirect()->back()->with('success', 'Pertanyaan dihapus.');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Tipe (multiple_choice / essay)');
        $sheet->setCellValue('B1', 'Teks Pertanyaan');
        $sheet->setCellValue('C1', 'Opsi A (Kosongkan jika essay)');
        $sheet->setCellValue('D1', 'Opsi B (Kosongkan jika essay)');
        $sheet->setCellValue('E1', 'Opsi C (Kosongkan jika essay)');
        $sheet->setCellValue('F1', 'Opsi D (Kosongkan jika essay)');
        $sheet->setCellValue('G1', 'Jawaban Benar (A/B/C/D atau Kunci Jawaban Essay)');
        $sheet->setCellValue('H1', 'Poin');
        
        // Example Row 1: Multiple Choice
        $sheet->setCellValue('A2', 'multiple_choice');
        $sheet->setCellValue('B2', 'Siapa penemu lampu pijar?');
        $sheet->setCellValue('C2', 'Albert Einstein');
        $sheet->setCellValue('D2', 'Thomas Edison');
        $sheet->setCellValue('E2', 'Nikola Tesla');
        $sheet->setCellValue('F2', 'Isaac Newton');
        $sheet->setCellValue('G2', 'B');
        $sheet->setCellValue('H2', '10');

        // Example Row 2: Essay
        $sheet->setCellValue('A3', 'essay');
        $sheet->setCellValue('B3', 'Jelaskan teori relativitas secara singkat!');
        $sheet->setCellValue('C3', '');
        $sheet->setCellValue('D3', '');
        $sheet->setCellValue('E3', '');
        $sheet->setCellValue('F3', '');
        $sheet->setCellValue('G3', 'E=mc2, massa dan energi adalah sama.');
        $sheet->setCellValue('H3', '20');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Template_Soal_CBT.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function importExcel($tenantStringId, $bankId)
    {
        $file = $this->request->getFile('excel_file');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file->getTempName());
            $spreadsheet = $reader->load($file->getTempName());
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
            $questionModel = new QuestionModel();
            
            $count = 0;
            // Skip baris pertama (header)
            for ($i = 1; $i < count($sheetData); $i++) {
                $row = $sheetData[$i];
                
                $type = trim($row[0] ?? '');
                if (empty($type)) continue;
                
                $text = trim($row[1] ?? '');
                
                $options = null;
                if ($type === 'multiple_choice') {
                    $opt = [
                        'A' => $row[2] ?? '',
                        'B' => $row[3] ?? '',
                        'C' => $row[4] ?? '',
                        'D' => $row[5] ?? ''
                    ];
                    $options = json_encode($opt);
                }
                
                $correct = $row[6] ?? '';
                $points = $row[7] ?? 10;
                
                $questionModel->insert([
                    'question_bank_id' => $bankId,
                    'type' => $type,
                    'question_text' => $text,
                    'options' => $options,
                    'correct_answer' => $correct,
                    'points' => (int)$points
                ]);
                $count++;
            }
            
            return redirect()->back()->with('success', "Berhasil mengimpor $count soal.");
        }
        
        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }
}
