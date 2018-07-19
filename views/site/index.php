<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'Поиск блюда';
?>

<div class="alert alert-info js-orders-info hidden" role="alert">
    Количество блюд в процессе приготовления:
    <?= Html::a('<<span id="count-orders"></span>>',
        Url::to(['/dishes/view-orders']),
        ['title' => 'Открыть']); ?>
</div>

<? Pjax::begin(['id' => 'dishes_list']); ?>

<?= $this->renderAjax("search_from",
    [
        'formName' => $formName,
        'products' => $products
    ]
); ?>

<?= GridView::widget([
    'tableOptions' => [
        'id' => 'dishes_table',
        'class' => 'table table-bordered table-striped',
    ],
    'rowOptions' => ['class' => 'table-row'],
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],

        [
            'attribute' => 'id',
        ],

        [
            'attribute' => 'name',
        ],
        [
            'attribute' => 'cooking_time',
        ],
        [
            'value' => function ($model) {
                return \yii\helpers\Html::a(
                    'заказать',
                    Url::to(['dishes/order/' . $model->id]),
                    ['title' => 'Заказать', 'class' => 'btn btn-info js-order-dish']);
            },
            'format' => 'html'
        ],
        [
            'class' => \yii\grid\ActionColumn::className(),
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        Url::to(['dishes/view/' . $model->id]),
                        ['title' => 'Просмотреть']);
                },
            ],
            'template' => '{view}'
        ],
    ]
]); ?>
<? Pjax::end();

$this->registerJsFile(Url::to('@web/js/script.js'), ['position' => View::POS_END, 'depends' => 'yii\web\JqueryAsset']);
