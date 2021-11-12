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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $ip = $request->ip();
        $url = $request->url();
        $log = \Log::channel('error');
        $controller = new Controller();
        $message = $url . ':ip:' . $ip . ':异常请求:' . json_encode($request->all()) . ':bug:' . $exception->getMessage();
        if ($exception instanceof InvalidRequestException) {
            return $controller->fail($exception->getMessage());
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $log->warning($message);
            return $controller->failSystem(ResponseEnum::RESPONSE_NO_FOUND);
        }
        $log->error($message);
        return $controller->failSystem(ResponseEnum::RESPONSE_ERROR);
    }
}
