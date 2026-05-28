<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Symfony\Component\HttpFoundation\Response;

final class DeployWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $secret     = config()->string('app.deploy.secret');
        $scriptPath = config()->string('app.deploy.script_path');

        if (
            empty($secret) ||
            ! hash_equals($secret, (string) $request->header('X-Deploy-Token'))
        ) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized action.',
            ], Response::HTTP_FORBIDDEN);
        }

        $result = Process::timeout(300)
            ->path(base_path())
            ->run('bash "' . $scriptPath . '"');

        if ($result->failed()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Deployment script execution failed.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Deployment executed successfully.',
        ], Response::HTTP_OK);
    }
}
