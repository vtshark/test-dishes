<?php

namespace app\models;

use Yii;

class Orders
{
    const LIMIT = 2;

    /**
     * метод обновляет список заказов в кэше,
     * и вызывает метод для добавления записи о заказе в кэш
     *
     * @param $id
     * @param $cooking_time
     * @return bool
     */
    public function addToListOrders($id, $cooking_time)
    {
        $cache = Yii::$app->cache;
        $json_orders = $cache->get('list_orders');
        if ($json_orders) {
            $arr_orders = json_decode($json_orders, 1);
        } else {
            $arr_orders = [];
        }

        if (count($arr_orders) >= self::LIMIT) {
            return false;
        }
        if (!in_array($id, $arr_orders)) {
            $arr_orders[] = $id;
        }

        $list_order = json_encode($arr_orders);
        $cache->set('list_orders', $list_order);

        self::addToOrders($id, $cooking_time);

        return $id;
    }

    /**
     * добавление записи о заказе в кэш
     *
     * @param $id
     * @param $cooking_time
     */
    public function addToOrders($id, $cooking_time)
    {
        $cache = Yii::$app->cache;
        $time_exp = time() + $cooking_time * 60;
        $cache->set('dish_' . $id, $time_exp, $cooking_time * 60);
    }

    /**
     * получение обновленного списка заказов
     *
     * @return array
     */
    public function getList()
    {
        $list = self::refreshCacheList();
        return $list;
    }

    /**
     * обновление состяние списка заказов в кэше
     * и возврат списка
     * @return array
     */
    public function refreshCacheList() {
        $list = [];
        $result_list = [];
        $cache = Yii::$app->cache;
        $json_orders = $cache->get('list_orders');
        if ($json_orders) {
            $list = json_decode($json_orders, 1);
        }
        if (count($list)) {
            foreach ($list as $k => $dish_id) {
                $exp_time = $cache->get('dish_' . $dish_id);
                if (!$exp_time) {
                    unset($list[$k]);
                } else {
                    $result_list[$dish_id] = [
                        "dish_id" => $dish_id,
                        "exp_time" => $exp_time
                    ];
                }
            }
            $cache->set('list_orders', json_encode($list));
        }
        return $result_list;
    }

    /**
     * выборка блюд на основе списка заказов
     * @return array
     */
    public function getDishes()
    {
        $arrOrders = $this->refreshCacheList();
        $dishes = [];
        foreach ($arrOrders as $order) {
            $dish = Dishes::findOne($order['dish_id']);
            if ($dish) {
                $dishes[] = [
                    'exp_time' => $order['exp_time'],
                    'dishModel' => $dish
                ];
            }
        }
        return $dishes;
    }
}