<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Folder;
use app\models\FolderSearch;

class FolderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['folderView'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['folderCreate'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['folderUpdate'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['folderDelete'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($parent = null)
    {
        $searchModel = new FolderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => $parent]);

        $breadcrumbs = [['label' => 'Folder Arsip', 'url' => ['index']]];

        if ($parent !== null) {
            $folder = Folder::findOne($parent);
            if ($folder) {
                $breadcrumbs = array_merge($breadcrumbs, $folder->getBreadcrumbs());
            }
        }

        $this->view->params['breadcrumbs'] = $breadcrumbs;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parentId' => $parent,
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $model = new Folder();
        $model->parent_id = $parent_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'parent' => $parent_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'parent' => $model->parent_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $parent = $model->parent_id;
        $model->delete();
        return $this->redirect(['index', 'parent' => $parent]);
    }

    protected function findModel($id)
    {
        if (($model = Folder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Folder tidak ditemukan.');
    }
}
