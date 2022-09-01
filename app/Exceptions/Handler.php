<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Session;
use Redirect;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        if(!env('APP_DEBUG')){
            if ($exception instanceof \PDOException) 
            {
                Session::flash('error', true);
                return Redirect::back()->withErrors($exception->errorInfo[0] . " - " . $exception->errorInfo[2])->withInput($request->all());
            }
    
            if($exception instanceof \ErrorException){
                dd($exception);
                return redirect('painel/500');
            }
        }

        if($exception instanceof \Artistas\PagSeguro\PagSeguroException){
            Session::flash('error', true);
            return Redirect::back()->withErrors($exception->getCode() . " - " . $exception->getMessage())->withInput($request->all());
        }

        if($exception->getMessage() == 'Unauthenticated.'){
            if ($request->expectsJson() || substr($request->path(), 0, 3) == 'api' || $request->path() == 'announcement') {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }else{
                return redirect('painel/login');
            }
        }
        
        return parent::render($request, $exception);
        
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || substr($request->path(), 0, 3) == 'api') {
            
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
 
        return redirect()->guest(route('login'));
    }
}
