<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class StoreProduct
 * @package app\models
 */
class StoreProduct extends ActiveRecord
{
    /**
     * Get DB table name
     * @return string
     */
    public static function tableName()
    {
        return 'store_products';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
//            [['title'], 'required']
        ];
    }

    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }
}
