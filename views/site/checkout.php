<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $items app\models\Item */
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\CheckOut */
/* @var $states array app\models\CheckOut */
/* @var $order array app\models\CheckOut */
/* @var $values array app\models\CheckOut */

$this->title =  'Оформить заказ';
$this->params['breadcrumbs'][] = $this->title;

$count = $values[0];
$total = $values[1];
?>


<?php if (Yii::$app->session->hasFlash('orderComplite')){ ?>

<div class="alert alert-success">
    Ваш заказ приянят, в течении часа мы с вами свяжемся.
</div>

<?php } else {?>


<div class="row">
    <div class="col-md-12">
<table class="table table-striped" >
    <?php
    foreach ($items as $item):
        ?>
        <tr class="cart">
            <td class="picturecart"><img src="../../images/items/<?= Html::encode("{$item->picture}.png") ?>" alt="<?= Html::encode("{$item->name}") ?>" width="auto" height="95"></td>
            <td class="namecart"><strong><?= Html::encode("{$item->name}") ?></strong></td>
            <td class="namecart hideif"><?= Html::encode("{$item->price}") ?> (BYN)</td>
                <td class="quantitycart">Количество: <strong><?php echo $_COOKIE[$item->id] ?></strong></td>
                <td class="pricecart"><strong><?= Html::encode("{$item->price}") * $_COOKIE[$item->id]?> (BYN)</strong></td>
        </tr>
        <?php
    endforeach;
    if ($_GET["method"] == "delivery") {
        ?>

        <tr class="cart info">
            <td><strong>Доставка:</strong></td>
            <td></td>
            <td class="hideif"></td>
            <td></td>
            <td class="pricecart"><strong> 5 (BYN)</strong></td>
        </tr>

        <?php } elseif ($_GET["method"] == "post"){

        $shipping = $values[2]?>

        <tr class="cart info">
            <td><strong>Доставка:</strong></td>
            <td></td>
            <td class="hideif"></td>
            <td></td>
            <td class="pricecart"><strong><?php echo $shipping; ?> (BYN)</strong></td>
        </tr>

    <?php } ?>

    <tr class="cart info">
        <td><strong>Итого:</strong></td>
        <td></td>
        <td class="hideif"></td>
        <td class="quantitycart">Количество: <strong><?php echo $count ?></strong></td>
        <td class="pricecart"><strong><?php echo $total ?> (BYN)</strong></td>
    </tr>
</table>
</div>
    </div>


<hr>

<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin(['id' => 'checkout-form']); ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'phone') ?>

        <?= $form->field($model, 'total')->hiddenInput(['value' => $total])->label(false) ?>

        <?= $form->field($model, 'type')->hiddenInput(['value' => $_GET["method"]])->label(false) ?>

 <?php if ($_GET["method"] == "delivery") { ?>

        <?= $form->field($model, 'city')->textInput(['value' => 'Минск', 'readonly' => true]) ?>

        <?= $form->field($model, 'address') ?>


<?php } else if ($_GET["method"] == "post") { ?>


       <?= $form->field($model, 'state')->dropDownList($states) ?>

       <?= $form->field($model, 'city') ?>

       <?= $form->field($model, 'address') ?>

       <?= $form->field($model, 'zipcode') ?>


<?php } ?>

<hr>

     <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
         'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
     ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
} ?>


