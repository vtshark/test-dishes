<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="list-group">
<a href="#" class="list-group-item active">
    Состав блюда
</a>

    <? $form = ActiveForm::begin(); ?>
    <? foreach ($products as $product) : ?>
        <a href="#" class="list-group-item">
            <?= Html::checkbox($formName . '['. $product['id'] .']', $product['checked']) ?>
            <?= $product['name'] ?>
        </a>

    <? endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <? ActiveForm::end(); ?>

</div>
