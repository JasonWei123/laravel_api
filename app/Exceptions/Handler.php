<?php

namespace App\Exceptions;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Libs\Constant\Res;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $ip = $request->ip();
        $url = $request->url();
        $log = \Log::channel('error');
        $controller = new Controller();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $message = $url . ':ip:' . $ip .
            'file:' . $file . ':' .
            'line:' . $line . ':' .
            ':异常请求:' . json_encode($request->all()) .
            ':bug:' . $exception->getMessage();
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $log = \Log::channel('validation');
            $failed = $exception->validator->messages()->messages();
            $failedRules = $exception->validator->failed();
            $logArr = [
                'failed' => $failed,
                'failedRules' => $failedRules,
            ];
            $log->info($message, $logArr);

            return $controller->fail($exception->validator->messages()->messages());
        }
        if ($exception instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            $log->warning($message);
            $retry_after = @$exception->getHeaders()['Retry-After'] . ' s';
            return $controller->failSystem(ResponseEnum::REQUEST_MORE, ['aretry_after' => $retry_after], $exception->getHeaders());
        }
        if ($exception instanceof ResponseSystemException) {
            $log = \Log::channel('system');
            $log->warning($message);
            return $controller->failSystem($exception->getMessage());
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $log->warning($message);
            return $controller->failSystem(ResponseEnum::RESPONSE_NO_FOUND);
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
            return $controller->failSystem(ResponseEnum::BROADCASTERS_AUTH_FAIL);
        }
        $log->error($exception);
        if (app()->environment() === 'local') {
            return $controller->failSystem(ResponseEnum::RESPONSE_ERROR, $exception->getTrace());
        }
        return $controller->failSystem(ResponseEnum::RESPONSE_ERROR);
    }
}
