<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $phoneholders app\models\Item */
/* @var $pagination app\models\Item */

$this->title = 'Держатели';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
<div class="catalog">
    <ul class="ulcatalog">
        <?php foreach ($phoneholders as $phoneholder): ?>
            <li class="licatalog">
                <div class="thumbnail">
                    <img src="../../images/items/<?= Html::encode("{$phoneholder->picture}.png") ?>" alt="<?= Html::encode("{$phoneholder->name}") ?>" width="200px" height="auto">
                    <div class="caption">
                        <h5><?= Html::encode("{$phoneholder->name}") ?></h5>
                        <p><strong><?= Html::encode("{$phoneholder->price}") ?> BYN</strong></p>
                        <p>(<?= Html::encode("{$phoneholder->price}")*10000 ?> BYR)</p>
                        <?php if($phoneholder->quantity == 0) {?>
                            <div class="alert alert-warning" role="alert">Нет в наличии</div>
                        <?php } else if (isset($_COOKIE["{$phoneholder->id}"])) { ?>
                            <div id="show<?= Html::encode("{$phoneholder->id}") ?>" style="display: block" class="alert alert-success" role="alert">Товар в Корзине</div>
                        <?php } else { ?>
                            <p id="hide<?= Html::encode("{$phoneholder->id}") ?>" style="display: block"><a class="btn btn-primary" onclick="submitValue('<?php echo $phoneholder->id; ?>')">Добавить в корзину</a></p>
                            <div id="show<?= Html::encode("{$phoneholder->id}") ?>" style="display: none" class="alert alert-success" role="alert">Товар добавлен</div>
                        <?php } ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
    </div>
    <div class="col-md-1"></div>
</div>
<div class="row">
    <div class="col-md-12">
<div style="text-align: center;">
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
        </div>
    </div>

<script language="JavaScript">
    function submitValue (n) {
        document.cookie = n + "=" + 1;
        $("#hide"+n).hide();
        $("#show"+n).show();
    }
</script>