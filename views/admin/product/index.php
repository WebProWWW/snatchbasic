<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

  <h3><?= Html::encode($this->title) ?></h3>
  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
    <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      'label',
      'price',
      'img',
      [
        'attribute' => 'category_id',
        'value' => 'category.label',
        'filter' => $searchModel->getListCategories(),
      ],
      'order',

      [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['class'=>'action-column'],
        'template'=>'{view} {update} {delete} {copy}',
        'buttons' => [
          'copy' => function ($url, $model, $key) {
            return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, [
              'title' => 'Скопировать',
            ]);
          },
        ],
      ],
    ],
  ]); ?>
  <?php Pjax::end(); ?>
</div>
