<?php

namespace app\home\controller;

use gophp\cache;
use gophp\controller;
use gophp\db;
use gophp\view;

class index extends controller {

    public function index(){

        $a = M('pdo_yy')->find();

        dump($a);

        $this->display();

    }


}