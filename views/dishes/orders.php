<div class="panel panel-default">
    <div class="panel-heading">Заказы</div>
    <div class="panel-body">
        <? if (count($dishes)) : ?>
        <? foreach ($dishes as $dish) : ?>
                id блюда: <?= $dish['dishModel']->id ?>
                <br>
                Наименование блюда: <?= $dish['dishModel']->name ?>
                <br>
                Описание блюда: <?= $dish['dishModel']->description ?>
                <br>
                Время завершения: <?= date(" H:i:s d.m.Y", $dish['exp_time']) ?>
            <hr>
        <? endforeach; ?>
        <? else: ?>
            заказы отсутсвуют
        <? endif; ?>

    </div>
</div>