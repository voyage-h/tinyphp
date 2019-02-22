<?php

namespace Controller;

use Core\Controller;
use Core\Model;
use Model\User;
use Core\Config;

class UserController extends Controller 
{
    public function getOne()
    {
        dd(User::update(['name' => '超级王牌', 'age' => 11])->where(['>', 'id', 10])->all());

        return User::find()->one();
    }

    public function getAll()
    {
        return User::find()->all();
    }

    public function getInfo()
    {
        $res1 = User::find()
            ->select('id')
            ->where(['<','age',16])
            ->and(['in','height',[165,170]])
            ->all();
        
        print_r($res1);
        
        $res2 = User::find()
            ->select('id')
            ->where(['=','gender',1])
            ->or(['like','name','%Wang'])
            ->all();
        
        print_r($res2);

        $res3 = User::find()
            ->select('id')
            ->where(['between','weight',[40,50]])
            ->and(['>','id',4])
            ->all();
        print_r($res3);
    }
}
