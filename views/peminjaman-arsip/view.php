<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PeminjamanArsip $model */

$this->title = $model->nama_peminjam;
$this->params['breadcrumbs'][] = ['label' => 'Peminjaman Arsips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="peminjaman-arsip-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'arsip_id',
            'nama_peminjam',
            'unit',
            'judul_dokumen',
            'tanggal_pinjam',
            'tanggal_kembali',
            'keterangan:ntext',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
