<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="arsip-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'folder_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'judul')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->isNewRecord && $model->file_path): ?>
        <div class="mb-2">
            <label><strong>File saat ini:</strong></label><br>
            <a href="<?= Yii::getAlias('@web/' . $model->file_path) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                📄 Lihat Arsip
            </a>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'upload_file')->fileInput() ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
