<?php

use yii\db\Migration;

/**
 * Class m180718_114716_add_dishes_table
 */
class m180718_114716_add_dishes_table extends Migration
{
    const TABLE = '{{%dishes}}';
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
                'name' => $this->string(255)->notNull()->unique(),
                'cooking_time' => $this->integer(11)->notNull()->defaultValue(0),
                'description' => $this->string(255)->defaultValue(null),
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
