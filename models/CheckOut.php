<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CheckOut extends Model
{
    public $name;
    public $email;
    public $phone;
    public $verifyCode;
    public $city;
    public $address;
    public $state;
    public $zipcode;
    public $total;
    public $type;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        if ( $_GET["method"] == "delivery") {
            return [
                [['name', 'email', 'phone', 'city', 'address', 'total', 'type'], 'required', 'message'=>'Введите {attribute}.'],
                // email has to be a valid email address
                ['email', 'email'],
                // verifyCode needs to be entered correctly
                ['verifyCode', 'captcha'],
            ];
        } elseif ( $_GET["method"] == "post") {
            return [
                // name, email, subject and body are required
                [['name', 'email', 'phone', 'state', 'city', 'address', 'zipcode', 'total', 'type'], 'required', 'message'=>'Введите {attribute}.'],
                // email has to be a valid email address
            ['email', 'email'],
                // verifyCode needs to be entered correctly
                ['verifyCode', 'captcha'],
            ];
        } else {
            return [
                // name, email, subject and body are required
                [['name', 'email', 'phone', 'total', 'type'], 'required', 'message'=>'Введите {attribute}.'],
                // email has to be a valid email address
                ['email', 'email'],
                // verifyCode needs to be entered correctly
                ['verifyCode', 'captcha'],
            ];
        }
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'city' => 'Населённый пункт',
            'address' => 'Адрес',
            'state' => 'Область',
            'zipcode' => 'Индекс',
            'verifyCode' => 'Verification Code',
        ];
    }
    static function orders($items){
        $a = [];
        foreach ($items as $item) {
            array_push($a, $item->name." = ".$_COOKIE[$item->id]);
        }
        $order = implode('<br>', $a);

        return $order;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email, $order)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject("Order")
                ->setHtmlBody(
                    "
                     Тип доставки: $this->type <br>
                     Имя: $this->name <br>
                     Номер телефона: $this->phone <br>
                     E-mail: $this->email <br>
                     Область: $this->state <br>
                     Населённый пункт: $this->city <br>
                     Адрес: $this->address <br>
                     Индекс: $this->zipcode <br>
                     Цена: $this->total <br>
                     <br>
                     Заказ: <br>
                     $order
                     "
                )
                ->send();

            return true;
        }
        return false;
    }

    public function amount($method, $items)
    {
        $total = 0;
        $count = 0;
        foreach ($items as $item) {
            $total = $total + $item->price * $_COOKIE[$item->id];
            $count = $count + $_COOKIE[$item->id];
        }

        if ($method == 'delivery')
        {
            $total = $total + 5;
        }
        if ($method == 'post')
        {
            $shipping = round(($total+5)*1.03*1.03 - $total, 2);
            $total = $total + $shipping;
            return array($count, $total, $shipping);
        }else{
            return array($count, $total);
        }
    }




    static function states() {
        $a = ['0' => 'Брестская',
            '1' => 'Витебская',
            '2' => 'Гомельская',
            '3' => 'Гродненская',
            '4' => 'Минская',
            '5' => 'Могилёвская'];

        return $a;
    }


}

