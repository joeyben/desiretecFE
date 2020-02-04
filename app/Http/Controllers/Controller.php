<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function responseJson(array $result = []): JsonResponse
    {
        $result['success'] = true;
        $result['status'] = Flag::STATUS_CODE_SUCCESS;

        return response()->json($result, $result['status'], [
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => '*',
            'Access-Control-Allow-Headers' => '*',
        ], JSON_NUMERIC_CHECK);
    }

    protected function responseJsonPaginated($data = null): JsonResponse
    {
        return response()->json($data, Flag::STATUS_CODE_SUCCESS, [], JSON_NUMERIC_CHECK);
    }

    protected function responseJsonError(Exception $e): JsonResponse
    {
        if (method_exists(\get_class($e), 'getResponse')) {
            return $e->getResponse();
        }

        Log::error($e);

        $statusCode = (0 !== $e->getCode()) ? $e->getCode() : Flag::STATUS_CODE_ERROR;

        $result = [
            'success'   => false,
            'exception' => \get_class($e),
            'message'   => $e->getMessage(),
            'status'    => $statusCode,
        ];

        return response()->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}
