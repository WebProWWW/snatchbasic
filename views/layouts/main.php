<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\models\Category;
use yii\helpers\BaseStringHelper;

$parentCategories = Category::getParentCategories();
$urlBase = Url::base(true);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?= Html::csrfMetaTags() ?>
  <title>Snatch Basic - <?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?= $urlBase ?>/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= $urlBase ?>/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= $urlBase ?>/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $urlBase ?>/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= $urlBase ?>/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= $urlBase ?>/apple-touch-icon-152x152.png">
  <link rel="icon" type="image/png" href="<?= $urlBase ?>/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="<?= $urlBase ?>/favicon-16x16.png" sizes="16x16">
  <meta name="application-name" content="Stantch Basic">
  <meta name="msapplication-TileColor" content="#FFFFFF">
  <meta name="msapplication-TileImage" content="<?= $urlBase ?>/mstile-144x144.png">

  <?php if (!YII_ENV_DEV): ?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-W3JGB3W');</script>
  <!-- End Google Tag Manager -->
  <?php endif ?>

</head>
<body>

<?php if (!YII_ENV_DEV): ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3JGB3W"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif ?>

<?php $this->beginBody() ?>

<header class="header">
  <div class="container">
    <div class="row justify-content-between align-items-center">

      <div class="col-6 col-sm-4 col-md-auto order-sm-1">
        <a class="logo" href="<?= Url::home() ?>">
          <img class="logo-img" width="200" src="/img/logo-black.png" alt="футболки оптом">
        </a>
      </div><!--/.col-->

      <div class="col-auto order-sm-3 order-md-4 order-lg-5">
        <a class="btn btn-bars js-popup-menu" href="#popup-menu"><i class="fas fa-bars"></i></a>
      </div><!--/.col-->

      <div class="col-12 col-md-auto order-sm-5 order-md-3">
        <a class="btn btn-yell js-popup-cart" href="javascript:;">
          <i class="fas fa-shopping-cart"></i>
          Корзина
          <span class="btn-items d-none js-store-count"></span>
        </a>
      </div><!--/.col-->

      <div class="col-12 col-sm-4 col-md-auto order-sm-4 order-md-5 order-lg-4 d-none d-lg-block">
        <a class="btn btn-yell" data-fancybox href="#popup-price"><i class="far fa-file-pdf"></i> Заказать прайс</a>
      </div><!--/.col-->

      <div class="col-12 col-sm-4 col-md-auto order-sm-2 mb-15 text-center">
        <a class="ln ln-black d-block mb-5" href="mailto:opt@snatchgroup.ru">
          <i class="fa fa-envelope fa-fw" aria-hidden="true"></i>&nbsp;opt@snatchgroup.ru
        </a>
        <a class="ln ln-black" href="tel:+74956415647">
          <i class="fa fa-phone fa-fw" aria-hidden="true"></i>&nbsp;<span class="bold em-12">8&nbsp;(495)&nbsp;641&nbsp;56&nbsp;47</span>
        </a>
      </div><!--/.col-->

    </div><!--/.row-->

    <nav class="nav d-none d-md-block">
      <div class="row no-gutters justify-content-between">
        <div class="col-auto">
          <a class="nav-ln" href="<?= Url::home() ?>">Главная</a>
        </div><!--/.col-->
        <?php foreach ($parentCategories as $category): ?>
          <div class="col-auto">
            <a class="nav-ln" href="<?= Url::to([
              'site/category',
              'cat_alias' => $category->alias
            ]) ?>"><?= $category->label ?></a>
          </div><!--/.col-->
        <?php endforeach ?>
        <div class="col-auto">
          <a class="nav-ln" href="<?= Url::to(['site/page', 'view'=>'pechat']) ?>">Печать</a>
        </div><!--/.col-->
        <div class="col-auto">
          <a class="nav-ln" href="<?= Url::to(['site/page', 'view'=>'dostavka']) ?>">Доставка</a>
        </div><!--/.col-->
        <div class="col-auto">
          <a class="nav-ln" href="<?= Url::to(['site/page', 'view'=>'o-nas']) ?>">О Нас</a>
        </div><!--/.col-->
        <div class="col-auto">
          <a class="nav-ln" href="<?= Url::to(['site/page', 'view'=>'kontakty']) ?>">Контакты</a>
        </div><!--/.col-->
      </div><!--/.row-->
    </nav>

  </div><!--/.container-->
</header>

<div class="cart-fixed js-showonscroll">
  <a class="ln-white js-popup-cart" href="#popup-cart">
    <i class="fas fa-shopping-cart em-12"></i>
    Корзина
    <span class="btn-items d-none js-store-count"></span>
  </a>
