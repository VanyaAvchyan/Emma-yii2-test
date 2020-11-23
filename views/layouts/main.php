<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'List of importers', 'url' => ['/site/index']],
                    ['label' => 'Import', 'url' => ['/site/create']]
                ],
            ]);
            NavBar::end();
            ?>
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
        <?php $this->endBody() ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.css" integrity="sha512-bbUR1MeyQAnEuvdmss7V2LclMzO+R9BzRntEE57WIKInFVQjvX7l7QZSxjNDt8bg41Ww05oHSh0ycKFijqD7dA==" crossorigin="anonymous" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js" integrity="sha512-8l10HpXwk93V4i9Sm38Y1F3H4KJlarwdLndY9S5v+hSAODWMx3QcAVECA23NTMKPtDOi53VFfhIuSsBjjfNGnA==" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function () {
                //todo acceptedFiles make dynamic
                var acceptedFiles = ".csv";
                Dropzone.autoDiscover = false;
                $("#storeUpload").dropzone({
                    acceptedFiles: acceptedFiles,
                    parallelUploads: 2,
                    maxFiles: 20,
                    addRemoveLinks: false,
                    url: "?r=site/create-store",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    queuecomplete : function(a, b) {
                        window.location.href = "<?=\yii\helpers\Url::base(true)?>";
                    },
                    complete: function(file) {
                        if (file.size > 5*1024*1024) {
                            alert("File was Larger than 5Mb!");
                            return false;
                        }
                    },
                    success: function (file, response) {
                        var imgName = response;
                        file.previewElement.classList.add("dz-success");
                        console.log("Successfully uploaded :" + imgName);
                    },
                    error: function (file, error, xhr) {
                        $(file.previewElement).remove();
                        file.previewElement.classList.add("dz-error");
                        if(xhr) {
                            var xhr_error = JSON.parse(xhr.responseText);
                            alert(xhr_error.message);
                        } else {
                            alert(error);
                            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(error);
                        }

                    }
                }).on('queuecomplete', function () {
                    console.log("complete");
                });
            });
        </script>
    </body>
</html>
<?php $this->endPage() ?>
