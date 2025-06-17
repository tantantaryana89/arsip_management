<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PeminjamanArsip $model */

$this->title = 'Update Peminjaman Arsip: ' . $model->nama_peminjam;
$this->params['breadcrumbs'][] = ['label' => 'Peminjaman Arsips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="peminjaman-arsip-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
