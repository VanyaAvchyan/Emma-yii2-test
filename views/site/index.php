<?php

/* @var $this yii\web\View */

$this->title = 'List of importers';
?>
<div class="site-index">
    <h2>Products</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Store</th>
                <th scope="col">UPC</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($products as $key => $product) { ?>
        <tr>
            <th><?=$key?></th>
            <th><?=!empty($product['store']) ? $product['store']['title'] : ""?></th>
            <th><?=$product['title']?></th>
            <th><?=$product['upc']?></th>
            <th><?=$product['price']?></th>
        </tr>
        <?php } ?>
        </tbody>
    </table>

    <h2>Wrong Products</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Store</th>
                <th scope="col">UPC</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($wrong_products as $key => $product) { ?>
        <tr>
            <th><?=$key?></th>
            <th><?=!empty($product['store']) ? $product['store']['title'] : ""?></th>
            <th><?=$product['title']?></th>
            <th><?=$product['upc']?></th>
            <th><?=$product['price']?></th>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
