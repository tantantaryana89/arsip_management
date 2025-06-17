<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var string $content */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?> | E-Arsip</title>
    <?php $this->head() ?>
    
    <!-- AdminLTE & Font Awesome -->
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/adminlte/dist/css/adminlte.min.css') ?>">

    <!-- Optional: Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <style>
        body {
            background: url('<?= Yii::getAlias('@web/image/bg.jpg') ?>') no-repeat center center fixed;
            background-size: cover;
        }
        .login-box {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>

<?= $content ?>

<!-- AdminLTE Scripts -->
<script src="<?= Yii::getAlias('@web/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= Yii::getAlias('@web/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= Yii::getAlias('@web/adminlte/dist/js/adminlte.min.js') ?>"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
