<?php

namespace App\Extend;


class Utils
{
    public static function fenToYuan($fen)
    {
        if (empty($fen) || !is_numeric($fen)) {
            return 0;
        }
        $result = number_format($fen / 100, 2, '.', '');
        return $result;
    }

    //不带小数的元
    public static function fenToYuanInt($fen)
    {
        if (empty($fen) || !is_numeric($fen)) {
            return 0;
        }
        if (($fen % 100) > 0) {
            $result = number_format($fen / 100, 2, '.', '');
        } else {
            $result = number_format($fen / 100, 0, '', '');
        }
        return $result;
    }

    public static function yuanToFen($yuan)
    {
        if (empty($yuan) || !is_numeric($yuan)) {
            return 0;
        }
        $result = number_format($yuan * 100, 0, '', '');
        return $result;
    }

    public static function WaitingForReview($app = "GUIXUE")
    {
        $version = self::getAppVersion();

        if (self::isToeflApp()) {
            if (self::isIOS() && $version['version'] == 1.25) {
                return true;
            }
        }

        if (self::isCetProApp()) {
            if (self::isIOS() && $version['version'] == 1.0) {
                return true;
            }
        }


        if (self::isCetApp()) {
            if (self::isIOS() && $version['version'] == 1.13) {
                return true;
            }
        }

        if (self::isIelts45App()) {
            if (self::isIOS() && $version['version'] == 2.742) {
                return true;
            }
        }


        if (self::isIeltsApp()) {
            if (self::isIOS() && $version['version'] == 2.755) {
                return true;
            }
        }

        if (self::isSatApp()) {
            if (self::isIOS() && $version['version'] == 1.05) {
                return true;
            }
        }

        return false;
    }

    public static function isIpad()
    {
        return strpos(env('HTTP_USER_AGENT'), 'iPad') !== false;
    }

    public static function isIpod()
    {
        return strpos(env('HTTP_USER_AGENT'), 'iPod') !== false;
    }

    public static function isIphone()
    {
        return strpos(env('HTTP_USER_AGENT'), 'iPhone') !== false;
    }

    public static function isIOS()
    {
        return (strpos(env('HTTP_USER_AGENT'), 'iPad') !== false) || (strpos(env('HTTP_USER_AGENT'), 'iPhone') !== false) || (strpos(env('HTTP_USER_AGENT'), 'iPod') !== false);
    }

    /*
   *获取Android的设备id
   */
    public static function getAndroidDeviceid()
    {

        $deviceid = "";
        $version  = self::getAppVersion();

        if (self::isApp() && self::isAndroid() && (($version['app'] == 'GUIXUE' && $version['version'] > 1.4) || ($version['app'] == 'GUIXUETOEFL' && $version['version'] > 0) || ($version['app'] == 'GUIXUECET' && $version['version'] > 0) || ($version['app'] == 'GUIXUECETPRO' && $version['version'] > 0) || ($version['app'] == 'GUIXUE45' && $version['version'] > 0) || ($version['app'] == 'GUIXUESAT' && $version['version'] > 0))) {
            LogSvc::get("deviceid_android")->log(print_r($version, true));


            $useragent = env('HTTP_USER_AGENT');

            preg_match("/DeviceId:(.*?)[\);\s]/i", $useragent, $match);
            LogSvc::get("deviceid")->log(print_r($match, true));

            $deviceid = $match[1];
        }

        return $deviceid;

    }

    /*
    *获取ios的设备id
    */
    public static function getIosDeviceid()
    {

        $deviceid = "";
        $version  = self::getAppVersion();

        if (self::isApp() && self::isIOS() && (($version['app'] == 'GUIXUE' && $version['version'] > 1.4) || ($version['app'] == 'GUIXUETOEFL' && $version['version'] > 0) || ($version['app'] == 'GUIXUECET' && $version['version'] > 0) || ($version['app'] == 'GUIXUECETPRO' && $version['version'] > 0) || ($version['app'] == 'GUIXUE45' && $version['version'] > 0) || ($version['app'] == 'GUIXUESAT' && $version['version'] > 0))) {
            //LogSvc::get("deviceid")->log(print_r($version, true));

            $useragent = env('HTTP_USER_AGENT');

            preg_match("/DeviceId:(.*?)[\);\s]/i", $useragent, $match);
            //LogSvc::get("deviceid")->log(print_r($match, true));

            $deviceid = $match[1];
        }

        return $deviceid;

    }

