<?php

namespace app\home\controller;

use gophp\cache;
use gophp\controller;
use gophp\db;

class index extends controller {

    public function index(){

        cache::instance()->set('demo', 11, 5);

        $this->display();

    }


}