<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>
<h1 class="text-center">CMS</h1>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
        Каталог
        <span class="glyphicon glyphicon-shopping-cart pull-right"></span>
      </div>
      <ul class="list-group">
        <li class="list-group-item">
          <a href="<?= Url::to(['admin/category/index']) ?>">Категории</a>
        </li>
        <li class="list-group-item">
          <a href="<?= Url::to(['admin/product/index']) ?>">Товары</a>
        </li>
        <li class="list-group-item">
          <a href="<?= Url::to(['admin/size/index']) ?>">Размеры</a>
        </li>
      </ul>
    </div>

  </div><!--/.col-->
</div><!--/.row-->