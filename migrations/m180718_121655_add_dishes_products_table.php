<?php

use yii\db\Migration;

/**
 * Class m180718_121655_add_dishes_products_table
 */
class m180718_121655_add_dishes_products_table extends Migration
{
    const TABLE = '{{%dishes_products}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';
        $this->createTable(
            self::TABLE,
            [
                'id' => $this->primaryKey(11),
                'dish_id' => $this->integer(11)->defaultValue(null),
                'product_id' => $this->integer(11)->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('dish_id', self::TABLE, ['dish_id'], false);
        $this->createIndex('product_id', self::TABLE, ['product_id'], false);

        // set unique key
        $this->createIndex('unique_key', self::TABLE, ['dish_id', 'product_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }

}
