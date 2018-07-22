<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ViewNotFoundException;
use app\models\Category;
use app\models\Product;


class SiteController extends Controller
{
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
    ];
  }

  public function actionPage($view='index')
  {
    try {
      return $this->render($view);
    } catch (ViewNotFoundException $e) {
      throw new NotFoundHttpException($e);
    }
  }

  public function actionCategory($cat_alias)
  {
    if ($category = Category::findByAlias($cat_alias)) {
      try {
        return $this->render('category', [
          'category' => $category,
        ]);
      } catch (ViewNotFoundException $e) {
        throw new NotFoundHttpException($e);
      }
    }
    $this->redirect(['error']);
  }

  public function actionProduct($cat_parent_alias, $cat_alias)
  {
    if ($category = Category::findByAlias($cat_alias)) {
      try {
        return $this->render('product', [
          'category' => $category,
        ]);
      } catch (ViewNotFoundException $e) {
        throw new NotFoundHttpException($e);
      }
    }
    $this->redirect(['error']);
  }

  public function actionCart($id)
  {
    $request = Yii::$app->request;
    if ($request->isAjax) $this->layout = false;
    // $this->enableCsrfValidation = false;
    if (($model = Product::findOne($id)) !== null) {
      return $this->render('cart', ['model'=>$model]);
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
