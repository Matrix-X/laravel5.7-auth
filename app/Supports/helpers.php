<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 19/01/2017
 * Time: 9:30 PM
 */


use Carbon\Carbon;

/*  security
**---***---***---***---***---***---***---***---***---***---**
*/


if (!function_exists('encryptPassword')) {
    /**
     * 密碼加密 CI框架的密码算法.
     *
     * @param	string	$strPassword
     *
     * @return	string	- 加密後字串
     *
     */
    function encryptPassword($strPassword) {
        $_key	= 'Y9q2sdg944$%^&@%))3Wm6F24';
        return sha1(md5($strPassword.base64_encode($_key)));
    }
}



if (!function_exists('hashPassword')) {
    /**
     * hash password.
     *
     * @param  string $strPlainPass
     * @return string
     */
    function hashPassword($strPlainPass)
    {

        $encodedPassword = hash('sha256', $strPlainPass, false);

        return $encodedPassword;

    }
}


if (!function_exists('encodeHashedPassword')) {
    /**
     * Encode hashed password.
     *
     * @param  string $strHashedPassword
     * @return string
     */
    function encodeHashedPassword($strHashedPassword)
    {

        $strEncodedPassword = bcrypt($strHashedPassword);

        return $strEncodedPassword;

    }
}


if (!function_exists('encodePlainPassword')) {
    /**
     * Encode plain password.
     *
     * @param  string $strPlainPassword
     * @return string
     */
    function encodePlainPassword($strPlainPassword)
    {

        $strHashPassword = hashPassword($strPlainPassword);
        $strEncodedPassword = encodeHashedPassword($strHashPassword);

        return $strEncodedPassword;

    }
}




/*  user
**---***---***---***---***---***---***---***---***---***---**
*/
if (!function_exists('isMobileValid')) {
    /**
     * Is mobile valid or not.
     *
     * @param  string $strMobile
     * @return boolean
     */
    function isMobileValid($strMobile)
    {

        return preg_match("/1[345789]{1}\d{9}$/", $strMobile);

    }
}


/*  system
**---***---***---***---***---***---***---***---***---***---**
*/
if (!function_exists('guid')) {
    /**
     * Create a Global Unque ID
     *
     * @param  string $mx
     * @return strID
     */
    function guid($mx = 999999, $bUpper = false)
    {
        if ($bUpper) {
            return strtoupper(md5(microtime() . mt_rand(0, $mx)));
        } else {
            return strtolower(md5(microtime() . mt_rand(0, $mx)));
        }

    }

}


/*  general
**---***---***---***---***---***---***---***---***---***---**
*/
if (!function_exists('isValidateDate')) {


    /**
     * Is valid date
     *
     * @param  string $strDate
     * @param  string $format
     * @return Boolean
     */
    function isValidateDate($strDate, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $strDate);
//		dd($d);
        return $d && $d->format($format) == $strDate;
    }
}


if (!function_exists('getDateDurationFormat')) {


    /**
     * Get date duration format
     *
     * @param  string $strDate
     * @param  string $format
     * @return DateInterval $duration
     */
    function getDateDurationFormat($strDate, $format = 'Y-m-d H:i:s')
    {
//		dd($strDate);
        $date = Carbon::createFromFormat(AdminController::DATETIME_FORMAT, $strDate);
        $baseDate = Carbon::createFromTimestamp(0);

        // date relative to base date. not the order
        $duration = $baseDate->diff($date);

//		dd($duration);

        return $duration;
    }


}


if (!function_exists('getDateDurationBetweenDaysFormat')) {
    /**
     * Get date duration between days formats
     *
     * @param  string $strDate
     * @param  string $format
     * @return DateInterval $duration
     */
    function getDateDurationBetweenDaysFormat($strDate1, $strDate2, $format = 'Y-m-d H:i:s')
    {
        $date1 = Carbon::createFromFormat(AdminController::DATETIME_FORMAT, $strDate1);
        $date2 = Carbon::createFromFormat(AdminController::DATETIME_FORMAT, $strDate2);

        // date relative to base date. not the order
        $duration = $date1->diff($date2);

//		dd($duration);

        return $duration;
    }

}


if (!function_exists('getBaseDateDurationFormat')) {


    /**
     * Get date duration format
     *
     * @param  string $strDate
     * @param  string $format
     * @return DateInterval $duration
     */
    function getBaseDateDurationFormat($strDateStart, $strDateEnd, $format = 'Y-m-d H:i:s')
    {
//		dd($strDate);
        $dateStart = Carbon::createFromFormat(AdminController::DATETIME_FORMAT, $strDateStart);
        $dateEnd = Carbon::createFromFormat(AdminController::DATETIME_FORMAT, $strDateEnd);

        $baseDate = Carbon::createFromTimestamp(0);

        // date relative to base date. not the order
        $duration = $dateStart->diff($dateEnd);

        $baseDateDuration = $baseDate->add($duration);

//		dd($duration);

        return $baseDateDuration;
    }


}


