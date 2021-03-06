<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stores}}`.
 */
class m201118_203743_create_stores_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('stores', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('stores');
    }
}
