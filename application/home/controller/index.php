<?php
namespace app\home\controller;

use gophp\controller;
use app\home\model\user;
use gophp\helper\str;
use gophp\request;
use gophp\route;

class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        //echo request::getDomain();

        dump(str::quote('gou', str::back));

        $a = request::getClientIp();

        dump($a);

        $this->display();

    }

    public function demo()
    {
        echo 'demo';
    }

    public function __call($name, $arguments)
    {
        echo $name;
    }

}