<?php

/* @var $this yii\web\View */
/* @var $models app\models\Product */

$this->title = 'Оформить заказ'

?>

<section class="section">
  <div class="container">

    <p class="title text-left">Оформление заказа</p>

    <div class="popup-cart-item">
      <div class="row align-items-center">
        <div class="col-3">
          <img class="img-fluid" src="#{product.img}">
        </div><!--/.col-->
        <div class="col-7 col-sm">
          <div class="row">
            <div class="col-12 mb-10">
              <div class="em-10 bold">#{product.label}</div>
            </div><!--/.col-->
            <div class="col-12 mb-10">
              <div class="em-10">
                <span class="bold">Размер:</span> #{product.size}
              </div>
            </div><!--/.col-->
            <div class="col-12 mb-10">
              <div class="em-10"><span class="bold">Количество:</span> #{product.count} шт</div>
            </div><!--/.col-->
            <div class="col-12 col-sm-auto">
              <div class="em-10 bold">
                Сумма: <span>#{product.count * product.price}</span> <i class="fas fa-ruble-sign"></i>
              </div>
            </div><!--/.col-->
          </div><!--/.row-->
        </div><!--/.col-->
        <div class="col-auto">
          <div class="color-red em-11 em-sm-15 js-cart-item-remove" id-product="#{product.id}">
            <i class="fas fa-trash-alt"></i>
          </div>
        </div><!--/.col-->
      </div><!--/.row-->
    </div><!--/.popup-cart-item-->

    <div class="em-12 bold text-right mb-15">
      Итого: #{totalPrice} <i class="fas fa-ruble-sign"></i>
    </div>

  </div><!--/.container-->
</section><!--/.section-->
