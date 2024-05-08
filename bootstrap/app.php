<?php

use App\Exceptions\HttpException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Events/Tenants',
        __DIR__.'/../app/Listeners/Tenants',
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            $status = $exception->getStatusCode();
            $message = __("http.$status") !== "http.$status"
                ? __("http.$status")
                : __("http.default");

            return jsonResponse(
                message: $message,
                data: [],
                statusCode: $status
            );
        });
    })
    ->create();
