<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<section class="section">
  <div class="container">
    <p class="text-center bold em-20 my-50">
      Страница не найдена<br>
      <span class="em-23">404</span><br>
      <span class="em-25"><i class="far fa-frown"></i></span><br>
      <span class="em-7">Что-то пошло не так</span>
    </p>
    <?php if (YII_ENV_DEV): ?>
      <pre><?php var_dump($message) ?></pre>
    <?php endif ?>
  </div><!--/.container-->
</section><!--/.section-->