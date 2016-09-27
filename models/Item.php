<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii;

class Item extends ActiveRecord
{
  static function checkoutdb ($a)
  {
      $query = self::find()->where(['id' => $a])
          ->andWhere(['<>', 'quantity', 0]);
      $items = $query -> all();
      foreach ($items as $item){
      $item -> quantity = $item->quantity - $_COOKIE[$item->id];
          $item -> update();
      }
  }
}
