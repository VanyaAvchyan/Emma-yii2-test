<?php

/* @var $this yii\web\View */

$this->title = 'Import file';
?>
<div class="site-index">
    <h2>Products Upload</h2>
    <form id="storeUpload" action="" class="dropzone" enctype="multipart/form-data">
        <div class="">
            <input name="title" placeholder="Store title"/>
        </div>
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
        <div class="dz-message" data-dz-message>
            <p>Available extensions is <?=$file_extensions?></p>
            <p>(Store products) Drop files here or brows</p>
        </div>
    </form>
</div>
