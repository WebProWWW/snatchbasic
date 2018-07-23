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
use RetailCrm\ApiClient;
use RetailCrm\Exception\CurlException;


class ApiController extends Controller
{

  // public $enableCsrfValidation = false;

  public function behaviors()
  {
    return [
      // 'corsFilter' => [
      //   'class' => Cors::class,
      //   'cors' => [
      //     'Origin' => ['http://localhost.loc'],
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
        // ],
        'formats' => [
          'application/json' => Response::FORMAT_JSON,
        ],
      ],
    ];
  }




  public function actionOrder()
  {
    $outData = ['status'=>0];
    $request = Yii::$app->request;
    // if (!$request->isPost) return $outData;

    $name = $request->post('name', '');
    $email = $request->post('email', '');
    $phone = $request->post('phone', '');
    $orderArr = $request->post('order', []);
    $items = [];
    foreach ($orderArr as $order) {
      array_push($items, [
        'initialPrice' => $order['price'],
        'quantity' => $order['count'],
        'productName' => $order['label'],
        'properties' => [
          ['name'=> 'Размер', 'value'=> $order['size']],
          ['name'=> 'Изображение', 'value'=> 'http://snatchbasic.ru'.$order['img']],
        ],
      ]);
    }
    sleep(2);
    if ($this->crmOrder($name, $phone, $email, 'Купить', $items)) {
      $outData['status'] = 1;
    }
    return $outData;
  }




  public function actionMailPrice()
  {
    $outData = ['status'=>0];
    $request = Yii::$app->request;
    if (!$request->isPost) return $outData;
    $name = $request->post('name', '');
    $email = $request->post('email', '');
    $phone = $request->post('phone', '');
    sleep(2);
    if ($this->crmOrder($name, $phone, $email, 'Отправить прайс', [])) {
      $outData['status'] = 1;
    }
    return $outData;
  }




  private function crmOrder($name, $phone, $email, $formType, $items)
  {
    $params = Yii::$app->params;
    $crmApiKey = $params['crmApiKey'];
    $crmApiUrl = $params['crmApiUrl'];
    $client = new ApiClient($crmApiUrl, $crmApiKey, ApiClient::V5, 'snatchbasic');
    try {
      $response = $client->request->ordersCreate([
        'firstName' => $name,
        // 'lastName' => '',
        'phone' => $phone,
        'email' => $email,
        'customFields' => [
          'form_type' => $formType,
        ],
        'items' => $items,
      ]);
    } catch (CurlException $e) {
      $outData['status'] = $e->getMessage();
      return false;
    }
    if ($response->isSuccessful() && 201 === $response->getStatusCode()) return true;
    return false;
  }


}
