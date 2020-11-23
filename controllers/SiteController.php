<?php

namespace app\controllers;

use app\models\ImportModel;
use app\services\ProductService;
use app\services\StoreService;
use yii\web\Controller;
use yii\web\UploadedFile;

class SiteController extends Controller
{

    public function actionIndex(StoreService $service)
    {
        return $this->render('index', [
            'stores' => $service->getAll(['store'])
        ]);
    }

    public function actionCreate()
    {
        return $this->render('create', [
            'file_extensions' => '.'.implode(',.', ImportModel::FILE_EXTENSIONS)
        ]);
    }

    public function actionCreateStore(StoreService $storeService, ProductService $productService)
    {
        try {
            if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax) {
                $store_id = $storeService->create(\Yii::$app->request->post());
                $importModel = new ImportModel();
                $importModel->file = UploadedFile::getInstanceByName('file');
                if ($importModel->validate()) {
                    $result = $productService->create($store_id, $importModel->file);
                    return $this->asJson($result);
                }
                throw new \Exception(json_encode($importModel->errors));
            }
            throw new \Exception('Wronq request method!');
        } catch (\Exception $e) {
            \Yii::$app->response->statusCode = 500;
            return $this->asJson(['message' => $e->getMessage()]);
        }
    }
}
