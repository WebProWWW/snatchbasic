<?php

namespace app\controllers\admin;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
{

  public function actionIndex()
  {
    $searchModel = new CategorySearch();
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
    $model = new Category();
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      // return $this->redirect(['view', 'id' => $model->id]);
      return $this->redirect(['index']);
    }
    return $this->render('create', [
      'model' => $model,
    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      // return $this->redirect(['view', 'id' => $model->id]);
      return $this->redirect(['index']);
    }
    return $this->render('update', ['model' => $model]);
  }

  public function actionCopy($id=null)
  {
    if (Yii::$app->request->isPost) {
      $model = new Category();
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['index']);
      }
    }
    $model = $this->findModel($id);
    return $this->render('create', ['model' => $model]);
  }

  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  protected function findModel($id)
  {
    if (($model = Category::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
