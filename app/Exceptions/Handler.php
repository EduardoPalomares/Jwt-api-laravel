<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use App\Traits\ApiResponser;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Asm89\Stack\CorsService;
//use \Spatie\Permission\Exceptions\UnauthorizedException;

class Handler extends ExceptionHandler
{
  use ApiResponser;
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
      $response = $this->handleException($request,$exception);
      app(CorsService::class)->addActualRequestHeaders($response,$request);
      return $response;
    }

    public function handleException($request,Exception $exception)
    {
      if($exception instanceof ValidationException){

        return $this->convertValidationExceptionToResponse($exception,$request);
      }
      if($exception instanceof ModelNotFoundException){
        $modelo=$exception->getModel();
        return $this->errorResponse("No existe ninguna instancia de $modelo con el ID especificado",404);
      }
      if ($exception instanceof AuthenticationException ) {
        return $this->unauthenticated($request,$exception);
      }
      if ($exception instanceof AuthorizationException ) {
        return $this->errorResponse('No cuentas con los permisos para ejecuar esta accion',403);
      }
      if ($exception instanceof NotFoundHttpException) {
        return $this->errorResponse('No se encontro la URL especificada',404);
      }
      if ($exception instanceof MethodNotAllowedHttpException) {
        return $this->errorResponse('El metodo especificado en la petición No es valido',405);
      }
      if ($exception instanceof HttpException) {

        return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
      }
      if($exception instanceof TokenBlacklistedException){
        return $this->errorResponse('Token enviado expirado, refresca tu sesion',500);
      }
      if ($exception instanceof UnauthorizedException) {
        return $this->errorResponse('No cuentas con los permisos para ejecuar esta acción',403);
      }

      /**¨falat exceopcion de relaicons 1451**/

      if(config('app.debug')){
        return parent::render($request, $exception);
      }
      return $this->errorResponse('Falla inesperada intente más tarde',500);
    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {

        //$errors = $e->getMessage();
        $errors = $e->validator->errors()->getMessages();
        if ($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors, 422) : redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors($errors);
        }
      //  return response()->json($errors,422)
        return $this->errorResponse($errors, 422);
    }

    private function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        //return $this->errorResponse('No autenticad', 401);
    }


}
