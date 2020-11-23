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
            'store_id' => $this->integer()->notNull()->unsigned(),
            'upc' => $this->string()->notNull(),
            'title' => $this->string(),
            'price' => $this->float(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()')
        ]);
        $this->addForeignKey('FK_store_products_stor_id', 'store_products', 'store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('UQ_store_products_stor_id_upc', 'store_products', 'store_id,upc', 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('store_products');
    }
}
