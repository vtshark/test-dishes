<?php

namespace app\controllers;


use app\models\Orders;
use Yii;
use app\models\Dishes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\helpers\Html;

class DishesController extends Controller
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $dish = $this->findModel($id);
        return $this->render('view', ['dish' => $dish]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrder($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dish = $this->findModel($id);

        $orders = new Orders();
        $list = $orders->refreshCacheList();
        if (isset($list[$id])) {
            return json_encode([
                'error' => true,
                'data' => 'Данное блюдо уже в процессе приготовления.'
            ]);

        }
        if (!$orders->addToListOrders($id, $dish->cooking_time)) {
            return json_encode([
                'error' => true,
                'data' => 'На данный момент в очереди 2 блюда. Дождитесь завершения приготовления.'
            ]);
        }
        $url = Url::to('/dishes/view-orders');
        $link = Html::a("заказы", $url);
        return json_encode(['error' => false, 'data' => 'Блюдо поступило в заказ. Просмотреть ' . $link]);

    }

    /**
     * @return string
     */
    public function actionViewOrders()
    {
        $orders = new Orders();
        return $this->render('orders', ['dishes' => $orders->getDishes()]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionCheckOrders()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $orders = new Orders();
        $count_orders = count($orders->refreshCacheList());

        return json_encode(
            [
                'error' => false,
                'data' => ['count_orders' => $count_orders]
            ]
        );
    }

    /**
     * @param $id
     * @return Dishes|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}