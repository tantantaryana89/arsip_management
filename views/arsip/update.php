<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Arsip $model */

$this->title = 'Update Arsip: ' . $model->judul;
$this->params['breadcrumbs'][] = ['label' => 'Arsips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="arsip-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
