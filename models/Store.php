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

    public function getProducts()
    {
        return $this->hasMany(StoreProduct::className(), ['store_id' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Store title'
        ];
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }
}
