<?php

namespace app\models;

use Yii;

class Cookie {

    static function cartitem()
    {
        $a = [];
        foreach (array_keys($_COOKIE) as $key){
            if ($key === (int)$key){
                array_push($a, $key );
            }
        }
        return $a;
    }

    static function checkoutitem($items)
    {
        $a=[];
        foreach ($items as $checkoutitem)
        {
           array_push($a, $checkoutitem->id);
        }
        return $a;
    }

    static function checkoutcookie($a)
    {

        foreach ($a as $item) {
        setcookie($item->id,'',time() - 1);
        }
    }

}