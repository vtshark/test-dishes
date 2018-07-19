<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property int $id
 * @property string $name
 * @property int $cooking_time
 * @property string $description

 * @property Products $products
 */
class Dishes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dishes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cooking_time'], 'required'],
            [['cooking_time'], 'integer', 'min' => 1],
            [['name', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'cooking_time' => 'Время приготовления(мин)',
            'description' => 'Описание',
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])
            ->viaTable('dishes_products', ['dish_id' => 'id']);
    }

    public function getProductsIdsArr()
    {
        return DishesProducts::find()
            ->select('product_id')
            ->where(['dish_id' => $this->id])
            ->indexBy('product_id')
            ->asArray()
            ->all();
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        DishesProducts::deleteAll(['dish_id' => $this->id]);

        return true;
    }
}
