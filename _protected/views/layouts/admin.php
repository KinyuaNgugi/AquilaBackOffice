<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php require_once('login-styles.php');?>
    </head>
    <body class="login">
        <?php $this->beginBody() ?>
        <div class="page-wrapper"> 
            <?= $content ?>
        </div>
        <?php require_once('login-scripts.php');?>
    </body>
</html>
<?php $this->endPage() ?>
