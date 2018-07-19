<?php
/* @var $dish app\models\Dishes */
?>


<div class="panel panel-default">
    <div class="panel-heading"><?= $dish->name ?></div>
    <div class="panel-body">
        Время пригодовления: <?= $dish->cooking_time ?> мин.
        <br>
        Описание: <?= $dish->description ?>
    </div>
</div>

    <hr>
    <div class="list-group">
        <a href="#" class="list-group-item active">
            Состав блюда
        </a>
        <? if (!empty($dish->products)) : ?>
            <? foreach ($dish->products as $product) : ?>
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

</div>

