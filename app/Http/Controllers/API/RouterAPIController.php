<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RouterAPIController extends APIController
{
    //


    /**
     * Constructor.
     *
     * @param  \Illuminate\Http\Request $request
     * @return $mix
     */
    public function __construct(Request $request)
    {

        parent::__construct($request);

        $this->configAuthMiddleware($request);

    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response $response
     */
    public function index(Request $request)
    {

//		dd($request);
//		return \Route::redirect('machine1');
//		dd($request);
        $method = \Request::header('method');
//		dd($method);
        $uri = route($method, [], false);
//		dd($uri);

        $reqMethod = $request->method();

//		dd(\Auth::user());

        $server = $request->server();
        $server['SERVER_NAME'] = env('APP_WHITE_LIST_URL');
        $server['HTTP_HOST'] = env('APP_WHITE_LIST_URL');
        $server['REQUEST_URI'] = $uri;
        $req = $request->duplicate(null, null, null, null, null, $server);
        $req->setMethod($reqMethod);
//		dd($req);
        $response = \Route::dispatch($req);
//        dd($response);
        return $response;

    }


    /**
     * Config auth middleware.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string $provider
     */
    public function configAuthMiddleware(Request $request)
    {

        $provider = $this::getRequestProvider();
//		dd($provider);
        $guard = $this::getGuardFromRequestProvider($provider);
//		dd($guard);

        if ($provider == 'client') {
            $this->middleware(["{$guard}", 'passportAccessToken']);
        } else {
            // ToCheck
            $this->middleware(["auth:{$guard}", 'passportAccessToken']);
        }
//		dd($this);


    }


    /**
     * Get request provider.
     *
     *
     * @return string $provider
     */
    public static function getRequestProvider()
    {

        $provider = \Request::header('provider');
        if (is_null($provider) || $provider == '') {
            $provider = "users";
        }

        return $provider;
    }

    /**
     * Get guard from request provider.
     *
     * @param string $provider
     * @return string $guard
     */
    public static function getGuardFromRequestProvider($provider)
    {

        // read config data
        $providerToGuard = \Config::get('auth.providerToGuard');
//		dd($providerToGuard);

        $guard = $providerToGuard[$provider];
//        dd($guard);

        return $guard;
    }

}
