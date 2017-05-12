<?php

namespace gophp;

use gophp\helper\file;

class app
{

    public static $namespace;
    public static $config = [];
    public static $error  = [];

    // 运行应用
    public static function run()
    {

        self::$config    = config::get('app');

        // 获取APP命名空间
        self::$namespace = '\\'.self::$config['app_namespace'];

        // 设定错误和异常处理
        set_error_handler([static::class, "errorHandler"]);
        set_exception_handler([static::class, "exceptionHandler"]);
        register_shutdown_function([static::class, "shutdownHandler"]);

        // 设置页面编码
        date_default_timezone_set(self::$config['default_timezone']);

        // 设置页面编码，这里需要优化下，cli模式下无需设置
        header("Content-type: text/html; charset=".self::$config['default_charset']);

        header('X-Powered-By:GoPHP V' . GOPHP_VERSION);

        // 路由分发
        route::dispatch();

        // 加载公共函数库文件
        file::load(COMMON_PATH . '/function/function.php');

        // 加载模块函数库文件
        file::load(MODULE_PATH . '/function/function.php');

    }

    // 致命错误捕获
    public static function shutdownHandler()
    {

        if ($e = error_get_last()) {

            switch($e['type']){

                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:

                    self::$error['code'] = $e['type'];
                    self::$error['file'] = $e['file'];
                    self::$error['line'] = $e['line'];
                    self::$error['message'] = $e['message'];

                    self::show('exception');

                    break;

            }
        }

    }

    // 自定义错误处理
    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {

        switch ($errno) {

            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:

                self::$error['code']    = $errno;
                self::$error['file']    = $errfile;
                self::$error['line']    = $errline;
                self::$error['message'] = $errstr;

                self::show('exception');

                break;

        }
    }

    // 自定义异常处理
    public function exceptionHandler($e)
    {

        self::$error['title']   =   $e->getTitle();
        self::$error['code']    =   $e->getCode();
        self::$error['file']    =   $e->getFile();
        self::$error['line']    =   $e->getLine ();
        self::$error['message'] =   $e->getMessage();
        self::$error['sql']     =   $e->getSQL();
        self::$error['trace']   =   $e->getTrace();

        self::show('exception');

    }

    // 错误展示
    public function show($type)
    {

        $driver = config::get('view', 'driver');

        $suffix = config::get('view', $driver)['template_suffix'];

        switch ($type) {

            case 'error':

                $viewFile = config::get('view', 'error_template') . '.' . $suffix;

                break;

            case 'exception':

                $viewFile = config::get('view', 'exception_template') . '.' . $suffix;

                break;
        }

        self::$error['title'] or self::$error['title'] = config::get('app', 'error_message');

        // 写入日志
        $message = 'message:' . self::$error['message'] . ' file:' . self::$error['file'] . ' url:' . request::getUrl(true);

        log::write($message, log::ERROR);

        view::assign('error', self::$error);

        view::display($viewFile);

    }

}