    /**
     * 校验iOS设备的信息
     */

    public static function verifyIosDeviceid()
    {

        $deviceid = "";
        $version  = self::getAppVersion();
        if (self::isIOS() && self::isCetProApp()) {

            $useragent = env('HTTP_USER_AGENT');
            preg_match("/DeviceId:(.*?)[\);\s]/i", $useragent, $match);
            $deviceid = $match[1];
            preg_match("/SIGN:(.*?)[\);\s]/i", $useragent, $match);
            $sign = $match[1];

            if (md5(md5($deviceid) . 'Xwg2016Pro') == $sign) {
                return true;

            }
        }

        return false;

    }

    public static function isAndroid()
    {
        return (strpos(strtolower(env('HTTP_USER_AGENT')), 'android') !== false) || (strpos(env('HTTP_USER_AGENT'), 'HttpClient') !== false);
    }

    public static function isWeixin()
    {
        $ua = strtolower(env('HTTP_USER_AGENT'));
        return strpos($ua, 'micromessenger') !== false;
    }

    public static function isAlipay()
    {
        $agent = env('HTTP_USER_AGENT');
        return (strpos($agent, 'Alipay') !== false || strpos($agent, 'AlipayClient') !== false || strpos($agent, 'AliApp') !== false);
    }

    public static function isMobile($pad = 1)
    {
        if ($pad != 1) {
            return self::isAndroid() || self::isIphone() || self::isIpod();
        }
        return self::isAndroid() || self::isIOS() || self::isIphone() || self::isIpod() || self::isIpad();
    }

    public static function inApple()
    {
        $ip = env('HTTP_X_FORWARDED_FOR');
        if (!$ip) {
            $ip = env('REMOTE_ADDR');
        }

        if (substr($ip, 0, 3) == '17.') {
            return true;
        }
        return false;
    }

    public static function inCompany($level = 0)
    {
        $ip = env('HTTP_X_FORWARDED_FOR');
        if (!$ip) {
            $ip = env('REMOTE_ADDR');
        }

        if (substr($ip, 0, 8) == '192.168.') {
            return true;
        }
        if (in_array($ip, array('127.0.0.1', '58.132.172.36', '182.92.104.65', '182.92.103.136', '106.2.178.238', '103.254.112.150', '123.57.39.20', '106.39.200.46', '1.202.20.87', '101.36.73.148', '1.119.129.16', '1.119.136.110'))) {
            return true;
        }
        return false;
    }

    public static function numToCny($num)
    {
        $capUnit  = array('万', '亿', '万', '圆', '');  //单元
        $capDigit = array(2 => array('角', '分', ''), 4 => array('仟', '佰', '拾', ''));
        $capNum   = array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
        if ((strpos(strval($num), '.') > 16) || (!is_numeric($num)))
            return '';
        $num    = sprintf("%019.2f", $num);
        $CurChr = array('', '');
        for ($i = 0, $ret = '', $j = 0; $i < 5; $i++, $j = $i * 4 + floor($i / 4)) {
            $nodeNum = substr($num, $j, 4);
            for ($k = 0, $subret = '', $len = strlen($nodeNum); (($k < $len) && (intval(substr($nodeNum, $k)) != 0)); $k++) {
                $CurChr[$k % 2] = $capNum[$nodeNum{$k}] . (($nodeNum{$k} == 0) ? '' : $capDigit[$len][$k]);
                if (!(($CurChr[0] == $CurChr[1]) && ($CurChr[$k % 2] == $capNum[0])))
                    if (!(($CurChr[$k % 2] == $capNum[0]) && ($subret == '') && ($ret == '')))
                        $subret .= $CurChr[$k % 2];
            }
            $subChr = $subret . (($subret == '') ? '' : $capUnit[$i]);
            if (!(($subChr == $capNum[0]) && ($ret == ''))) {
                $ret .= $subChr;
            }
        }
        $ret = ($ret == "") ? $capNum[0] . $capUnit[3] : $ret;
        return $ret;
    }

