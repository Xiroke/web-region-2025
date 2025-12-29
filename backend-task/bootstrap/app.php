<?php

use App\Http\Middleware\ForceJsonMiddleware;
use App\Http\Middleware\IsAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'school-api'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Принудительно возвращает json для api
        $middleware->prependToGroup('api', [
            ForceJsonMiddleware::class
        ]);
        // подключение middleware
        $middleware->alias(['admin' => IsAdmin::class]);
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Принудительный ответ в виде json для ошибок в api
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('school-api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        // Переопределение ошибки
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json(["message"=> "Forbidden for you"]);
        });
    })->create();
