<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


use App\Http\Controllers\API\APIResponse;

use Illuminate\Auth\Access\AuthorizationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exceptions\HttpResponseException;

class Handler extends ExceptionHandler
{
    use APIResponse;

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
//        dump(get_class($exception));
        switch (get_class($exception)) {
            case OAuthServerException::class:
                $this->setCustomReturnCode(API_RETURN_CODE_ERROR, $exception->getCode(),  $exception->getMessage());
                throw new HttpResponseException($this->getJSONResponse($exception->getHttpStatusCode()));

                break;

        }

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
        // render by our definition
//		dd($exception);

        $classException = get_class($exception);

        $code = API_RETURN_CODE_INIT;

        if($exception->getMessage() == 'Unauthenticated.'){
//            $code = 401;
            $this->setCode(API_RETURN_CODE_ERROR, API_ERR_CODE_UNAUTHENTICATED);
        }else if($exception instanceof AuthorizationException){
            $this->setCode(API_RETURN_CODE_ERROR, API_ERR_CODE_SELF);
        }
        else if($classException==MethodNotAllowedHttpException::class){

            $this->setCode(API_RETURN_CODE_ERROR, API_ERR_CODE_METHOD_NOT_ALLOWED);
        }else{

//            $this->pushDataWithKeyValue($exception->getCode(), $exception->getMessage());
//            $this->setCode(API_RETURN_CODE_ERROR, API_ERR_CODE_MULTI_ERROR);
            $this->setCustomReturnCode(API_RETURN_CODE_ERROR, $exception->getCode(), $exception->getMessage());

        }

//        dd($code);
        return $this->getJSONResponse($code);

//        return parent::render($request, $exception);
    }
}
