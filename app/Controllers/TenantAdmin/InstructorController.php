<?php

namespace App\Controllers\TenantAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class InstructorController extends BaseController
{
    public function index(string $tenantStringId)
    {
        $userModel = new UserModel();
        $tenantId = session()->get('current_tenant_id');
        
        $instructors = $userModel
            ->where('tenant_id', $tenantId)
            ->where('role', 'instructor')
            ->findAll();
            
        return view('tenant_admin/instructors/index', [
            'instructors' => $instructors, 
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Kelola Instruktur'
        ]);
    }

    public function store(string $tenantStringId)
    {
        $userModel = new UserModel();
        $tenantId = session()->get('current_tenant_id');
        
        $data = [
            'tenant_id'     => $tenantId,
            'role'          => 'instructor',
            'full_name'     => $this->request->getPost('full_name'),
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];
        
        $inserted = $userModel->insert($data);
        if (!$inserted) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors() ?: ['error' => 'Gagal menyimpan data ke database. Cek kembali form Anda.']);
        }
        
        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(string $tenantStringId, int $id)
    {
        $userModel = new UserModel();
        
        $data = [
            'full_name'  => $this->request->getPost('full_name'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'is_blocked' => $this->request->getPost('is_blocked')
        ];
        
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }
        
        $updated = $userModel->update($id, $data);
        if (!$updated) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors() ?: ['error' => 'Gagal mengubah data.']);
        }
        
        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }

    public function delete(string $tenantStringId, int $id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        
        return redirect()->back()->with('message', 'Data dihapus.');
    }

    public function importExcel(string $tenantStringId)
    {
        try {
            $file = $this->request->getFile('excel_file');
            
            if (!$file || !$file->isValid()) {
                return redirect()->back()->with('error', 'File tidak valid atau belum dipilih.');
            }

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $userModel = new UserModel();
            $tenantId = session()->get('current_tenant_id');

            $failedRows = 0;
            // Skip header row
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (empty(trim($row[0])) || empty(trim($row[2]))) continue;

                $inserted = $userModel->insert([
                    'tenant_id'     => $tenantId,
                    'role'          => 'instructor',
                    'full_name'     => $row[0],
                    'username'      => $row[1] ?? '',
                    'email'         => $row[2],
                    'password_hash' => password_hash($row[3] ?? '12345678', PASSWORD_BCRYPT),
                ]);

                if (!$inserted) {
                    $failedRows++;
                    log_message('error', 'Gagal import baris ke-' . $i . ': ' . print_r($userModel->errors(), true));
                }
            }

            if ($failedRows > 0) {
                return redirect()->back()->with('error', "Import selesai, tapi $failedRows baris gagal diimport.");
            }

            return redirect()->back()->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate(string $tenantStringId)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Full Name');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Password');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel') . '.xlsx';
        $writer->save($tempFilePath);
        
        return $this->response->download($tempFilePath, null)->setFileName('Template_User.xlsx');
    }
}
