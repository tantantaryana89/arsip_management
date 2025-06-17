<?php

namespace app\controllers;

use Yii;
use app\models\Arsip;
use app\models\ArsipSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ArsipController implements the CRUD actions for Arsip model.
 */
class ArsipController extends Controller
{
    /**
     * @inheritDoc
     */
   public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
                [
                    'verbs' => [
                        'class' => VerbFilter::class,
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                    'access' => [
                        'class' => AccessControl::class,
                        'only' => ['index', 'view', 'create', 'update', 'delete'],
                        'rules' => [
                            [
                                'allow' => true,
                                'actions' => ['index', 'view'],
                                'roles' => ['arsipView'],
                            ],
                            [
                                'allow' => true,
                                'actions' => ['create'],
                                'roles' => ['arsipCreate'],
                            ],
                            [
                                'allow' => true,
                                'actions' => ['update'],
                                'roles' => ['arsipUpdate'],
                            ],
                            [
                                'allow' => true,
                                'actions' => ['delete'],
                                'roles' => ['arsipDelete'],
                            ],
                        ],
                    ],
                ]
            );
    }


    public function actionIndex()
    {
        $searchModel = new ArsipSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($folder_id = null)
    {
        $model = new Arsip();
        $model->folder_id = $folder_id;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->upload_file = UploadedFile::getInstance($model, 'upload_file');

            if ($model->save()) {
                return $this->redirect(['folder/index', 'parent' => $folder_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $uploadedFile = UploadedFile::getInstance($model, 'upload_file');

                if ($uploadedFile) {
                    if ($model->file_path && file_exists($model->file_path)) {
                        unlink($model->file_path);
                    }

                    $filename = 'uploads/arsip/' . time() . '_' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                    $uploadedFile->saveAs($filename);
                    $model->file_path = $filename;
                }

                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Arsip::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