    /*
     * 根据手机号获取手机归属地等信息
     */

    public static function getMobileInfo($mobile)
    {
        $page = self::simpleRequest('http://opendata.baidu.com/api.php?query=' . $mobile . '&co=&resource_id=6004&t=' . time() . '&ie=utf8&oe=gbk&cb=bd__cbs__854nlx&format=json&tn=baidu');

        $page = iconv('gbk', 'utf-8', substr(str_replace('bd__cbs__854nlx(', '', $page), 0, -2));

        $json      = json_decode($page);
        $city      = $json->data[0]->city; //城市
        $operators = $json->data[0]->type; //归属地
        $prov      = $json->data[0]->prov; //省份
        return array('city' => $city, 'operators' => $operators, 'prov' => $prov);
    }

    public static function seconds2Hms($seconds)
    {
        if ($seconds >= 3600) {
            $h = floor($seconds / 3600);
            $seconds -= $h * 3600;
        } else {
            $h = '00';
        }

        if ($seconds >= 60) {
            $m = floor($seconds / 60);
            $seconds -= $m * 60;
        } else {
            $m       = '00';
            $seconds = '00';
        }
        $h       = strlen($h) == 1 ? ('0' . $h) : $h;
        $m       = strlen($m) == 1 ? ('0' . $m) : $m;
        $seconds = strlen($seconds) == 1 ? ('0' . $seconds) : $seconds;
        return $h . ':' . $m . ':' . $seconds;
    }

    /**
     * 获取某个时间段的日期数组
     */
    public static function intervalDate($begDate, $endDate)
    {
        $date    = array();
        $begTime = strtotime($begDate);
        $endTime = strtotime($endDate);
        while ($begTime - 86400 < $endTime) {
            $date[] = date("Y-m-d", $begTime);
            $begTime += 86400;
        }
        return $date;
    }

    public static function plat()
    {
        $plat = 'web';
        if (self::isIpad()) {
            $plat = 'ipad';
        }
        if (self::isIphone() || self::isIpod()) {
            $plat = 'iphone';
        }
        if (self::isAndroid()) {
            $plat = 'android';
        }
        return $plat;
    }

