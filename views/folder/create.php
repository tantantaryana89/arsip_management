<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Folder $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="folder-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'placeholder' => 'Masukkan nama folder',
                'class' => 'form-control form-control-lg'
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> Simpan', [
            'class' => 'btn btn-success btn-lg',
            'encode' => false
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

