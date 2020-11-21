<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%store_products}}`.
 */
class m201119_080509_create_store_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('store_products', [
            'id' => $this->primaryKey()->unsigned(),
            'store_id' => $this->integer()->unsigned(),
            'upc' => $this->string()->unique(),
            'title' => $this->string(),
            'price' => $this->float(),
        ]);
        $this->addForeignKey('FK_store_products_stor_id', 'store_products', 'store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('store_products');
    }
}
