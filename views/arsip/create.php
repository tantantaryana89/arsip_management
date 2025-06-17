<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Arsip $model */

$this->title = 'Create Arsip';
$this->params['breadcrumbs'][] = ['label' => 'Arsips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arsip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
