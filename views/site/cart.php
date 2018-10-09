<?php

/* @var $this yii\web\View */
/* @var $model app\models\Product */

?>
<div class="cart-detail js-detail" id-product="<?= $model->id ?>">
  <div class="row">
    <div class="col-12 col-sm-4 col-md-5">
      <img class="cart-img border-lgray p-10 js-detail-img" src="<?= $model->img ?>">
    </div><!--/.col-->
    <div class="col-12 col-sm-8 col-md-7">
      <!-- <a class="btn btn-yell bold js-prevent" href="#"><i class="fas fa-rocket"></i> БЫСТРЫЙ ЗАКАЗ</a> -->
      <div class="row justify-content-between">
        <div class="col-12 col-lg-auto">
          <h3 class="itext em-12 bold js-detail-label"><?= $model->label ?></h3>
          <p class="itext">
            Цвет: <span class="js-detail-color"><?= $model->desc ?></span>
            <br>
            <?= $model->category->desc ?>
          </p>
          <p class="itext bold color-green"><i class="fas fa-check"></i> В наличии</p>
        </div><!--/.col-->
        <div class="col-12 col-lg-auto">
          <h3 class="itext em-12 bold js-detail-label">Цена одной футболки</h3>
          <p class="cart-price text-left mb-0">
            <?= $model->category->from_price ?> <i class="cart-rub fas fa-ruble-sign em-9"></i>
            &nbsp;
            <span class="cart-price-old color-gray">
              <?= $model->category->oldPrice ?> <i class="cart-rub fas fa-ruble-sign em-9"></i>
            </span>
          </p>
          <p class="text color-red">
            Ваша экономия
            <span class="bold"><?= $model->category->priceDiff ?></span>
            <i class="cart-rub fas fa-ruble-sign em-9"></i>
          </p>
        </div><!--/.col-->
      </div><!--/.row-->
      <?= $model->category->size->group ?>
      <div class="d-flex align-items-center justify-content-between">
        <div class="counter js-counter">
          <span class="counter-btn js-counter-btn" data="-1">
            <i class="fas fa-minus"></i>
          </span>
          <input class="counter-input js-counter-input" type="text" value="50">
          <span class="counter-btn js-counter-btn" data="1">
            <i class="fas fa-plus"></i>
          </span>
        </div>
        <p class="cart-price">
          <span class="js-detail-total" data="<?= $model->category->from_price ?>"><?= (int) $model->category->from_price * 50 ?></span> <i class="cart-rub fas fa-ruble-sign em-9"></i>
        </p>
      </div>
      <p class="itext text-right"><?= $model->category->parent->part_count ?></p>
      <a class="btn btn-red w-md-50 ml-auto js-add-btn" href="#"><i class="fas fa-shopping-cart"></i> В КОРЗИНУ</a>
      <p class="itext">Доставка до транспортной компании от 200 штук - бесплатно</p>
      <?php if ($model->category->size_table): ?>
        <img class="img-fluid mb-15" src="<?= $model->category->size_table ?>">
      <?php endif ?>
    </div><!--/.col-->
  </div><!--/.row-->
</div><!--/.container-->