<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
//
    }

    public function render($request, Throwable $exception)
    {
        if (Str::lower($request->segment(1)) === 'api') {
            if ($exception instanceof UserException) {
                $this->fail($exception->message, $exception->data, 100001, $exception->httpCode);
            } else if ($exception instanceof ValidationException) {
                return $this->fail($exception->validator->errors()->first(), $exception->errors(), 10002, $exception->status);
            } elseif ($exception instanceof ModelNotFoundException) {
                return $this->fail("一不小心数据走丢了～～～", [], 10003, 500);
            } else if ($exception instanceof NotFoundHttpException) {
                return $this->fail('路由未找到', [], 10004, $exception->getStatusCode());
            } else if ($exception instanceof MethodNotAllowedException) {
                return $this->fail('请求方法不存在', [], 10005, $exception->getStatusCode());
            } else if ($exception instanceof UnauthorizedHttpException) { //这个在jwt.auth 中间件中抛出
                return $this->fail('无效的访问令牌', null, 10006, 401);
            } elseif ($exception instanceof AuthenticationException) { //这个异常在 auth:api 中间件中抛出
                return $this->fail('无效的访问令牌', null, 10006, 401);
            } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException &&
                $exception->getStatusCode() == 403) {
                return $this->fail('没有访问权限，请联系管理员', null, 10007, $exception->getStatusCode());
            }
            return $this->fail($exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine(), null, 10000);
        } else {
            return parent::render($request, $exception);
        }

    }

    public function fail($message = 'error', $array = [], $code = 500, $http = 500)
    {
        return response()->json([
            'code' => $code,
            'error' => $message,
            'data' => $array
        ], $http);
    }
}
