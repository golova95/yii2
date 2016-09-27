<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Category;
use app\models\Cookie;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="../../images/tech/favicon.png">
    <?php $this->head() ?>
</head>
<header>
    <img src="../../images/tech/gate.png" width="100%">
</header>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('../../images/tech/favicon.png'),
        'brandUrl' => Yii::$app->homeUrl = '/web/site/home',
        'options' => [],
    ]);


    $query = Category::find();
    $categories = $query
        ->all();

$categoryItems = [];
    foreach ($categories as $category):
        $categoryItems[] =
        ['label' => '<img class="menulogo" src="../../images/tech/menulogos/'.Html::encode("{$category->logo}").'.png" width="12" height="20">'.' '.Html::encode("{$category->name}").'', 'url' => ['/site/'.Html::encode("{$category->url}").'']];
    endforeach;

        $menuItems = [
            ['label' => '<span class="glyphicon glyphicon-home" aria-hidden="true"></span> Главная', 'url' => ['/site/home']],
            ['label' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Категории', 'items' => $categoryItems],
            ['label' => '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> О нас', 'url' => ['/site/contact']]
            ];

//    if (Yii::$app->user->isGuest) {
//        $menuItems[] = ['label' => 'Sign up', 'url' => ['/site/signup']];
//        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
//    } else {
//        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> (' . Yii::$app->user->identity->username . ')', 'items' => [
//            ['label' => 'Профиль', 'url' => ['/site/profile']],
//            ['label' => 'Выйти', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]]];
//            }
if (Cookie::cartitem() != false) {
    $menuItems[] = ['label' => '<img class="menulogo" src="../../images/tech/fullbag.png" width="20" height="23">', 'url' => ['/site/cart']];
} else {
    $menuItems[] = ['label' => '<img class="menulogo" src="../../images/tech/emptybag.png" width="20" height="23">', 'url' => ['/site/cart']];
}

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>
</div>

    <div class="container" style="width: 100%; min-height: 400px ">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>


<footer class="footer" style="width: 100%">
    <div class="container">
        <p class="pull-left">&copy; Pokeshop <?= date('Y') ?></p>
        <p class="pull-right">
        <a href="https://vk.com/pokeshopminsk" target="_blank"><img src="../../images/tech/vk.png" width="32" height="32"></a>
        <a href="https://www.instagram.com/agolovenchik/" target="_blank"><img src="../../images/tech/Instagram.png" width="32" height="32"></a>
            <a href="#">Artom Golovenchik</a>
            </p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
