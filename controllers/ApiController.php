<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ViewNotFoundException;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;


class ApiController extends Controller
{

  // public $enableCsrfValidation = false;

  public function behaviors()
  {
    return [
      // 'corsFilter' => [
      //   'class' => Cors::class,
      //   'cors' => [
      //     'Origin' => ['http://training.loc'],
      //     'Access-Control-Request-Method' => ['POST', 'GET'],
      //     'Access-Control-Allow-Credentials' => true,
      //     'Access-Control-Max-Age' => 3600,
      //   ],
      // ],
      // 'verbs' => [
      //   'class' => VerbFilter::class,
      //   'actions' => [
      //     '*' => ['post'],
      //   ],
      // ],
      'contentNegotiator' => [
        'class' => ContentNegotiator::class,
        // 'only' => [
        //   'test',
        //   'lenta-histori',
        //   'lenta-video',
        //   'lenta-like',
        //   'lenta-dislike',
        //   'lenta-message',
        //   'update',
        //   'delete',
        //   'new',
        //   'lenta-new-job',
        // ],
        'formats' => [
          'application/json' => Response::FORMAT_JSON,
        ],
      ],
    ];
  }

  public function actionMailPrice()
  {
    $outData = ['status'=>0];
    $request = Yii::$app->request;

    $name = $request->post('name', false);
    $email = $request->post('email', false);
    $phone = $request->post('phone', false);

    if ($name && $email && $phone) {
      $outData['status'] = 1;
    }
    sleep(1);
    return $outData;
  }

}
