<?php

namespace App\Http\Controllers\API;

//use App\Http\Resources\Customer\CustomerResource;
use App\Logger\SCLogger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\API\APIResponse;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    //
    const DATE_FORMAT = "Y-m-d";
    const DATE_TIME_FORMAT = "Y-m-d H:i:s";

    use APIResponse;

    public $logger = null;

    const REGISTER_CAPTCHA = 'register.captcha';

    /**
     * Constructor.
     *
     * @param  \Illuminate\Http\Request $request
     * @return $mix
     */
    public function __construct(Request $request)
    {

//		$this->m_requestData = $this->getRequestData($request);

        $this->resetCodes();

        $this->logger = new SCLogger();


    }


    /**
     * Result codes translation table.
     *
     * @param  \Illuminate\Http\Request $request
     * @var array
     */
    public function getRequestData(Request $request)
    {

        $arrayData = null;
        if (!$request->isJson()) {
            $this->setCode(API_RETURN_CODE_ERROR,
                API_ERR_CODE_REQUEST_PARAMETER);

        } else {
            $arrayData = $request->json()->all();
//			dd($arrayData);
            if (!is_array($arrayData)) {
                $this->setCode(API_RETURN_CODE_ERROR,
                    API_ERR_CODE_REQUEST_PARAMETER);

                return null;
            }
        }

        return $arrayData;
    }


    /**
     * @param Request $request
     */
    public function apiCheckToken(Request $request)
    {

        $authLogin = \Auth::user();

        $provider = RouterAPIController::getRequestProvider();

        $resource = null;

        if ($provider == 'customers') {
            $resource = new CustomerResource($authLogin);
        } else if ($provider == 'employees') {
            $resource = new EmployeeResource($authLogin);
        }

        $this->setData($resource);

        return $this->getJSONResponse();

    }

    /**
     * Shortcut for some test code.
     *
     * @param  \Illuminate\Http\Request $request
     * @var mixed
     */
    public function apiTest(Request $request)
    {


//        \Log::stack(['single'])->info('something log in single');
//        \Log::stack(['single'])->info('order insert record', ['orderSN' => '11111']);
//        \Log::stack(['custom'])->info('add order', ['orderSN' => '22222']);
//        \Log::stack(['custom'])->debug('update order', ['orderSN' => '33333']);
//        \Log::stack(['custom'])->warning('delete order', ['orderSN' => '33333']);
//        \Log::stack(['custom'])->critical('delete order', ['orderSN' => '44444']);


//        $this->setCode(API_RETURN_CODE_ERROR, API_ERR_CODE_TOKEN_NOT_MATCH_PROVIDER);

        $this->setData(Auth::user());
        return $this->getJSONResponse();
//		dd($chairman);

//		$generalManager = Role::with(['childrenRoles','parentRole'])->find(2);
//		dd($generalManager);

    }

    public function needAuth()
    {
        $authLogin = \Auth::user();
        if (is_null($authLogin)) {

            $this->setCode(API_RETURN_CODE_ERROR, API_ERR_CODE_UNAUTHENTICATED_ACTION);

            return $this->getJSONResponse();

        }

        return $authLogin;

    }

    public static function checkCaptcha($captcha,$token)
    {
        $code = \Cache::tags(self::REGISTER_CAPTCHA)->get('client_'.$token);
        if($captcha == $code)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
