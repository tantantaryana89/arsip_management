<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\PeminjamanArsip;
use app\models\PeminjamanArsipSearch;

class PeminjamanArsipController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'update-status' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete', 'download-form', 'update-status'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['peminjamanView'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'download-form', 'update-status'],
                        'roles' => ['peminjamanManage'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PeminjamanArsipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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

    public function actionCreate()
    {
        $model = new PeminjamanArsip();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 0;
            $model->tanggal_pinjam = date('Y-m-d');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data peminjaman berhasil disimpan');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan data: ' . json_encode($model->errors));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->status == 1 && empty($model->tanggal_kembali)) {
                $model->tanggal_kembali = date('Y-m-d');
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Data peminjaman berhasil dihapus');
        return $this->redirect(['index']);
    }

    public function actionDownloadForm()
    {
        $file = Yii::getAlias('@webroot/image/form_pinjam_dokumen.pdf');

        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file, 'Formulir-Peminjaman.pdf', [
                'inline' => false,
            ]);
        }

        throw new NotFoundHttpException("File formulir tidak ditemukan.");
    }

    public function actionUpdateStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $status = (int)Yii::$app->request->post('status');

        $model = PeminjamanArsip::findOne($id);
        if (!$model) {
            return ['success' => false, 'message' => 'Data tidak ditemukan'];
        }

        $model->status = $status;
        $model->tanggal_kembali = ($status === 1) ? date('Y-m-d') : null;

        if (!$model->save(false)) {
            return ['success' => false, 'message' => 'Gagal menyimpan perubahan'];
        }

        return [
            'success' => true,
            'tanggal_kembali' => Yii::$app->formatter->asDate($model->tanggal_kembali, 'php:d M Y'),
        ];
    }

    protected function findModel($id)
    {
        if (($model = PeminjamanArsip::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data peminjaman tidak ditemukan.');
    }
}
