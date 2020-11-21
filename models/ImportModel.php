<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ImportModel extends Model
{
    public $file;
    const FILE_EXTENSIONS = ['csv'/*, 'xlsx', 'pdf'*/];

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'extensions' => self::FILE_EXTENSIONS, 'checkExtensionByMimeType' => false, 'maxSize' => 5*1024*1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Import file',
        ];
    }

}