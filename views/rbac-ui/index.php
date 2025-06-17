<?php

use yii\helpers\Html;

$this->title = 'Manajemen RBAC';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rbac-dashboard">
  
    <p>Silakan pilih menu manajemen RBAC di bawah ini:</p>

    <div class="col-md-3">
    <?= Html::a('Assignment', ['/admin/assignment'], ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <div class="col-md-3">
        <?= Html::a('Role', ['*'], ['class' => 'btn btn-primary btn-block']) ?>
    </div>
    <div class="col-md-3">
        <?= Html::a('Permission', ['*'], ['class' => 'btn btn-warning btn-block']) ?>
    </div>
    <div class="col-md-3">
        <?= Html::a('Rule', ['/admin/rule'], ['class' => 'btn btn-info btn-block']) ?>
    </div>

</div>
