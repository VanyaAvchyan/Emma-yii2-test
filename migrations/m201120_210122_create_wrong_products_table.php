<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wrong_products}}`.
 */
class m201120_210122_create_wrong_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wrong_products', [
            'id' => $this->primaryKey()->unsigned(),
            'store_id' => $this->integer()->unsigned(),
            'upc' => $this->string(),
            'title' => $this->string(),
            'price' => $this->float(),
        ]);
        $this->addForeignKey('FK_wrong_products_stor_id', 'wrong_products', 'store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('wrong_products');
    }
}
