<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use Yii;

class RbacRedirectController extends Controller
{
    public function actionIndex()
    {
        // Bisa juga redirect:
        // return $this->redirect(['rbac-ui/index']);

        throw new ForbiddenHttpException('Akses ke /admin langsung tidak diizinkan.');
    }
}
