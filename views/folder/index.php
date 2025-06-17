<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\FolderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int|null $parentId */

$this->title = 'Folder Arsip';
$this->params['breadcrumbs'][] = $this->title;
$searchKeyword = Yii::$app->request->get('q');
?>
<div class="folder-index">
    <p>
        <?= Html::a('📁 Buat Folder Baru', ['create', 'parent_id' => $parentId], ['class' => 'btn btn-success']) ?>
        <?php if ($parentId): ?>
            <?= Html::a('⬅ Kembali', ['index', 'parent' => \app\models\Folder::findOne($parentId)->parent_id], ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('➕ Upload Arsip', ['/arsip/create', 'folder_id' => $parentId], ['class' => 'btn btn-info']) ?>
        <?php endif; ?>
    </p>

    <!-- Folder grid -->
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach ($dataProvider->models as $folder): ?>
            <div style="width: 120px; text-align: center;" title="<?= Html::encode($folder->name) ?>">
                <a href="<?= Url::to(['index', 'parent' => $folder->id]) ?>" style="text-decoration: none;">
                    <img src="<?= Yii::getAlias('@web/image/folder.png') ?>" style="width: 64px; height: 64px;"><br>
                    <?= Html::encode($folder->name) ?>
                </a>
                <div style="margin-top: 5px;">
                    <?= Html::a('✏️', ['update', 'id' => $folder->id], [
                        'title' => 'Edit nama folder',
                        'style' => 'margin-right: 10px;'
                    ]) ?>
                    <?= Html::a('🗑️', ['delete', 'id' => $folder->id], [
                        'data-confirm' => 'Yakin ingin menghapus folder ini?',
                        'data-method' => 'post',
                        'style' => 'color:red;',
                        'title' => 'Hapus folder'
                    ]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-3">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
    </div>


    <!-- Arsip search & table -->
    <?php
    $query = \app\models\Arsip::find()->where(['folder_id' => $parentId]);
    if (!empty($searchKeyword)) {
        $query->andWhere(['like', 'judul', $searchKeyword]);
    }

    $arsipDataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => ['pageSize' => 10],
        'sort' => ['defaultOrder' => ['uploaded_at' => SORT_DESC]],
    ]);
    ?>

    <?php if ($parentId): ?>
        <div class="row mt-4 mb-2">
            <div class="col-md-6">
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['index', 'parent' => $parentId],
                    'options' => ['class' => 'form-inline'],
                ]); ?>
                <div class="input-group">
                    <input type="text" name="q" value="<?= Html::encode($searchKeyword) ?>" class="form-control" placeholder="Cari arsip...">
                    <button type="submit" class="btn btn-outline-primary">🔍 Cari</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($arsipDataProvider->getCount() > 0): ?>
        <?= GridView::widget([
            'dataProvider' => $arsipDataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-striped table-sm'],
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'label' => 'Ikon',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $ext = strtolower(pathinfo($model->file_path, PATHINFO_EXTENSION));

                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                            $icon = 'img-icon.png';
                        } elseif ($ext === 'pdf') {
                            $icon = 'pdf-icon.png';
                        } else {
                            $icon = 'file-icon.png';
                        }

                        return Html::img(Yii::getAlias('@web/image/' . $icon), [
                            'alt' => strtoupper($ext),
                            'style' => 'width:24px;',
                        ]);
                    },
                    'contentOptions' => ['style' => 'text-align:center; width:50px;'],
                ],


                [
                    'attribute' => 'judul',
                    'label' => 'Judul',
                ],

                [
                    'attribute' => 'uploaded_at',
                    'format' => ['datetime', 'php:d M Y H:i'],
                    'label' => 'Tanggal Upload',
                ],

                [
                    'label' => 'Aksi',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:200px;'],
                    'value' => function ($model) {
                        return Html::beginTag('div', ['class' => 'btn-group btn-group-sm']) .
                            Html::a('📄', Yii::getAlias('@web/' . $model->file_path), [
                                'class' => 'btn btn-outline-primary',
                                'target' => '_blank',
                                'title' => 'Lihat'
                            ]) .
                            Html::a('✏️', ['arsip/update', 'id' => $model->id], [
                                'class' => 'btn btn-outline-warning',
                                'title' => 'Edit'
                            ]) .
                            Html::a('🗑️', ['arsip/delete', 'id' => $model->id], [
                                'class' => 'btn btn-outline-danger',
                                'data-confirm' => 'Yakin ingin menghapus arsip ini?',
                                'data-method' => 'post',
                                'title' => 'Hapus'
                            ]) .
                            Html::endTag('div');
                    }
                ],
            ]
        ]) ?>
    <?php elseif ($parentId): ?>
        <div class="alert alert-info mt-3">Belum ada arsip dalam folder ini.</div>
    <?php endif; ?>
</div>
