<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $category app\models\Category */

$this->title = $category->label;

?>
<section class="section bg-gray">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 d-none d-lg-block">
        <?= $this->render('-catalog-menu', ['currentCategory' => $category]) ?>
      </div><!--/.col-->
      <div class="col-lg-9">

        <?= $category->desc ?>

        <div class="row align-items-stretch pb-30">
        <?php foreach ($category->childs as $catChild): ?>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="cart">
              <img class="cart-img" src="<?= $catChild->img ?>">
              <h4 class="cart-title"><?= $catChild->label ?></h4>
              <p class="cart-desc"><?= $catChild->desc ?></p>
              <p class="cart-price">
                от <span class="cart-price-old"><?= $catChild->oldPrice ?></span>
                <?= $catChild->from_price ?>
                <i class="cart-rub fas fa-ruble-sign"></i>
              </p>
              <a class="btn btn-yell bold" href="<?= Url::to([
                'site/product',
                'cat_parent_alias' => $category->alias,
                'cat_alias' => $catChild->alias,
              ]) ?>">КАТАЛОГ</a>
            </div><!--/.cart-->
          </div><!--/.col-->
        <?php endforeach ?>
        </div><!--/.row-->

      </div><!--/.col-->
    </div><!--/.row-->
  </div><!--/.container-->
</section><!--/.section-->