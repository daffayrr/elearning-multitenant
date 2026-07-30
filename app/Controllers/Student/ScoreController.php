<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;

class ScoreController extends BaseController
{
    public function index($tenantStringId)
    {
        return view('student/scores/index', [
            'tenantStringId' => $tenantStringId,
            'pageTitle' => 'Nilai Saya'
        ]);
    }
}