</div>

<?= $content ?>

<section>
  <?php if (!YII_ENV_DEV): ?>
    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aae34014bd93d5c22c2e0058543591612244d7347f80f7102cf3a9ce077b98e2b&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=false"></script>
  <?php endif ?>
</section><!--/.section-->

<footer class="footer">
  <div class="container">
    <div class="row justify-content-between">

      <div class="col-12 col-lg-4">
        <div class="row">
          <div class="col-6 col-sm-auto col-lg">
            <a class="logo" href="<?= Url::home() ?>">
              <img class="logo-img" width="160" src="/img/logo-white.png" alt="ФУТБОЛКИ ОПТОМ">
            </a>
          </div><!--/.col-->
          <div class="col-6 col-sm-auto col-lg">
            <a target="_blank" href="http://snatchgroup.ru/">
              <img class="logo-img mb-15" width="105" src="/img/logo-sng.png" alt="ПРОИЗВОДСТВО И ПОШИВ КЕПОК">
            </a>
          </div><!--/.col-->
        </div><!--/.row-->
        <p class="em-lg-9 w-sm-50 w-lg-100">Оптовое производство и продажа трикотажа. Футболки, худи, свитшоты и бомберы оптом.</p>
      </div><!--/.col-->

      <div class="col-12 col-sm-6 col-lg-4 mt-30 mt-lg-0">
        <div class="row">
          <div class="col">
            <nav class="fnav">
              <p class="fnav-title">ПРОДУКЦИЯ</p>
              <?php foreach ($parentCategories as $category): ?>
                <a class="fnav-ln" href="<?= Url::to([
                  'site/category',
                  'cat_alias' => $category->alias
                ]) ?>"><?= $category->label ?></a>
              <?php endforeach ?>
              <a class="fnav-ln" href="<?= Url::to(['site/page', 'view'=>'pechat']) ?>">Печать</a>
            </nav>
          </div><!--/.col-->
          <div class="col">
            <nav class="fnav">
              <p class="fnav-title">ИНФОРМАЦИЯ</p>
              <a class="fnav-ln" href="<?= Url::to(['site/page', 'view'=>'dostavka']) ?>">Доставка</a>
              <a class="fnav-ln" href="<?= Url::to(['site/page', 'view'=>'o-nas']) ?>">О Нас</a>
              <a class="fnav-ln" href="<?= Url::to(['site/page', 'view'=>'kontakty']) ?>">Контакты</a>
            </nav>
          </div><!--/.col-->
        </div><!--/.row-->
      </div><!--/.col-->

      <div class="col-12 col-sm-6 col-lg-auto">
        <div class="text-center text-sm-right mt-30 mt-lg-0">
          <div class="mb-5">
            <a class="ln ln-white" href="mailto:opt@snatchgroup.ru">
              <i class="fa fa-envelope fa-fw" aria-hidden="true"></i>&nbsp;opt@snatchgroup.ru
            </a>
          </div>
          <div class="mb-15">
            <a class="ln ln-white" href="tel:+74956415647">
              <i class="fa fa-phone fa-fw" aria-hidden="true"></i>&nbsp;<span class="bold em-12">8&nbsp;(495)&nbsp;641&nbsp;56&nbsp;47</span>
            </a>
          </div>
          <p class="em-sm-9">
            117303,&nbsp;г.&nbsp;Москва,<br>
            ул.&nbsp;Большая&nbsp;Юшуньская&nbsp;д.1А&nbsp;к.4,<br>
            ТЦ&nbsp;Севастопольский, 16 этаж<br>
          </p>
        </div>
      </div><!--/.col-->

      <div class="col-12 mt-30">
        <p class="em-8 text-center">ФОТО И ВИДЕОМАТЕРИАЛЫ НА САЙТЕ <a class="ln-white" href="http://snatchbasic.ru/">WWW.SNATCHBASIC.RU</a> ПРИНАДЛЕЖАТ ВЛАДЕЛЬЦУ ДОМЕННОГО ИМЕНИ.<br>КОПИРОВАНИЕ МАТЕРИАЛОВ C САЙТА ВОЗМОЖНО ТОЛЬКО ПОСЛЕ ПИСЬМЕННОГО СОГЛАСИЯ ПРАВООБЛАДАТЕЛЕЙ.</p>
        <p class="em-8 text-center">&copy; ООО «СНЭЧ ГРУПП».<br>Все данные, представленные на сайте, носят сугубо информационный характер и не являются исчерпывающими. Для более подробной информации следует обращаться к менеджерам компании по указанным на сайте телефонам. Вся представленная на сайте информация, касающаяся комплектации, технических характеристик, цветовых сочетаний, а также стоимости продукции, носит информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями пункта 2 статьи 437 Гражданского Кодекса Российской Федерации.</p>
      </div><!--/.col-->

    </div><!--/.row-->
  </div><!--/.container-->
