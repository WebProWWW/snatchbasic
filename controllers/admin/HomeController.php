<?php

namespace app\controllers\admin;

use Yii;
use app\models\LoginForm;

class HomeController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
      if (!Yii::$app->user->isGuest) {
        return $this->redirect(['index']);
      }
      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post()) && $model->login()) {
        return $this->goBack();
      }
      $model->password = '';
      return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
      Yii::$app->user->logout();
      return $this->redirect(['index']);
    }
}
