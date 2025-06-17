<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\User;

class RbacUiController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index','assignment', 'roles', 'permissions', 'rules', 'assignment-custom', 'assign-role', 'revoke-role'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionAssignment()
    {
        return $this->render('@vendor/mdmsoft/yii2-admin/views/assignment/index', [
            'searchModel' => Yii::createObject('mdm\admin\models\searchs\AssignmentSearch'),
            'dataProvider' => Yii::createObject('mdm\admin\models\searchs\AssignmentSearch')->search(Yii::$app->request->queryParams),
            'usernameField' => 'username',
        ]);
    }

    public function actionRoles()
    {
        return $this->render('@vendor/mdmsoft/yii2-admin/views/role/index');
    }

    public function actionPermissions()
    {
        return $this->render('@vendor/mdmsoft/yii2-admin/views/permission/index');
    }

    public function actionRules()
    {
        return $this->render('@vendor/mdmsoft/yii2-admin/views/rule/index');
    }

    public function actionAssignmentCustom()
    {
        $users = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $users,
            'pagination' => ['pageSize' => 10],
        ]);

        $authManager = Yii::$app->authManager;

        return $this->render('assignment-custom', [
            'dataProvider' => $dataProvider,
            'authManager' => $authManager,
        ]);
    }

    public function actionAssignRole($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        if ($role && !$auth->getAssignment('admin', $id)) {
            $auth->assign($role, $id);
            Yii::$app->session->setFlash('success', "Role 'admin' berhasil di-assign ke user ID $id.");
        }
        return $this->redirect(['assignment-custom']);
    }

    public function actionRevokeRole($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        if ($role && $auth->getAssignment('admin', $id)) {
            $auth->revoke($role, $id);
            Yii::$app->session->setFlash('warning', "Role 'admin' telah dicabut dari user ID $id.");
        }
        return $this->redirect(['assignment-custom']);
    }
}
