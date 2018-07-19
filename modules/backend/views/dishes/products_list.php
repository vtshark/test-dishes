<?php

use yii\helpers\Url;

/* @var $model app\models\Dishes */
?>
<? if (!$model->isNewRecord) : ?>
    <hr>
    <div class="list-group">
        <a href="#" class="list-group-item active">
            Состав блюда
        </a>
        <? if (!empty($model->products)) : ?>
            <? foreach ($model->products as $product) : ?>
                <a href="#" class="list-group-item">
                    <?= $product->name ?>
                </a>
            <? endforeach; ?>
        <? else: ?>
            <a href="#" class="list-group-item">
                записи отсутсвуют
            </a>
        <? endif; ?>
    </div>
    <a href="<?= Url::to("/backend/dish-products/update/" . $model->id) ?>" class="btn btn-success">
        Редактировать состав
    </a>
<? endif; ?>