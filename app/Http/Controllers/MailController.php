<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\MailService;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function sendEmail(int $seller_id)
    {
        $mailService = new MailService();
        $status = $mailService->processDailyEmailsBySellerId($seller_id);

        if (!$status) {
            $data = [
                'success' => false,
                'data' => [],
                'message' => 'Algo deu errado ao enviado o e-mail.',
                'code' => Response::HTTP_BAD_REQUEST,
            ];

            return ApiResponse::response($data);
        }

        $data = [
            'success' => true,
            'data' => [],
            'message' => 'E-mail enviado com sucesso.',
            'code' => Response::HTTP_OK
        ];

        return ApiResponse::response($data);
    }
}
