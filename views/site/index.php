<?php

/* @var $this yii\web\View */

$this->title = 'List of importers';
?>
<div class="site-index">
    <h2>Imports</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Store</th>
                <th scope="col">Success Count</th>
                <th scope="col">Wrong Count</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($stores as $store) { ?>
        <tr>
            <th><?=$store['id']?></th>
            <th><?=$store->title?></th>
            <th><?=$store->success_products_count?></th>
            <th><?=$store->wrong_products_count?></th>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
