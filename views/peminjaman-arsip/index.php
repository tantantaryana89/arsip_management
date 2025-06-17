<?php

use app\models\PeminjamanArsip;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;

$this->title = 'Form Peminjaman Arsip';
$this->params['breadcrumbs'][] = $this->title;

// Register toastr assets if needed (uncomment if you want to use toastr)
// $this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
// $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="peminjaman-arsip-index">
    <p>
        <?= Html::a('<i class="fas fa-plus"></i> Input data peminjaman dokumen', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fas fa-download"></i> Unduh Form Peminjaman', ['download-form'], [
            'class' => 'btn btn-outline-primary',
            'title' => 'Unduh formulir PDF'
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama_peminjam',
            'unit',
            'judul_dokumen',
            'tanggal_pinjam',
            [
                'attribute' => 'tanggal_kembali',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<span id="tanggal-kembali-' . $model->id . '">' .
                        ($model->tanggal_kembali ? Yii::$app->formatter->asDate($model->tanggal_kembali, 'php:d M Y') : '-') .
                        '</span>';
                },
            ],
            'keterangan:ntext',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $label = $model->status == 1 ? '✅ Sudah Dikembalikan' : '❌ Belum DiKembalikan';
                    $class = $model->status == 1 ? 'btn-success' : 'btn-warning';

                    return Html::button($label, [
                        'class' => "btn btn-sm $class update-status-btn",
                        'data-id' => $model->id,
                        'data-status' => $model->status,
                    ]);
                },
            ],
        ],
    ]); ?>

    <?php Modal::begin([
        'title' => 'Konfirmasi Pengembalian Arsip',
        'id' => 'modal-status',
        'size' => Modal::SIZE_DEFAULT,
    ]); ?>
        <div class="modal-body">
            <p>Apakah arsip ini sudah dikembalikan?</p>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn-confirm-status" class="btn btn-success">✅ Ya, Sudah Kembali</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    <?php Modal::end(); ?>
</div>

<?php
$js = <<<JS
function showNotification(message, type) {
    // SweetAlert
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type,
            title: type === 'success' ? 'Berhasil' : 'Gagal',
            text: message,
            timer: 3000
        });
    } 
    // Toastr
    else if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } 
    // Fallback: Bootstrap alert
    else {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show temp-alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999">' +
                        message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button></div>';
        $('.temp-alert').remove();
        $('body').append(alertHtml);
        setTimeout(function() { $('.temp-alert').fadeOut(); }, 3000);
    }
}

// Tombol status diklik
$(document).on('click', '.update-status-btn', function(e) {
    e.preventDefault();
    var btn = $(this);
    if (btn.data('status') == 0) {
        $('#modal-status').data('id', btn.data('id')).modal('show');
    }
});

// Konfirmasi "Sudah Kembali"
$(document).on('click', '#btn-confirm-status', function() {
    var btn = $(this);
    var id = $('#modal-status').data('id');

    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Memproses...');

    $.ajax({
       url: window.location.origin + '/index.php?r=peminjaman-arsip/update-status',
        type: 'POST',
        data: {
            id: id,
            status: 1,
            _csrf: yii.getCsrfToken()
        },
        success: function(response) {
            if (response.success) {
                var statusBtn = $('.update-status-btn[data-id="' + id + '"]');
                statusBtn.removeClass('btn-warning')
                         .addClass('btn-success')
                         .text('✅ Sudah Dikembalikan')
                         .data('status', 1);

                $('#tanggal-kembali-' + id).text(response.tanggal_kembali);

                // Blur dulu sebelum tutup modal (hindari error aria-hidden)
                document.activeElement.blur();
                $('#modal-status').modal('hide');

                showNotification('Status berhasil diperbarui', 'success');
            } else {
                showNotification('Gagal memperbarui status', 'error');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan server';
            try {
                let response = JSON.parse(xhr.responseText);
                if (response.message) {
                    errorMessage = response.message;
                }
            } catch (e) {}
            showNotification(errorMessage, 'error');
        },
        complete: function() {
            btn.prop('disabled', false).text('✅ Ya, Sudah Kembali');
        }
    });
});
JS;

$this->registerJs($js);
?>
