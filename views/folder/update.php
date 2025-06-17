<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Folder $model */

$this->title = 'Edit Folder: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Folder Arsip', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="folder-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
