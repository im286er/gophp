<?php

namespace gophp;

use gophp\helper\url;

class request
{

    /**
     * 是否是GET请求
     * @return bool
     */
    public static function isGet()
    {

        return self::getMethod() === 'GET';

    }

    /**
     * 是否是POST请求
     * @return bool
     */
    public static function isPost()
    {

        return self::getMethod() === 'POST';

    }

    /**
     * 是否是OPTINS请求
     * @return bool
     */
    public static function isOptions()
    {

        return self::getMethod() === 'OPTIONS';

    }

    /**
     * 是否是HEAD请求
     * @return bool
     */
    public static function isHead()
    {

        return self::getMethod() === 'HEAD';

    }

    /**
     * 是否是DELETE请求
     * @return bool
     */
    public static function isDelete()
    {

        return self::getMethod() === 'DELETE';

    }

    /**
     * 是否是PUT请求
     * @return bool
     */
    public static function isPut()
    {

        return self::getMethod() === 'PUT';

    }

    /**
     * 是否是PATCH请求
     * @return bool
     */
    public static function isPatch()
    {

        return self::getMethod() === 'PATCH';

    }

    /**
     * 是否是TRACE请求
     * @return bool
     */
    public static function isTrace()
    {

        return self::getMethod() === 'TRACE';

    }

    /**
     * 是否是AJAX请求
     * @return bool
     */
    public static function isAjax()
    {

        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    }

    /**
     * 是否是PAJX请求
     * @return bool
     */
    public static function isPjax()
    {

        return self::isAjax() && !empty($_SERVER['HTTP_X_PJAX']);

    }

