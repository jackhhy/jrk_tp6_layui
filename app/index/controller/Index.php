<?php
namespace app\index\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        //dd(ucfirst("login/utt"));
      // dd(password("123456"));
        //dd(password_very('$2y$10$XxyKGjfAtyo5I9.9HBY21O1frCziHTOzuWhhdiDypvUldM24xXVzW',"123456"));
        return redirect(url("admin/Index/index")->__toString());

       // dd(sysconfig("upload","COS_accessKey"));
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
