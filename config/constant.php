<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/1/15
 * Time: 4:00 PM
 */


const API_RETURN_CODE_INIT    = 200;
const API_RETURN_CODE_WARNING = 300;
const API_RETURN_CODE_ERROR   = 400;


//---------------------------------------------


const API_RESULT_CODE_INIT = 0;

const API_ERR_CODE_REQUEST_PARAMETER      = 40001;
const API_ERR_CODE_MULTI_ERROR            = 40002;
const API_ERR_CODE_UNAUTHENTICATED        = 40021;
const API_ERR_CODE_UNAUTHENTICATED_ACTION = 40022;
const API_ERR_CODE_METHOD_NOT_ALLOWED     = 40023;


const API_ERR_CODE_TOKEN_NOT_MATCH_PROVIDER = 40010;
const API_ERR_CODE_GRANT_TYPE_ERROR         = 40011;




const API_ERR_LOGIN = 70000;


const API_ERR_CODE_SELF = 80000;


return [

    'returnTexts' => [
        API_RETURN_CODE_INIT    => '',
        API_RETURN_CODE_WARNING => '有警告',
        API_RETURN_CODE_ERROR   => '有错误',

    ],

    'resultTexts' => [
        API_RESULT_CODE_INIT => '',

        API_ERR_CODE_REQUEST_PARAMETER      => '请求参数错误',
        API_ERR_CODE_MULTI_ERROR            => '请看data详情',
        API_ERR_CODE_UNAUTHENTICATED        => '未获得授权',
        API_ERR_CODE_UNAUTHENTICATED_ACTION => '需要身份登陆访问',
        API_ERR_CODE_METHOD_NOT_ALLOWED     => '请求的Method方法错误',

        API_ERR_CODE_TOKEN_NOT_MATCH_PROVIDER => 'token与provider不匹配',
        API_ERR_CODE_GRANT_TYPE_ERROR         => '授权类型无效',


        API_ERR_CODE_SELF => "违规操作",

    ],
];
