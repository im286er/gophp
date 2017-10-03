<?php

namespace app\admin\filter;

use gophp\config;
use gophp\response;
use app\user;

class auth
{

    public function run()
    {

        $user_info = user::get_user_info();

        if(!$user_info){

            response::redirect('login');

        }

        if($user_info['type'] != 2){

            $viewFile = config::get('view', 'error_template');

            $message['type']    = 'error';
            $message['url']     = 'project/select';
            $message['content'] = '抱歉，您无权访问';
            $message['time']    = 3;

            response::view($viewFile, $message);

        }


        return true;
    }

}
