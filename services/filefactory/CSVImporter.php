<?php
namespace app\services\filefactory;

use phpDocumentor\Reflection\Types\False_;

class CSVImporter extends AImportFileFactory {
    /**
     * @param \yii\web\UploadedFile $file
     * @return array
     */
    public function getAsArray(\yii\web\UploadedFile $file) {
        try {
            $key = 'success_results';
            $results = [];
            $csvlines = array_map('str_getcsv', file($file->tempName));
            if(!$csvlines)
                throw new \Exception('File is empty!');
            $headers = array_shift($csvlines);
            if(array_search('upc', $headers) === false)
                $key = 'wrong_results';
            foreach ($csvlines as $line) {
                $results[] = array_combine($headers, $line);
            }
            return [
                $key => $results
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $store_id
     * @param $datas
     * @return bool
     * @throws \Exception
     */
    public function saveSuccessProduct($store_id, $datas) {
        $connection = \Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try {
            $sql = 'insert into store_products (store_id, upc, title, price) values';
            foreach ($datas as $data) {
                if(empty($data['title']))
                    $data['title'] = '';
                if(empty($data['price']))
                    $data['price'] = '';
                $sql.="({$store_id}, '{$data['upc']}', '{$data['title']}', '{$data['price']}'),";
            }
            $sql = rtrim($sql,',');
            $sql.=" ON DUPLICATE KEY UPDATE title=VALUES(title), price=VALUES(price)";
            $command = $connection->createCommand($sql);
            $command->execute();
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $store_id
     * @param $datas
     * @return bool
     * @throws \Exception
     */
    public function saveWrongProduct($store_id, $datas) {
        $connection = \Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try {
            $sql = 'insert into wrong_products (store_id, title, price) values';
            foreach ($datas as $data) {
                if(empty($data['title']))
                    $data['title'] = '';
                if(empty($data['price']))
                    $data['price'] = '';
                $sql.="({$store_id}, '{$data['title']}', '{$data['price']}'),";
            }
            $sql = rtrim($sql,',');
            $sql.=" ON DUPLICATE KEY UPDATE title=VALUES(title), price=VALUES(price)";
            $command = $connection->createCommand($sql);
            $command->execute();
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}