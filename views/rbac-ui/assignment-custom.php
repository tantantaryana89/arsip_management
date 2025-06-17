<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\rbac\ManagerInterface $authManager */

$this->title = 'Assignment (Custom)';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'username',
        'email',
        [
            'label' => 'Roles',
            'format' => 'raw',
            'value' => function ($model) use ($authManager) {
                $roles = $authManager->getRolesByUser($model->id);
                return implode(', ', array_keys($roles));
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{assign} {revoke}',
            'buttons' => [
                'assign' => function ($url, $model) {
                    return Html::a('Assign Admin', ['rbac-ui/assign-role', 'id' => $model->id], ['class' => 'btn btn-sm btn-success']);
                },
                'revoke' => function ($url, $model) {
                    return Html::a('Revoke Admin', ['rbac-ui/revoke-role', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger']);
                },
            ],
        ],
    ],
]) ?>
