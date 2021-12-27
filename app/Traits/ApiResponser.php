<?php

namespace App\Traits;

trait ApiResponser
{

    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    protected function respondSuccess($data = null, $statusCode = 200, $headers = [])
    {
        return $this->respond(
            [
                'success' => true,
                'data' => $data,

            ],
            $statusCode,
            $headers
        );
    }

    protected function respondSuccessWithPagination($data = null, $total = 0, $statusCode = 200, $headers = [])
    {
        return $this->respond(
            [
                'success' => true,
                'data' => $data,
                'pagination' => [
                    'total' => $total
                ]

            ],
            $statusCode,
            $headers
        );
    }

    protected function respondError($message, $errors = [], $status = 500)
    {
        return $this->respond(
            [
                'message' => $message,
                'errors' => $errors
            ],
            $status
        );
    }

    protected function respondBadRequest($message = 'Bad Request')
    {
        return $this->respondError($message, [], 400);
    }

    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, [], 401);
    }

    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, [], 403);
    }

    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, [], 404);
    }

    protected function respondUnprocessableEntity($message = 'Unprocessable Entity')
    {
        return $this->respondError($message, [], 422);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, [], 500);
    }
}
