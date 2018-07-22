<?php

namespace app\controllers\admin;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BaseController extends Controller
{
  public $layout = 'admin';

  // function __construct ($id, $module, $config = []) {
  //   parent::__construct($id, $module, $config);
  //   var_dump($module->components);
  //   exit;
  // }

  public function init()
  {
    parent::init();
    Yii::$app->user->loginUrl = ['/admin/home/login'];
  }

  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        // 'only' => ['logout'],
        'rules' => [
          [
            // 'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
          [
            'actions' => ['login'],
            'allow' => true,
            'roles' => ['?'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
          'delete' => ['post'],
        ],
      ],
    ];
  }
}
