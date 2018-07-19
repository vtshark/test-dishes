<?php

use yii\db\Migration;

/**
 * Class m180718_103419_add_products_table
 */
class m180718_103419_add_products_table extends Migration
{
    const TABLE = '{{%products}}';
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
                'name' =>  $this->string(255)->notNull()->unique(),
                'description' =>  $this->string(255)->defaultValue(null),
            ],$tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }

}