</footer>



<!-- MODALS -->
<div class="d-none">


<!-- КОРЗИНА -->
<div class="popup-cart" id="popup-cart">
  <div class="js-popup-cart-items"></div>
  <div class="row">
    <div class="col-12 col-sm-6">
      <button data-fancybox-close class="btn btn-yell">
        <i class="fas fa-shopping-cart"></i> Продолжить покупку
      </button>
    </div><!--/.col-->
    <div class="col-12 col-sm-6">
      <a class="btn btn-red js-popup-order" href="javascript:;">
        <i class="fas fa-truck"></i> Оформить заказ
      </a>
    </div><!--/.col-->
  </div><!--/.row-->
</div>




<!-- ОФОРМИТЬ ЗАКАЗ -->
<div class="popup-400" id="popup-order">
  <p class="itext em-12 bold">Оформление заказа</p>
  <?= Html::beginForm(null, 'post', [
    'class' => 'form mt-20 js-form-order',
  ]) ?>
    <div class="js-form-order-items"></div>
    <input class="form-input" type="text" name="name" placeholder="Имя" validate="text">
    <input class="form-input js-mask" mask="+7-999-999-99-99" type="text" name="phone" placeholder="Телефон" validate="text">
    <input class="form-input" type="text" name="email" placeholder="Email" validate="email">
    <button class="btn btn-yell form-btn js-form-progress" type="submit">Отправить</button>
  <?= Html::endForm() ?>
</div>




<!-- КОРЗИНА ПУСТАЯ -->
<div id="popup-cart-empty">
  <p class="itext em-12 text-center mt-15">
    <i class="fas fa-info-circle em-13"></i> Ваша корзина пустая
  </p>
</div>


<!-- МЕНЮ -->
<div id="popup-menu">
  <button data-fancybox-close class="popup-menu-close">
    <i class="fas fa-times"></i>
  </button>
  <?php foreach ($parentCategories as $category): ?>
    <a class="popup-menu-item" href="<?= Url::to([
      'site/category',
      'cat_alias' => $category->alias
    ]) ?>"><?= $category->label ?></a>
  <?php endforeach ?>
  <a class="popup-menu-item" href="<?= Url::to(['site/page', 'view'=>'pechat']) ?>">Печать</a>
  <a class="popup-menu-item" href="<?= Url::to(['site/page', 'view'=>'dostavka']) ?>">Доставка</a>
  <a class="popup-menu-item" href="<?= Url::to(['site/page', 'view'=>'o-nas']) ?>">О Нас</a>
  <a class="popup-menu-item" href="<?= Url::to(['site/page', 'view'=>'kontakty']) ?>">Контакты</a>
</div>

<!-- ЗАКАЗАТЬ ПРАЙС -->
<div class="popup-400" id="popup-price">
  <p class="itext em-12 bold">Заказать прайс</p>
  <?= Html::beginForm(null, 'post', [
    'class' => 'form mt-20 js-form-callback',
  ]) ?>
    <input class="form-input" type="text" name="name" placeholder="Имя" validate="text">
    <input class="form-input" type="text" name="email" placeholder="Email" validate="email">
    <input class="form-input js-mask" mask="+7-999-999-99-99" type="text" name="phone" placeholder="Телефон" validate="text">
    <button class="btn btn-yell form-btn js-form-progress" type="submit">Отправить</button>
  <?= Html::endForm() ?>
</div>

<!-- AJAX INFO -->
<div id="js-form-success">
  <p class="itext text-center">
    <span class="bold">Ваша заявка успешно оформлена.</span><br>
    Ближайшее время наш менеджер позвонит Вам<br>и ответит на вопросы.<br>
    <span class="bold">Благодарим вас за обращение!</span>
  </p>
</div>
<div id="js-form-error">
  <p class="text-center itext">
    <span class="bold color-red">Произошла ошибка!</span><br>
    Пожалуйста, попробуйте повторить.<br>
    Если хотите ускорить процесс, позвоните<br>
    по телефону прямо сейчас:<br>
    <a class="ln ln-black bold em-12" href="tel:+74956415647">
      8&nbsp;(495)&nbsp;641&nbsp;56&nbsp;47
    </a><br>
    <span class="bold">Благодарим вас за обращение!</span>
  </p>
</div>


</div><!--/.d-none-->
<!-- /MODALS -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