if (!function_exists('addDateWithDateInterval')) {
    /**
     * add date with Date Interval
     *
     * @param  string $strDate
     * @param  string $format
     * @return DateInterval $duration
     */
    function addDateWithDateInterval($strDate, $dateInterval)
    {
        $dateBase = Carbon::createFromFormat(DATETIME_FORMAT, $strDate, \Config::get('app.timezone'));

        $duration = $dateBase->add($dateInterval);
//		dd($duration);
        return $duration;
    }

}


if (!function_exists('getMIMEType')) {


    /**
     * Get MINE type with Base64 string
     *
     * @param  string $base64string
     *
     * @return string $strExtension
     */

    function getMIMEType($base64string)
    {
        preg_match("/^data:image\/(.*);base64/", $base64string, $match);

        return $match[1];
    }
}


if (!function_exists('getBase64Header')) {


    /**
     * Get MINE type with Base64 string
     *
     * @param  string $base64string
     * @param  string $imageType
     *
     * @return string $strHeader
     */

    function getBase64Header($base64string, $imageType)
    {
        return ("data:image\/" . $imageType . ";base64,");
    }
}

if (!function_exists('filterBase64Data')) {


    /**
     * Get MINE type with Base64 string
     *
     * @param  string $base64Data
     * @param  string $strHeader
     *
     * @return string $data
     */

    function filterBase64Data($base64Data)
    {

        $data = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);

        return $data;

    }


    if (!function_exists('generateNewOrderSN')) {
        /**
         * 得到新订单号
         * @param $preName
         * @return string
         */
        function generateNewOrderSN($preName)
        {
            return $preName . substr(time(), 5) . generateCode() . substr(time(), 0, 5);
        }
    }

    if (!function_exists('generateCode')) {
        /**
         * generate code
         * @param int $length
         * @return int
         */
        /*返回指定长度随机数字*/
        function generateCode($length = 6)
        {
            return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
        }
    }

    if (!function_exists('isTrueFloat')) {
        function isTrueFloat($val)
        {
            $pattern = '/^[-+]?(((\\\\d+)\\\\.?(\\\\d+)?)|\\\\.\\\\d+)([eE]?[+-]?\\\\d+)?$/';

            return (!is_bool($val) && (preg_match($pattern, trim($val)) || is_float($val)));
        }
    }



    if (!function_exists('remainChineseCharacters')) {
        function remainChineseCharacters($str)
        {

//            $str = preg_replace('/[0-9]+/', '', $str);



            preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $str, $matches);
            $str = join('', $matches[0]);

            $str = str_replace('`', '', $str);
            $str = str_replace('·', '', $str);
            $str = str_replace('~', '', $str);
            $str = str_replace('!', '', $str);
            $str = str_replace('！', '', $str);
            $str = str_replace('@', '', $str);
            $str = str_replace('#', '', $str);
            $str = str_replace('$', '', $str);
            $str = str_replace('￥', '', $str);
            $str = str_replace('%', '', $str);
            $str = str_replace('^', '', $str);
            $str = str_replace('……', '', $str);
            $str = str_replace('&', '', $str);
            $str = str_replace('*', '', $str);
            $str = str_replace('(', '', $str);
            $str = str_replace(')', '', $str);
            $str = str_replace('（', '', $str);
            $str = str_replace('）', '', $str);
            $str = str_replace('-', '', $str);
            $str = str_replace('_', '', $str);
            $str = str_replace('——', '', $str);
            $str = str_replace('+', '', $str);
            $str = str_replace('=', '', $str);
            $str = str_replace('|', '', $str);
            $str = str_replace('\\', '', $str);
            $str = str_replace('[', '', $str);
            $str = str_replace(']', '', $str);
            $str = str_replace('【', '', $str);
            $str = str_replace('】', '', $str);
            $str = str_replace('{', '', $str);
            $str = str_replace('}', '', $str);
            $str = str_replace(';', '', $str);
            $str = str_replace('；', '', $str);
            $str = str_replace(':', '', $str);
            $str = str_replace('：', '', $str);
            $str = str_replace('\'', '', $str);
            $str = str_replace('"', '', $str);
            $str = str_replace('“', '', $str);
            $str = str_replace('”', '', $str);
            $str = str_replace(',', '', $str);
            $str = str_replace('，', '', $str);
            $str = str_replace('<', '', $str);
            $str = str_replace('>', '', $str);
            $str = str_replace('《', '', $str);
            $str = str_replace('》', '', $str);
            $str = str_replace('.', '', $str);
            $str = str_replace('。', '', $str);
            $str = str_replace('/', '', $str);
            $str = str_replace('、', '', $str);
            $str = str_replace('?', '', $str);
            $str = str_replace('？', '', $str);
            $str = str_replace('一', '', $str);
            return trim($str);


        }
    }

}

