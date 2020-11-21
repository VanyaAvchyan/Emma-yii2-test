<?php

namespace app\services;

use app\services\filefactory\CSVImporter;
use yii\web\UploadedFile;

class ImportService
{
    /**
     * @param $store_id
     * @param UploadedFile $file
     * @return bool
     * @throws \Exception
     */
    public function import($store_id, \yii\web\UploadedFile $file)
    {
        try{
            $ext = $file->getExtension();
            $importer = $this->fileFactory($ext);
            $results = $importer->getAsArray($file);
            $importer->saveSuccessProduct($store_id, $results['success_results']);
            $importer->saveWrongProduct($store_id, $results['wrong_results']);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function fileFactory($ext)
    {
        switch ($ext) {
            case 'csv': return new CSVImporter(); break;
            default: throw new \Exception('Unsupported extension');
        }
    }
}