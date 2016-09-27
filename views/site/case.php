<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $cases app\models\Item */
/* @var $pagination app\models\Item */

$this->title = 'Чехлы';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
<div class="catalog">
    <ul class="ulcatalog">
        <?php foreach ($cases as $case): ?>
            <li class="licatalog">
                <div class="thumbnail">
                    <img src="../../images/items/<?= Html::encode("{$case->picture}.png") ?>" alt="<?= Html::encode("{$case->name}") ?>" width="200" height="auto">
                    <div class="caption">
                        <h5><?= Html::encode("{$case->name}") ?></h5>
                        <p><strong><?= Html::encode("{$case->price}") ?> BYN</strong></p>
                        <p>(<?= Html::encode("{$case->price}")*10000 ?> BYR)</p>
                        <?php if($case->quantity == 0) {?>
                        <div class="alert alert-warning" role="alert">Нет в наличии</div>
                        <?php } else if (isset($_COOKIE["{$case->id}"])) { ?>
                            <div id="show<?= Html::encode("{$case->id}") ?>" style="display: block" class="alert alert-success" role="alert">Товар в Корзине</div>
                            <?php } else { ?>
                        <p id="hide<?= Html::encode("{$case->id}") ?>" style="display: block"><a class="btn btn-primary" onclick="submitValue('<?php echo $case->id; ?>')">Добавить в корзину</a></p>
                            <div id="show<?= Html::encode("{$case->id}") ?>" style="display: none" class="alert alert-success" role="alert">Товар добавлен</div>
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
        var date = new Date(new Date().getTime() + 2592 * 1000000);

        document.cookie =
            n + '=' + 1 +
        '; expires=' + date.toUTCString();

            $("#hide"+n).hide();
        $("#show"+n).show();
    }
</script>


