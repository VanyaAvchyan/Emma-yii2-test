<?php
namespace app\services\filefactory;
abstract class AImportFileFactory {
    abstract function getAsArray(\yii\web\UploadedFile $file);
    abstract function saveSuccessProduct($store_id, $datas);
    abstract function saveWrongProduct($store_id, $datas);
}