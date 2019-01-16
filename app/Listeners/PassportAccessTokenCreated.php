<?php

namespace App\Listeners;

use App\Http\Controllers\API\APIController;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Events\AccessTokenCreated;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Http\Controllers\API\APIResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class PassportAccessTokenCreated
{
    use APIResponse;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        //
        $params = \Request::all();
        if (array_key_exists('grant_type', $params)) {
            $grantType = $params['grant_type'];
        } else {
            $grantType = null;
        }
//		dd($grantType);

        if ($grantType == 'client_credentials') {
            $provider = 'client';
        } else if ($grantType == 'password') {
            $provider = \Config::get('auth.guards.api.provider');
        }

        if (is_null($provider)) {
            // throw exception

            $this->setCode(API_RETURN_CODE_ERROR,
                API_ERR_CODE_TOKEN_NOT_MATCH_PROVIDER);

            throw new HttpResponseException($this->getJSONResponse());
        }


//	    dd($provider);
        \DB::table('oauth_access_token_providers')->insert([
            "oauth_access_token_id" => $event->tokenId,
            "provider" => $provider,
            "created_at" => new Carbon(),
            "updated_at" => new Carbon(),
        ]);
    }
}
