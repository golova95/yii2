<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $powerbanks app\models\Item */
/* @var $pagination app\models\Item */

$this->title = 'Портативные Зарядки';
$this->params['breadcrumbs'][] = $this->title;

$height = (int)ceil(sizeof($powerbanks)/3)*583 ;

?>


<div class="catalog" style="height: <?php echo $height;?>px;">
    <ul class="ulcatalog">
        <?php foreach ($powerbanks as $powerbank): ?>
            <li class="licatalog">
                <div class="thumbnail">
                    <img src="../../images/items/<?= Html::encode("{$powerbank->picture}.png") ?>" alt="<?= Html::encode("{$powerbank->name}") ?>">
                    <div class="caption">
                        <h5><?= Html::encode("{$powerbank->name}") ?></h5>
                        <p><strong><?= Html::encode("{$powerbank->price}") ?> BYN</strong></p>
                        <p>(<?= Html::encode("{$powerbank->price}")*10000 ?> BYR)</p>
                        <?php if($powerbank->quantity == 0) {?>
                            <div class="alert alert-warning" role="alert">Нет в наличии</div>
                        <?php } else if (isset($_COOKIE["{$powerbank->id}"])) { ?>
                            <div id="show<?= Html::encode("{$powerbank->id}") ?>" style="display: block" class="alert alert-success" role="alert">Товар в Корзине</div>
                        <?php } else { ?>
                            <p id="hide<?= Html::encode("{$powerbank->id}") ?>" style="display: block"><a class="btn btn-primary" onclick="submitValue('<?php echo $powerbank->id; ?>')">Добавить в корзину</a></p>
                            <div id="show<?= Html::encode("{$powerbank->id}") ?>" style="display: none" class="alert alert-success" role="alert">Товар добавлен</div>
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