<?php

use yii\helpers\Html;
/* @var $items app\models\Item */

$this->title =  'Корзина';
$this->params['breadcrumbs'][] = $this->title;

$total = 0;
$count = 0;
?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped" >
    <?php

    if ($items != NULL){

    foreach ($items as $item):
        ?>
        <tr class="cart">
            <td class="picturecart"><img src="../../images/items/<?= Html::encode("{$item->picture}.png") ?>"
                                         alt="<?= Html::encode("{$item->name}") ?>" width="auto" height="95"></td>
            <td class="namecart"><strong><?= Html::encode("{$item->name}") ?></strong></td>
            <td class="pricecart hideif"><?= Html::encode("{$item->price}") ?> (BYN)</td>
            <?php if ($item->quantity == 0) { ?>
                <td colspan="2">
                    <div class="alert alert-warning" role="alert">Нет в наличии</div>
                </td>
            <?php } else {
                $count = $count + $_COOKIE[$item->id];
                $total = $total + $item->price * $_COOKIE[$item->id]; ?>
                <td class="quantitycart"><input class="quantityinput form-control" type="number" min="0"
                                                max="<?php Html::encode("{$item->quantity}") ?>"
                                                value="<?php echo $_COOKIE[$item->id] ?>" maxlength="2" id="quantity"
                                                onchange="change('<?php echo $item->id; ?>',this.value, '<?php echo $item->quantity; ?>')"><span style="font-size: 12px">из <?php echo $item->quantity; ?></span></td>
                <td class="pricecart"><?= Html::encode("{$item->price}") * $_COOKIE[$item->id] ?> (BYN)</td>
            <?php } ?>
            <td class="deletecart"><a class="btn btn-default" onclick="submitValue('<?php echo $item->id; ?>')"><img
                        src="../../images/tech/delete.png" alt="Удалить"></a></td>
        </tr>
        <?php
    endforeach;
    ?>

    <tr class="cart info">
        <td><strong>Итого:</strong></td>
        <td></td>
        <td class="hideif"></td>
        <td class="quantitycart">Количество: <strong><?php echo $count ?></strong></td>
        <td class="pricecart"><strong><?php echo $total ?> (BYN)</strong></td>
        <td></td>
    </tr>
</table>
    </div>
    </div>

<div class="row">
    <div class="col-md-12">


    <?php if ($total > 0) { ?>

    <hr>
    <H4 style="text-align: center">Оформить заказ</h4>
    <hr>
    <div class="checkoutbuttoms">
        <a href="checkout?method=pickup">
            <button class="btn btn-default">Самовывоз</button>
        </a>
        <a href="checkout?method=delivery">
            <button class="btn btn-default">Доставка по Минску</button>
        </a>
        <a href="checkout?method=post">
            <button class="btn btn-default">Доставка наложенным платежом</button>
        </a>
    </div>

    <?php
}

} else {
?>

<div style="text-align: center; margin: auto; padding: 150px 0; width: 350px">
    <p><strong>Ваша карзина пуста</strong><br>Если вы добавили товар в корзину и она попрежнему пуста - возможно, у вас отключенны coockie в настройках браузера   </p>
</div>

<?php
    }
?>
    </div>
</div>




<script language="JavaScript">
    function submitValue (n) {
        var date = new Date(new Date().getTime() - 2592 * 1000000);

        document.cookie =
            n + '=' + 1 +
            '; expires=' + date.toUTCString();
        location.reload(true)
    }


    function change(name, value, max) {
        var date = new Date(new Date().getTime() + 2592 * 1000000);
        var past = new Date(new Date().getTime() - 2592 * 1000000);

        if (value == 0) {
            document.cookie =
                name + '=' + 1 +
                '; expires=' + past.toUTCString();
            location.reload(true)
        }
        else if (value > max) {
            document.cookie =
                name + '=' + max +
                '; expires=' + date.toUTCString();
            location.reload(true)
        }
        else {

            document.cookie =
                name + '=' + value +
                '; expires=' + date.toUTCString();
            location.reload(true)
        }
    }
</script>