<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Dishes;
use app\models\DishesProducts;
use app\models\Products;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DishProductsController extends Controller
{

    /**
     * @param $dish_id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($dish_id)
    {
        $ids = DishesProducts::find()->where(['dish_id' => $dish_id])
            ->asArray()
            ->indexBy('product_id')
            ->all();
        $dishesProductsModel = new DishesProducts();
        $formName = $dishesProductsModel->formName();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $need_delete_products = [];
            foreach ($ids as $id => $arr) {
                if (!isset($post[$formName][$id])) {
                    $need_delete_products[] = $id;
                }
            }

            if (count($post[$formName])) {
                $add_products = array_keys($post[$formName]);
                foreach ($add_products as $product_id) {
                    if (!isset($ids[$product_id])) {
                        $dishesProducts = new DishesProducts();
                        $dishesProducts->setAttribute('dish_id', $dish_id);
                        $dishesProducts->setAttribute('product_id', $product_id);
                        $dishesProducts->save();
                    }
                }
            }
            DishesProducts::deleteAll(['product_id' => $need_delete_products]);

            return $this->redirect(['dishes/view', 'id' => $dish_id]);
        }


        $products = Products::find()->asArray()->all();

        foreach ($products as $id => &$product) {
            $product['checked'] = ($ids[$product['id']]) ? true : false;
        }

        return $this->render('/dishes/products_list_update',
            [
                'products' => $products,
                'formName' => $formName
            ]
        );
    }

    /**
     * Finds the Dishes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dishes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}