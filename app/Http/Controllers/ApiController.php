<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Success Response.
     *
     * @param object|array<mixed>|null $data
     * @param array<string, mixed>     $extra
     * @param array<mixed>|string|null $message
     * @param int                      $code
     * @param array<string, mixed>     $headers
     * @param int                      $options
     *
     * @return JsonResponse
     */
    public function success(
        $data = [],
        array $extra = [],
        $message = null,
        int $code = 200,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return $this->processReturn('success', $data, $message, null, $code, $headers, $options, $extra);
    }

    /**
     * Error Response.
     *
     * @param string       $error
     * @param int          $code
     * @param array<mixed> $headers
     * @param int          $options
     *
     * @return JsonResponse
     */
    public function error(string $error = '', int $code = 400, array $headers = [], int $options = 0): JsonResponse
    {
        if (empty($error)) {
            $error = error_get_last()['message'] ?? 'Error';
        }

        return $this->processReturn('failed', [], null, $error, $code, $headers, $options);
    }

    /**
     * @param string                   $status
     * @param object|array<mixed>|null $data
     * @param array<mixed>|string|null $message
     * @param string|null              $error
     * @param int                      $code
     * @param array<mixed>             $headers
     * @param int                      $options
     * @param array<mixed>             $extra
     *
     * @return JsonResponse
     */
    private function processReturn(
        string $status,
        mixed  $data,
        string $message = null,
        ?string $error = null,
        int $code = 200,
        array $headers = [],
        int $options = 0,
        array $extra = []
    ) {
        if ($data === null) {
            $data = new \stdClass();
        }
        $response = [
            'status'  => $status,
            'data'    => $data,
            'message' => $message,
            'error'   => $error,
        ];

        if (!empty($extra)) {
            $response = array_merge($response, ['extra_data' => $extra]);
        }

        return response()->json($response, $code, $headers, $options);
    }
}
