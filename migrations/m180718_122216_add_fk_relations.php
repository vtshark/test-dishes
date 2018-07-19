<?php

use yii\db\Migration;

/**
 * Class m180718_122216_add_fk_relations
 */
class m180718_122216_add_fk_relations extends Migration
{
    const TABLE = '{{%dishes_products}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_products',
            self::TABLE, 'product_id',
            '{{%products}}', 'id',
            'SET NULL', 'NO ACTION'
        );
        $this->addForeignKey('fk_dishes',
            self::TABLE, 'dish_id',
            '{{%dishes}}', 'id',
            'SET NULL', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_products', self::TABLE);
        $this->dropForeignKey('fk_dishes', self::TABLE);
    }
}
