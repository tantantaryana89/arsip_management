<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Folder $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="folder-form card">
    <div class="card-header bg-primary text-white">
        <h4 class="card-title mb-0"><?= Html::encode($model->isNewRecord ? 'Buat Folder Baru' : 'Edit Folder') ?></h4>
    </div>
    
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback']
            ]
        ]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Masukkan nama folder',
                    'class' => 'form-control form-control-lg'
                ]) ?>
            </div>
        </div>

        <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>

        <div class="form-group mt-4">
            <div class="d-flex justify-content-between">
                <?= Html::a('<i class="fas fa-times"></i> Batal', ['index'], [
                    'class' => 'btn btn-outline-secondary'
                ]) ?>
                
                <?= Html::submitButton(
                    $model->isNewRecord ? '<i class="fas fa-folder-plus"></i> Buat Folder' : '<i class="fas fa-save"></i> Simpan Perubahan', 
                    ['class' => 'btn btn-primary px-4']
                ) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
// Additional CSS styling
$css = <<<CSS
.folder-form .card {
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.folder-form .form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1.05rem;
}

.folder-form .invalid-feedback {
    display: block;
    margin-top: 0.25rem;
}

.folder-form .btn {
    min-width: 120px;
}
CSS;
$this->registerCss($css);
?>