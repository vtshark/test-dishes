<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes_products".
 *
 * @property int $id
 * @property int $dish_id
 * @property int $product_id
 *
 * @property Dishes $dish
 * @property Products $product
 */
class DishesProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dishes_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dish_id', 'product_id'], 'integer'],
            [['dish_id', 'product_id'], 'required'],
            [['dish_id', 'product_id'], 'unique', 'targetAttribute' => ['dish_id', 'product_id']],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dishes::className(), 'targetAttribute' => ['dish_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dish_id' => 'id блюда',
            'product_id' => 'id продукта',
        ];
    }

}
