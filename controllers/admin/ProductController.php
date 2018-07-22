<?php

namespace app\controllers\admin;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\NotFoundHttpException;

class ProductController extends BaseController
{

  // public function behaviors()
  // {
  //   return [
  //     'verbs' => [
  //       'class' => VerbFilter::class,
  //       'actions' => [
  //         'delete' => ['POST'],
  //       ],
  //     ],
  //   ];
  // }

  public function actionIndex()
  {
    $searchModel = new ProductSearch();
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
    $model = new Product();
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      // return $this->redirect(['view', 'id' => $model->id]);
      return $this->redirect(['index']);
    }
    return $this->render('create', ['model' => $model]);
  }

  public function actionCopy($id=null)
  {
    if (Yii::$app->request->isPost) {
      $model = new Product();
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['index']);
      }
    }
    $model = $this->findModel($id);
    return $this->render('create', ['model' => $model]);
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

  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  protected function findModel($id)
  {
    if (($model = Product::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
