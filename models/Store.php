<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Store
 * @package app\models
 */
class Store extends ActiveRecord
{
//    public $id;
//    public $title;

    /**
     * Get DB table name
     * @return string
     */
    public static function tableName()
    {
        return 'stores';
    }

    /**
     * @inheritdoc
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title'], 'required']
        ];
    }

    public function getSuccess_products_count()
    {
        return $this->hasMany(StoreProduct::className(), ['store_id' => 'id'])->count();
    }

    public function getWrong_products_count()
    {
        return $this->hasMany(WrongProduct::className(), ['store_id' => 'id'])->count();
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Store title'
        ];
    }
}
