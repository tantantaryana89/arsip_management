<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PeminjamanArsip $model */

$this->title = 'Create Peminjaman Arsip';
$this->params['breadcrumbs'][] = ['label' => 'Peminjaman Arsips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-arsip-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
