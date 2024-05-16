<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $exception->errors()
            ], 422);
        }

        // Handle not found exceptions
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        // Handle authentication exceptions
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
                'errors' => $exception->getMessage()
            ], 401);
        }

        // Handle other exceptions
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'errors' => $exception->getMessage()
        ], 500);
    }
}
