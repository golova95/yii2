<?php

namespace app\models;

use yii\db\ActiveRecord;

class Order_items extends ActiveRecord
{
  static function add($order, $items)
  {
      foreach ($items as $item)
      {
          $order_item = new self;
          $order_item  -> order_id = $order->id;
          $order_item  -> item_id = $item->id;
          $order_item  -> quantity = $_COOKIE[$item->id];
          $order_item  -> save();
      }
  }
}