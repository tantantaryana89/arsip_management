<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PeminjamanArsipSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="peminjaman-arsip-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'arsip_id') ?>

    <?= $form->field($model, 'nama_peminjam') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'tanggal_pinjam') ?>

    <?php // echo $form->field($model, 'tanggal_kembali') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
