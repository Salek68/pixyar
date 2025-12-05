<?php


use App\Http\Middleware\CheckUserPlan;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\RequestException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'plan' => CheckUserPlan::class,
    ]);
})
  ->withExceptions(function (Illuminate\Foundation\Configuration\Exceptions $exceptions) {

    // جلوگیری از نمایش خطاهای cURL
    $exceptions->report(function (RequestException $e) {
        Log::warning('cURL Error: '.$e->getMessage());
        // فقط لاگ بزن، هیچ چیز دیگری نمایش داده نشود
        return false;
    });

    // جایگزین خطای نمایشی
    $exceptions->render(function (RequestException $e, $request) {
        return response('خطا در ارتباط با سرور خارجی', 500);
        // اگر خروجی هم نمی‌خوای، می‌شود:
        // return response('', 500);
    });

})->create();
