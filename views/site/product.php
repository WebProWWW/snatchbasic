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

        <?= $category->parent->desc ?>

        <div class="row align-items-stretch pb-30">
        <?php foreach ($category->products as $product): ?>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="cart">
              <img class="cart-img" src="<?= $product->img ?>">
              <h4 class="cart-title"><?= $product->label ?></h4>
              <p class="cart-desc">
                Цвет: <?= $product->desc ?>
                <br>
                <?= $category->desc ?>
              </p>
              <p class="cart-price">
                <?= $category->from_price ?> <i class="cart-rub fas fa-ruble-sign"></i>
              </p>
              <a
                class="btn btn-yell bold js-product-btn"
                href="<?= Url::to([
                  'site/cart',
                  'cat_parent_alias' => $category->parent->alias,
                  'cat_alias' => $category->alias,
                  'id' => $product->id,
                ])  ?>">ЗАКАЗАТЬ</a>
            </div><!--/.cart-->
          </div><!--/.col-->
        <?php endforeach ?>
        </div><!--/.row-->

      </div><!--/.col-->
    </div><!--/.row-->
  </div><!--/.container-->
</section><!--/.section-->