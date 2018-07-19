<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dishes;

/**
 * DishesSearch represents the model behind the search form of `app\models\Dishes`.
 */
class DishesSearch extends Dishes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cooking_time'], 'integer'],
            [['name', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dishes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cooking_time' => $this->cooking_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    /**
     * @param array $products_ids
     * @return ActiveDataProvider
     */
    public function searchByProductsIds($products_ids = [])
    {
        $arr = [];
        if (!empty($products_ids)) {
            $products_ids = array_keys($products_ids);
            foreach ($products_ids as $id) {
                $arr[$id] = ['product_id' => $id];
            }
        }
        $products_ids = $arr;

        $dishes_arr = DishesProducts::find()
            ->select(['dish_id'])
            ->where(['product_id' => $products_ids])
            ->asArray()
            ->all();

        $arr = [];
        foreach ($dishes_arr as $item) {
            $dish = Dishes::find()->where(['id' => $item['dish_id']])
                ->with('products')->limit(1)->one();
            $productsArrIds = $dish->getProductsIdsArr();
            $result = array_diff_key($products_ids, $productsArrIds);
            if (!count($result)) {
                $arr[] = $item['dish_id'];
            }
        }

        $query = Dishes::find();
        $query->andFilterWhere(['id' => $arr]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5]
        ]);
        return $dataProvider;
    }
}
