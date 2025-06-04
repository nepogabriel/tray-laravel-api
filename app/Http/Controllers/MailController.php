<?php

namespace App\Http\Controllers;

use App\Repositories\SaleRepository;
use App\Services\MailService;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function sendEmail()
    {
        $mailService = new MailService(new SaleRepository());
        $status = $mailService->processDailyEmails();

        if (!$status) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Algo deu errado ao enviado o e-mail.',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'E-mail enviado com sucesso.',
            ], Response::HTTP_OK);
    }
}
