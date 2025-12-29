<?php

namespace App\Http\Controllers;

use App\Http\Requests\Certificate\CheckCertificateRequest;
use App\Http\Requests\Certificate\CreateCertificateRequest;

class CertificateController extends Controller
{
    /**
     * Создание сертификата
     * @param  CreateCertificateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Random\RandomException
     */
    public function store(CreateCertificateRequest $request) {
        $validated = $request->validated();
        $student_code = str_pad(substr($validated['student_id'], 0, 3), 3, '0', STR_PAD_LEFT);
        $course_code = str_pad(substr($validated['course_id'], 0, 3), 3, '0', STR_PAD_LEFT );
        $certificate = random_int(10000, 99999) . $student_code . $course_code . '1';

        return response()->json(['course_number' => $certificate]);
    }

    /**
     * Проверка сертификата на подлинность
     * @param  CheckCertificateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(CheckCertificateRequest $request) {
        $validated = $request->validated();

        if (substr($validated['sertikate_number'], 11, 12) == '1') {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'failed']);
    }
}
