<?php
namespace app\services\filefactory;

class CSVImporter extends AImportFileFactory {
    /**
     * @param \yii\web\UploadedFile $file
     * @return array
     */
    public function getAsArray(\yii\web\UploadedFile $file) {
        $handle = fopen($file->tempName, 'r');
        $success_results = [];
        $wrong_results = [];
        if ($handle) {
            $cnt = 0;
            while( ($line = fgetcsv($handle, 1000, ",")) != FALSE) {
                $upc = '';
                $title = '';
                $price = '';
                foreach($line as $k => $value) {
                    if(is_numeric($value))
                        $num = $value*1;
                    else {
                        if($value) {
                            $title = $value;
                            continue;
                        }
                    }
                    if($num)
                    {
                        if(is_float($num))
                            $price = $value;
                    else
                        $upc = $value;
                    }
                }
                if(!$upc)
                {
                    if($title && $price) {
                        $wrong_results[$cnt]['title'] = $title;
                        $wrong_results[$cnt]['price'] = $price;
                    }
                } else {
                    if(!($title && $price)){
                        $wrong_results[$cnt]['upc']   = $upc;
                        $wrong_results[$cnt]['title'] = $title;
                        $wrong_results[$cnt]['price'] = $price;
                        continue;
                    }
                    $success_results[$cnt]['upc']   = $upc;
                    $success_results[$cnt]['title'] = $title;
                    $success_results[$cnt]['price'] = $price;
                }
                $cnt++;
            }
        }
        fclose($handle);
        return [
            'success_results' => $success_results,
            'wrong_results' => $wrong_results
        ];
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
            $sql = 'insert into wrong_products (store_id, upc,title,price) values';
            foreach ($datas as $data) {
                if(empty($data['upc']))
                    $data['upc'] = '';
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
}