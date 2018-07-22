<?php

use app\models\Category;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $currentCategory app\models\Category */

?>
<h3 class="itext bold em-12">КАТАЛОГ</h3>
<div class="side">
<?php foreach (Category::getParentCategories() as $category): ?>
  <h4 class="side-title text-upper"><?= $category->label ?></h4>
  <nav class="side-nav">
    <?php foreach ($category->childs as $child): ?>
      <?php $active = ($currentCategory->alias === $child->alias) ? 'active' : ''; ?>
      <a class="side-ln <?= $active ?>" href="<?= Url::to([
        'site/product',
        'cat_parent_alias' => $category->alias,
        'cat_alias' => $child->alias,
      ]) ?>">
        <span class="side-icon"><i class="fas fa-genderless"></i></span>
        <span><?= Html::decode($child->label) ?></span>
      </a>
    <?php endforeach ?>
  </nav>
<?php endforeach ?>
</div><!--/.side-->