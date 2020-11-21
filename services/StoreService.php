<?php

namespace app\services;

use app\models\Store;

class StoreService
{
    /**
     * @var Store
     */
    private $model;

    /**
     * StoreService constructor.
     */
    public function __construct(Store $store)
    {
        $this->model = $store;
    }

    public function getAll() {
        return $this->model->find()->all();
    }

    public function create($data) {
        try {
            $this->model->load($data);
            $this->model->attributes = $data;
            if ($this->model->validate()) {
                $store = $this->model->find()->where(['title'=>$data['title']])->one();
                if($store)
                    return $store->id;
                if($this->model->save())
                    return $this->model->id;
                throw new \Exception('Can not save.');
            }
            throw new \Exception(json_encode($this->model->errors));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}