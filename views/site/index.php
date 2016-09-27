<?php

use yii\bootstrap\Carousel;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $categories app\models\Category */

$this->title = 'Главная';
$this->params['breadcrumbs'][] = $this->title;

?>

<div style="margin: auto;  width: 100%">
<?

$carouselItems = [];
foreach ($categories as $category):
    $carouselItems[] = [
        'content' => '<img style="width:100%;height:100%" src="../../images/tech/S6sYZnKwpQ8.jpg"/>',
        'caption' => '<a class="btn btn-lg btn-success" href="http://basic/web/site/'.Html::encode("{$category->url}").'">'.Html::encode("{$category->name}").'</a><p>Удобный встроенный генератор кода. Модули, модели на основе таблиц в БД и, конечно же, CRUD</p>',
        'options' => []
    ];
endforeach;

echo Carousel::widget ( [
    'items' => $carouselItems,
    'options' => [
        'style' => 'width: 100%;'
    ]
]);
?>
</div>