    //16进制的8位唯一码 ：oPF2aa1e
    public static function unique32($a)
    {
        for
        (
            $a = md5($a, true),
            $s = '0123456789acegikmoqsuBDFHJLNPRTV',
            $d = '',
            $f = 0; $f < 8; $g = ord($a[$f]),
            $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F],
            $f++
        )
            ;
        return $d;
    }

    public static function getMicrotime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return intval(($usec * 1000 + (float)$sec * 1000));
    }

    public static function getAppVersion()
    {

        $useragent     = env('HTTP_USER_AGENT');
        $result        = array();
        $result['app'] = '';

        preg_match("/GUIXUEYOUNG:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUEYOUNG";
            return $result;
        }

        preg_match("/GUIXUESAT:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUESAT";
            return $result;
        }

        preg_match("/GUIXUE45:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUE45";
            return $result;
        }

        preg_match("/GUIXUETOEFL:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUETOEFL";
            return $result;
        }

        preg_match("/GUIXUECET:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUECET";
            return $result;
        }

        preg_match("/GUIXUECETPRO:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUECETPRO";
            return $result;
        }

        preg_match("/GUIXUE:(\d+\.\d+)/", $useragent, $match);
        if (isset($match[1])) {
            $result['version'] = $match[1];
            $result['app']     = "GUIXUE";
            return $result;
        }

        return $result;
    }

    public static function isApp()
    {
        $appversion = self::getAppVersion();
        return !empty($appversion);
    }

    public static function isGuixeApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == 'GUIXUE';
    }

    public static function isIeltsApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == 'GUIXUE';
    }

    public static function isSatApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == 'GUIXUESAT';
    }

    public static function isYoungApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == 'GUIXUEYOUNG';
    }

    public static function isIelts45App()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == 'GUIXUE45';
    }

    public static function isPengciApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == "PENGCI";
    }

    public static function isToeflApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == "GUIXUETOEFL";
    }

    public static function isCetApp()
    {
        $appversion = self::getAppVersion();
        return ($appversion['app'] == "GUIXUECET" || self::isCetProApp());
    }

    public static function isCetProApp()
    {
        $appversion = self::getAppVersion();
        return $appversion['app'] == "GUIXUECETPRO";
    }


    public static function getGuixueVersion()
    {
        $appversion = self::getAppVersion();
        return ($appversion['app'] == 'GUIXUE' ? $appversion['version'] : 0);
    }


    public static function getCetVersion()
    {
        $appversion = self::getAppVersion();
        return ($appversion['app'] == 'GUIXUECET' ? $appversion['version'] : 0);
    }


    public static function getYoungVersion()
    {
        $appversion = self::getAppVersion();
        return ($appversion['app'] == 'GUIXUEYOUNG' ? $appversion['version'] : 0);
    }


    public static function getGuixueIosAppVersion()
    {
        $appversion = self::getAppVersion();
        return (($appversion['app'] == 'GUIXUE' && self::isIOS()) ? $appversion['version'] : 0);
    }

    public static function getGuixueAndroidAppVersion()
    {
        $appversion = self::getAppVersion();

        return (($appversion['app'] == 'GUIXUE' && self::isAndroid()) ? $appversion['version'] : 0);

    }

    public static function getToeflIosAppVersion()
    {
        $appversion = self::getAppVersion();
        return (($appversion['app'] == 'GUIXUETOEFL' && self::isIOS()) ? $appversion['version'] : 0);
    }

    public static function getToeflAndroidAppVersion()
    {
        $appversion = self::getAppVersion();

        return (($appversion['app'] == 'GUIXUETOEFL' && self::isAndroid()) ? $appversion['version'] : 0);

    }

    public static function getCetIosAppVersion()
    {
        $appversion = self::getAppVersion();
        return (($appversion['app'] == 'GUIXUECET' && self::isIOS()) ? $appversion['version'] : 0);
    }

    public static function getCetAndroidAppVersion()
    {
        $appversion = self::getAppVersion();

        return (($appversion['app'] == 'GUIXUECET' && self::isAndroid()) ? $appversion['version'] : 0);

    }

    public static function getYoungIosAppVersion()
    {
        $appversion = self::getAppVersion();
        return (($appversion['app'] == 'GUIXUEYOUNG' && self::isIOS()) ? $appversion['version'] : 0);
    }

    public static function getYoungAndroidAppVersion()
    {
        $appversion = self::getAppVersion();

        return (($appversion['app'] == 'GUIXUEYOUNG' && self::isAndroid()) ? $appversion['version'] : 0);

    }

    public static function getPengciVersion()
    {
        $appversion = self::getAppVersion();
        return ($appversion['app'] == 'PENGCI' ? $appversion['version'] : 0);
    }

    public static function getGeTuiField()
    {
        if (self::isIeltsApp()) {
            return 'getuiid';
        } elseif (self::isToeflApp()) {
            return 'toeflid';
        } elseif (self::isCetApp()) {
            return 'cetid';
        } else if (self::isSatApp()) {
            return 'satid';
        } else if (self::isYoungApp()) {
            return 'youngid';
        } else {
            return 'getuiid';
        }
    }

    public static function getGeTuiFieldByType($productType = '0')
    {
        if ($productType >= '0' && $productType <= '1999') {
            return 'getuiid';
        } elseif ($productType >= '2000' && $productType <= '2999') {
            return 'toeflid';
        } elseif ($productType >= '3000' && $productType <= '3999') {
            return 'cetid';
        } elseif ($productType >= '4000' && $productType <= '4999') {
            return 'satid';
        } elseif ($productType >= '5000' && $productType <= '5999') {
            return 'youngid';
        } else {
            return 'getuiid';
        }
    }

    public static function getGeTuiFieldByAppId($appid)
    {
        switch ($appid) {
            // case PushSvc::IELTS_APPID:
            //     return 'getuiid';
            //     break;
            // case PushSvc::TOEFL_APPID:
            //     return 'toeflid';
            //     break;
            // case PushSvc::CET_APPID:
            //     return 'cetid';
            //     break;
            // case PushSvc::IELTS45_APPID:
            //     return 'getuiid';
            //     break;
            // case PushSvc::CETSINGLE_APPID:
            //     return 'cetid';
            //     break;
            // case PushSvc::SAT_APPID:
            //     return 'satid';
            //     break;
            // case PushSvc::YOUNG_APPID:
            //     return 'satid';
            //     break;
        }
        return '';
    }

    public static function formatTime($time)
    {
        $time         = strtotime($time);
        $timeinterval = time() - $time;
        $timeinterval = floor($timeinterval / 60);
        if ($timeinterval < 1) {
            return "刚刚";
        } else {
            if ($timeinterval < 60) {
                return $timeinterval . "分钟前";
            } else {
                $timeinterval = floor($timeinterval / 60);
                if ($timeinterval < 24) {
                    return $timeinterval . "小时前";
                } else {
                    $hour         = date("H");
                    $timeinterval = floor(($timeinterval - $hour) / 24) + 1;
                    if ($timeinterval < 2) {
                        return "昨天";
                    } elseif ($timeinterval < 3) {
                        return "前天";
                    } else {
                        return date("Y/m/d", $time);
                    }

                }
            }
        }
    }


    /**
     * 校验日期格式是否正确
     *
     * @param string $date 日期
     * @param string $formats 需要检验的格式数组
     * @return boolean
     */
    public static function checkDateIsValid($date, $formats = array("Y-m", "Y-m-d", "Y/m/d", "Y-m-d H:i:s", "Y/m/d H:i:s")) {
        $unixTime = strtotime($date);
        if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
            return false;
        }
        //校验日期的有效性，只要满足其中一个格式就OK
        foreach ($formats as $format) {
            if (date($format, $unixTime) == $date) {
                return true;
            }
        }

        return false;
    }


    public static function call($url, $time_out = 30){

        if ('' == $url) {
            return false;
        }

        $url_ary = parse_url($url);
        if (!isset($url_ary['host'])) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)');

        $http_header   = array();
        $http_header[] = 'Connection: close';
        $http_header[] = 'Pragma: no-cache';
        $http_header[] = 'Cache-Control: no-cache';
        $http_header[] = 'Accept: */*';
        $http_header[] = 'Host: ' . $url_ary['host'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time_out);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function simpleRequest($url, $post_data = array(), $option = array()){

        //使用http_build_query拼接post
        if ('' == $url) {
            return false;
        }
        $url_ary = parse_url($url);
        if (!isset($url_ary['host'])) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_HEADER, ($option && $option['CURLOPT_HEADER'] === true));
        if ($option && $option['referer'] != '') {
            curl_setopt($ch, CURLOPT_REFERER, $option['referer']);
        }
        if (!empty($post_data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            if (is_array($post_data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            }
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');

        $http_header   = array();
        $http_header[] = 'Connection: close';
        $http_header[] = 'Pragma: no-cache';
        $http_header[] = 'Cache-Control: no-cache';
        $http_header[] = 'Accept: */*';
        if (isset($option['header'])) {
            foreach ($option['header'] as $header) {
                $http_header[] = $header;
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!isset($option['timeout'])) {
            $option['timeout'] = 15;
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, $option['timeout']);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}