<?php

namespace app\services;

use app\models\StoreProduct;
use app\models\WrongProduct;

class ProductService
{
    /**
     * @var StoreProduct
     */
    private $productModel, $wrongModel, $fileService;

    /**
     * ProductService constructor.
     * @param StoreProduct $product
     * @param ImportService $fileService
     */
    public function __construct(StoreProduct $product,WrongProduct $wrongModel, ImportService $fileService)
    {
        $this->productModel = $product;
        $this->wrongModel = $wrongModel;
        $this->fileService = $fileService;
    }

    /**
     * @param array $relations
     * @param array $conditions
     * @return array
     */
    public function getAll($relations=[], $conditions=[]) {
        $model = $this->productModel->find();
        foreach($relations as $relation){
            $model = $model->with($relation);
        }
        return $model->asArray()->all();
    }

    /**
     * @param array $relations
     * @param array $conditions
     * @return array
     */
    public function getAllWrongs($relations=[], $conditions=[]) {
        $model = $this->wrongModel->find();
        foreach($relations as $relation){
            $model = $model->with($relation);
        }
        return $model->asArray()->all();
    }

    /**
     * @param $store_id
     * @param \yii\web\UploadedFile $file
     * @return void|\yii\web\UploadedFile
     * @throws \Exception
     */
    public function create($store_id, \yii\web\UploadedFile $file) {
        try {
            $file = $this->fileService->import($store_id, $file);
            return $file;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


}
