<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\PeminjamanArsip $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="peminjaman-arsip-form card">
    <div class="card-header bg-primary text-white">
        <h4 class="card-title mb-0"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => ''],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label fw-semibold'],
            ],
        ]); ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $form->field($model, 'arsip_id')->dropDownList(
                    ArrayHelper::map(\app\models\Arsip::find()->all(), 'id', 'judul'),
                    [
                        'prompt' => '-- Pilih Arsip --',
                        'class' => 'form-select w-100'
                    ]
                ) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'nama_peminjam')->textInput([
                    'class' => 'form-control w-100',
                    'placeholder' => 'Nama lengkap peminjam'
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $form->field($model, 'unit')->dropDownList(
                    [
                        'CQC' => 'CQC',
                        'FQC' => 'FQC',
                        'PFC' => 'FPC',
                        'CMC' => 'CMC',
                        'ENG' => 'ENG'
                    ],
                    [
                        'prompt' => '-- Pilih Unit --',
                        'class' => 'form-select w-100'
                    ]
                ) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'judul_dokumen')->textInput([
                    'class' => 'form-control w-100',
                    'placeholder' => 'Judul dokumen yang dipinjam'
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $form->field($model, 'tanggal_pinjam')->input('date', [
                    'class' => 'form-control w-100'
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'keterangan')->textInput([
                    'class' => 'form-control w-100',
                    'placeholder' => 'Keterangan tambahan'
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $form->field($model, 'status')->dropDownList([
                    0 => 'Belum Kembali',
                    1 => 'Sudah Dikembalikan',
                ], [
                    'class' => 'form-select w-100',
                    'id' => 'status-select'
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'tanggal_kembali')->input('date', [
                    'class' => 'form-control w-100',
                    'id' => 'tanggal-kembali',
                    'disabled' => $model->status != 1
                ]) ?>
            </div>
        </div>

        <div class="text-end mt-4">
            <?= Html::submitButton('<i class="fas fa-save"></i> Simpan', ['class' => 'btn btn-success px-4']) ?>
            <?= Html::a('<i class="fas fa-times"></i> Batal', ['index'], ['class' => 'btn btn-secondary px-4']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$script = <<<JS
function toggleTanggalKembali() {
    const status = $('#status-select').val();
    const kembaliField = $('#tanggal-kembali');
    
    if (status == '1') {
        const today = new Date().toISOString().split('T')[0];
        kembaliField.prop('disabled', false).val(today);
    } else {
        kembaliField.val('').prop('disabled', true);
    }
}

$(document)
    .on('change', '#status-select', toggleTanggalKembali)
    .ready(toggleTanggalKembali);
JS;
$this->registerJs($script);
?>
