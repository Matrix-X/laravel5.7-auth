<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/1/15
 * Time: 4:07 PM
 */


namespace App\Logger;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SCLogger extends Controller
{
    //
    protected $m_remoteIP = null;

    protected $m_requestMethod = null;
    protected $m_uri = null;
    protected $m_fullURL = null;

    private $m_remoteDriver = "daily";


    /**
     * SCLogger constructor.
     */
    public function __construct()
    {

        $this->m_request_method = \Request::method();
        $this->m_uri = \Request::header('method');
        $this->m_full_url = \Request::fullUrl();
        $this->m_remote_ip = $_SERVER['REMOTE_ADDR'] ?? null;


    }

    public function logLocal($action = 'info', $message, $arrayData = null)
    {

        $data = $this->getData($arrayData);

        \Log::$action($message, $data);

    }

    public function logRemote($action = 'info', $message, $arrayData = null)
    {

        $data = $this->getData($arrayData);

        \Log::channel($this->m_remoteDriver)->$action($message, $data);

    }

    public function logAll($action = 'info', $message, $arrayData = null)
    {

        $data = $this->getData($arrayData);
        \Log::$action($message, $data);
        \Log::channel($this->m_remoteDriver)->$action($message, $data);

    }

    private function getData($arrayData)
    {

        $data = [
            'ip' => $this->m_remote_ip,
            'method' => $this->m_request_method,
            'uri' => $this->m_uri,
            'data' => $arrayData,
        ];

        return $data;

    }

}