    /**
     * 是否是FLASH请求
     * @return bool
     */
    public static function isFlash()
    {

        return isset($_SERVER['HTTP_USER_AGENT']) &&
            (stripos($_SERVER['HTTP_USER_AGENT'], 'Shockwave') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'Flash') !== false);

    }

    /**
     * 是否是命令行模式请求
     * @return bool
     */
    public static function isCLI()
    {

        return PHP_SAPI === 'cli';

    }

    /**
     * 是否是WINDOWS系统服务器发起请求
     * @return string
     */
    public static function isWin()
    {

        return strstr(PHP_OS, 'WIN');

    }

    /**
     * 是否是linux系统服务器发起请求
     * @return string
     */
    public static function isLinux()
    {

        return strstr(PHP_OS, 'Linux');

    }

    /**
     * 是否是微信发起请求
     * @return bool
     */
    public static function isWeChat()
    {

        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false;

    }

    /**
     * 获取请求方法
     * @return string
     */
    public static function getMethod()
    {

        if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {

            return strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);

        }

        if (isset($_SERVER['REQUEST_METHOD'])) {

            return strtoupper($_SERVER['REQUEST_METHOD']);

        }

        return 'GET';

    }

    /**
     * 获取当前请求参数
     * @param $name
     * @param null $default
     * @return null
     */
    public static function getParam($name, $default = null)
    {

        if(!$name){

            return null;

        }

        $method = strtoupper(self::getMethod());

        switch ($method) {

            case 'GET':

                $input = $_GET;

                break;

            case 'POST':

                $input = $_POST;

                break;

            default:

                return null;

                break;
        }

        $value = $input[$name];

        if(!isset($default)){

            return $value;

        }

        // 强制类型转化
        gettype($default) == 'unknown type' or settype($value, gettype($default));

        return $value ? $value : $default;

    }

    /**
     * 获取USER_AGENT
     * @return string
     */
    public static function getUA()
    {

        return isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';

    }

    public static function getUri()
    {

        return isset($_SERVER['REQUEST_URI']) ? strtolower($_SERVER['REQUEST_URI']) : '';

    }

    /**
     * 获取当前请求的相对或绝对URL
     * @param bool $isAbsolute
     * @return null|string
     */
    public static function getUrl($isAbsolute = false)
    {

        $uri = self::getUri();

        if($isAbsolute){

            $protocol = self::getScheme() . '://';

            return $protocol . $_SERVER['HTTP_HOST'] . self::getUri();

        }else{

            return $uri;

        }

    }

    /**
     *  获取当前请求的协议类型
     */
    public static function getScheme()
    {

        return url::getScheme($_SERVER['SERVER_NAME']);

    }

    /**
     *  获取当前请求的HOST
     */
    public static function getHost()
    {

        return url::getHost(self::getUrl());

    }

    /**
     *  获取当前请求的域名
     */
    public static function getDomain()
    {

        return url::getDomain(self::getUrl());

    }

    /**
     * 获取当前请求的PATH
     * @return mixed
     */
    public static function getPath()
    {

        return url::getPath(self::getUrl());

    }

    /**
     * 获取当前请求的query字符串
     * @return mixed
     */
    public static function getQuery()
    {

        return url::getQuery(self::getUrl());

    }

    /**
     * 获取当前请求的URL扩展名
     * @return string
     */
    public static function getExtension()
    {

        return url::getExtension(self::getUrl(false));

    }

    /**
     * 获取当前请求的时间
     * @param bool $float
     * @return mixed
     */
    public static function getTime($float = false)
    {

        return $float ? $_SERVER['REQUEST_TIME_FLOAT'] : $_SERVER['REQUEST_TIME'];

    }

    /**
     *  获取服务端IP
     * @return string
     */
    public static function getServerIp()
    {

        if(isset($_SERVER)){

            if($_SERVER['SERVER_ADDR']){

                $serverIp = $_SERVER['SERVER_ADDR'];

            }else{

                $serverIp = $_SERVER['LOCAL_ADDR'];

            }
        }else{

            $serverIp = getenv('SERVER_ADDR');

        }

        return filter_var($serverIp, FILTER_VALIDATE_IP) !== false ? $serverIp : '';

    }

    /**
     * 获取客户端IP
     * @return string
     */
    public static function getClientIp()
    {

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {

            $clientIp = $_SERVER['HTTP_CLIENT_IP'];

        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];

        } elseif (isset($_SERVER['REMOTE_ADDR'])) {

            $clientIp = $_SERVER['REMOTE_ADDR'];

        } else {

            $clientIp = '';

        }

        return filter_var($clientIp, FILTER_VALIDATE_IP) !== false ? $clientIp : '';

    }

    /**
     * 获取前一个页面
     * @return string
     */
    public static function getReffer()
    {

        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    }

    /**
     * 获取GET请求的值
     * @param $name
     * @param null $default
     * @return null
     */
    public static function get($name, $default = null)
    {

        $value = $_GET[$name];

        if(!isset($default)){

            return $value;

        }

        // 强制类型转化
        gettype($default) == 'unknown type' or settype($value, gettype($default));

        return $value ? $value : $default;

    }

    /**
     * 获取POST请求的值
     * @param $name
     * @param null $default
     * @return null
     */
    public static function post($name, $default = null)
    {

        $value = $_POST[$name];

        if(!isset($default)){

            return $value;

        }

        // 强制类型转化
        gettype($default) == 'unknown type' or settype($value, gettype($default));

        return $value ? $value : $default;

    }

    /**
     *获取POST请求的值
     * @return array|void
     */
    public static function put()
    {

        $_PUT = [];

        if(self::getMethod() === "PUT"){

            parse_str(file_get_contents('php://input', false , null, -1 , $_SERVER['CONTENT_LENGTH'] ), $_PUT);

        }

        return $_PUT;

    }

    /**
     * 模拟HTTP请求
     * @param $url
     * @param $thmod
     * @param null $data
     * @param int $time_out
     * @return mixed|string
     * @throws exception
     */
    public static function curl($url, $method, $data = null, $headers = null, $time_out = 20)
    {

        if(!extension_loaded('curl'))
        {

            throw new exception('Curl Error', 'Curl extension not install');

        }

        $curl   = curl_init(); //初始化CURL句柄

        $method = strtoupper($method);

        if($method === 'GET' && is_array($data)){

            $query = http_build_query($data);

            $query and $url = strpos($url, '?') !== false ? $url . '&' . $query :  $url . '?' . $query;

        }

        if(is_array($headers)){

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        }

        curl_setopt($curl, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //将输出结果返回
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);

        $output     = curl_exec($curl);

        $curl_no    = curl_errno($curl);
        $curl_error = curl_error($curl);
        $curl_info  = curl_getinfo($curl);

        curl_close($curl);

        if ($curl_no > 0) {

            $error_array = [

                'error_no'  => $curl_no,
                'error_msg' => $curl_error

            ];

            return json_encode($error_array);

        }

        $http_code = $curl_info['http_code'];

        if (200 != $http_code) {

            $error_array = [

                'error_no'  => $http_code,
                'error_msg' => 'Curl Error: Http status code is '.$http_code

            ];

            return json_encode($error_array);

        }

        return $output;

    }

}