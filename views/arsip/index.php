<?php

use app\models\Arsip;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ArsipSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Daftar Arsip';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arsip-index">
    <p>
        <?= Html::a('➕ Upload Arsip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layout' => "{items}\n{pager}", // tambahkan ini agar pager tampil
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Ikon',
            'format' => 'raw',
            'value' => function ($model) {
                $ext = strtolower(pathinfo($model->file_path, PATHINFO_EXTENSION));
                $icon = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp']) ? 'img-icon.png' :
                        ($ext === 'pdf' ? 'pdf-icon.png' : 'file-icon.png');

                return Html::img(Yii::getAlias('@web/image/' . $icon), [
                    'alt' => strtoupper($ext),
                    'style' => 'width:24px;',
                ]);
            },
            'contentOptions' => ['style' => 'text-align:center; width:50px;'],
        ],
        'judul',
        [
            'attribute' => 'uploaded_at',
            'format' => ['datetime', 'php:d M Y H:i'],
            'label' => 'Tanggal Upload'
        ],
        [
            'attribute' => 'file_path',
            'label' => 'Lokasi File',
            'value' => function ($model) {
                return $model->folder ? $model->getFolderPath() : '-';
            }
        ],
        [
            'label' => 'File',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('📄 Lihat', Yii::getAlias('@web/' . $model->file_path), [
                    'target' => '_blank',
                    'class' => 'btn btn-sm btn-primary'
                ]);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, Arsip $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
            'header' => 'Aksi',
            'contentOptions' => ['style' => 'width:120px;'],
        ],
    ],
]) ?>

</div>
