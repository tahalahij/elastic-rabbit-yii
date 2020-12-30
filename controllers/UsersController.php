<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;
use app\models\UserForm;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = Users::find()->all();
        return $this->render('index',[
            'users' => $users
        ]);
    }


    public function actionUserForm()
    {
        $model = new UserForm;

        if( $model->load(Yii::$app->request->post()) && $model->validate() )
        {
            Yii::$app->session->setFlash('success', 'You have enterd data correctly');
        }

        return $this->render('userForm', ['model' => $model]);
    }
}
