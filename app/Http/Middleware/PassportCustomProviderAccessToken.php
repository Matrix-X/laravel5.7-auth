<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\APIController;
use Closure;

use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

use App\Http\Controllers\API\RouterAPIController;

use App\Http\Controllers\API\APIResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class PassportCustomProviderAccessToken
{

    use APIResponse;

    private $server;

    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd("passport custom provider");
        $psr = (new DiactorosFactory)->createRequest($request);
//		dd($psr);
        try {
//			dd(\Auth::guard());
            $psr = $this->server->validateAuthenticatedRequest($psr);
//			dd($psr);
            $token_id = $psr->getAttribute('oauth_access_token_id');
//			dd($token_id);

            if ($token_id) {
                $provider = RouterAPIController::getRequestProvider();

                $qb = \DB::table('oauth_access_token_providers')->where([
                    'oauth_access_token_id' => $token_id,
                    'provider' => $provider
                ]);
//				dd($qb);
                $access_token = $qb->first();
//				dd($access_token);
                if (!is_null($access_token)) {

                    \Config::set('auth.guards.api.provider', $access_token->provider);
                } else {

                    throw new \Exception("token for valid from provider", API_ERR_CODE_TOKEN_NOT_MATCH_PROVIDER);
                }
            }
        } catch (\Exception $e) {

            $this->setCustomReturnCode(API_RETURN_CODE_ERROR, $e->getCode(), $e->getMessage());
            return $this->getJSONResponse();
//            throw new HttpResponseException($this->getJSONResponse());
        }

        return $next($request);
    }


}
