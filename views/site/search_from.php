<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="panel panel-default">
    <div class="panel-heading">Фильтр блюд по продуктам</div>
    <?= Html::beginForm(Url::to(['site/index']), 'get', ['data-pjax' => '']); ?>
        <div class="panel-body">
            <? foreach ($products as $product) : ?>
                <span class="">
                    <?= Html::checkbox($formName . '['. $product['id'] .']', $product['checked']) ?>
                    <?= $product['name'] ?>
                </span>

            <? endforeach; ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Сброс фильтра', Url::to(['site/index']), ['class' => 'btn btn-default']) ?>
        </div>

    <?= Html::endForm() ?>

</div>