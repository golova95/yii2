<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $figures app\models\Item */
/* @var $pagination app\models\Item */

$this->title = 'Фигурки';
$this->params['breadcrumbs'][] = $this->title;

$height = (int)ceil(sizeof($figures)/3)*583 ;

?>


<div class="catalog" style="height: <?php echo $height;?>px;">
    <ul class="ulcatalog">
        <?php foreach ($figures as $figure): ?>
            <li class="licatalog">
                <div class="thumbnail">
                    <img src="../../images/items/<?= Html::encode("{$figure->picture}.png") ?>" alt="<?= Html::encode("{$figure->name}") ?>">
                    <div class="caption">
                        <h5><?= Html::encode("{$figure->name}") ?></h5>
                        <p><strong><?= Html::encode("{$figure->price}") ?> BYN</strong></p>
                        <p>(<?= Html::encode("{$figure->price}")*10000 ?> BYR)</p>
                        <?php if($figure->quantity == 0) {?>
                            <div class="alert alert-warning" role="alert">Нет в наличии</div>
                        <?php } else if (isset($_COOKIE["{$figure->id}"])) { ?>
                            <div id="show<?= Html::encode("{$figure->id}") ?>" style="display: block" class="alert alert-success" role="alert">Товар в Корзине</div>
                        <?php } else { ?>
                            <p id="hide<?= Html::encode("{$figure->id}") ?>" style="display: block"><a class="btn btn-primary" onclick="submitValue('<?php echo $figure->id; ?>')">Добавить в корзину</a></p>
                            <div id="show<?= Html::encode("{$figure->id}") ?>" style="display: none" class="alert alert-success" role="alert">Товар добавлен</div>
                        <?php } ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div style="text-align: center; width: 600px; margin: auto">
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>

<script language="JavaScript">
    function submitValue (n) {
        document.cookie = n + "=" + 1;
        $("#hide"+n).hide();
        $("#show"+n).show();
    }
</script>