<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 14/02/2018
 * Time: 2:34 PM
 */

namespace App\Http\Controllers\API;


use Illuminate\Http\Response;

trait APIResponse
{

    /**
     * @var int
     */
    protected $m_returnCode;
    protected $m_returnMessage;

    protected $m_resultCode;
    protected $m_resultMessage;

    public $m_arrayData;


    /**
     * reset return code.
     *
     * @return void
     */
    public function resetReturnCode()
    {

        $this->m_returnCode = API_RETURN_CODE_INIT;
        $this->m_returnMessage = $this->getConfigMessage('returnTexts', $this->m_returnCode);
    }

    /**
     * reset result code.
     *
     * @return void
     */
    public function resetResultCode()
    {

        $this->m_resultCode = API_RESULT_CODE_INIT;
        $this->m_returnMessage = $this->getConfigMessage('resultTexts', $this->m_resultCode);
    }


    /**
     * Reset codes.
     *
     * @return void
     */
    public function resetCodes()
    {

        $this->resetReturnCode();
        $this->resetResultCode();

    }


    /**
     * Is no error.
     *
     * @return boolean
     */
    public function isNoError()
    {

        return $this->m_returnCode == API_RETURN_CODE_INIT;
    }


    /**
     * Set return code.
     *
     * @param  int $iReturnCode
     *
     * @return void
     */
    public function setReturnCode($iReturnCode)
    {

        $this->m_returnCode = $iReturnCode;
        $this->m_returnMessage = $this->getConfigMessage('returnTexts', $this->m_returnCode);
    }

    /**
     * Set result code.
     *
     * @param  int $iErrCode
     *
     * @return void
     */
    public function setResultCode($iReturnCode)
    {

        $this->m_resultCode = $iReturnCode;
        $this->m_resultMessage = $this->getConfigMessage('resultTexts', $this->m_resultCode);
    }

    /**
     * Set codes.
     *
     * @param  int $iReturnCode
     * @param  int $iReturnCode
     *
     * @return void
     */
    public function setCode($iReturnCode, $iResultCode)
    {

        $this->m_returnCode = $iReturnCode;
        $this->m_returnMessage = $this->getConfigMessage('returnTexts', $this->m_returnCode);
        $this->m_resultCode = $iResultCode;
        $this->m_resultMessage = $this->getConfigMessage('resultTexts', $this->m_resultCode);


    }

    /**
     * Set custom return codes.
     *
     * @param  int $iReturnCode
     * @param $iResultCode
     * @param  string $iReturnMsg
     *
     * @return void
     */
    public function setCustomReturnCode($iReturnCode, $iResultCode, $iReturnMsg = "")
    {

        $this->m_returnCode = $iReturnCode;
        $this->m_returnMessage = $this->getConfigMessage('returnTexts', $iReturnCode);
        $this->m_resultCode = $iResultCode;
        $this->m_resultMessage = $iReturnMsg != "" ? $iReturnMsg : $this->getConfigMessage('resultTexts', $iResultCode);

    }

    /**
     * Set customer return message.
     * @param $iReturnMsg
     * @param int $iReturnCode
     * @return mixed
     */
    public function setCustomerReturnMessage($iReturnMsg, $iReturnCode = API_RETURN_CODE_ERROR)
    {
        $this->m_returnCode = $iReturnCode;
        $this->m_returnMessage = $this->getConfigMessage('returnTexts', $iReturnCode);
        $this->m_resultCode = 0;
        $this->m_resultMessage = $iReturnMsg;
        return $iReturnMsg;
    }

    /**
     * Set custom return codes.
     *
     * @param string $key
     * @param string $code
     * @return string $strMessage
     */
    protected function getConfigMessage($key = 'returnTexts', $code = '')
    {

        $strMessage = config("constant.{$key}.{$code}");

        return $strMessage;
    }


    /**
     * Get data.
     *
     * @return array $arrayData
     */
    public function getData()
    {

        return $this->m_arrayData;

    }

    /**
     * Set data.
     *
     * @param  array $arrayData
     * @return void
     */
    public function setData($arrayData)
    {

        $this->m_arrayData = $arrayData;

    }

    /**
     * Put data with key value.
     *
     * @param  string $strKey
     * @param  string $strValue
     * @return void
     */
    public function pushDataWithKeyValue($strKey, $strValue)
    {

//        dd($this->m_arrayData);
        $this->m_arrayData = array_add($this->m_arrayData, $strKey, $strValue);


    }

    /**
     * Get json response.
     *
     * @param  null
     * @return Response response
     */
    public function getJSONResponse($code = 200)
    {

        $arrayResult["meta"]["return_code"] = $this->m_returnCode;
        $arrayResult["meta"]["return_message"] = $this->m_returnMessage;
        $arrayResult["meta"]["result_code"] = $this->m_resultCode;
        $arrayResult["meta"]["result_message"] = $this->m_resultMessage;

        $arrayResult["data"] = $this->m_arrayData;

//        dd($arrayResult);
        return response()->json($arrayResult, $code)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
//		return \Response::json($arrayResult)->setJsonOptions(JSON_UNESCAPED_UNICODE);


    }


}
