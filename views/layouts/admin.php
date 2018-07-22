<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title>CMS::<?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<style>
		.action-column {
			white-space: nowrap;
			font-size: 1.2em;
			user-select: none;
			cursor: pointer;
		}
	</style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

<?php if (!Yii::$app->user->isGuest): ?>

	<?php
	NavBar::begin([
		'brandLabel' => 'CMS',
		'brandUrl' => Url::to(['admin/home/index']),
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => [
			[
				'label' => 'Каталог',
				'items' => [
					[
						'label' => 'Категории',
						'url' => ['admin/category/index'],
					],
					[
						'label' => 'Товары',
						'url' => ['admin/product/index'],
					],
					[
						'label' => 'Размеры',
						'url' => ['admin/size/index'],
					],
				],
			],

			'<li>'
				. Html::beginForm(['/admin/home/logout'], 'post')
				. Html::submitButton('<span class="glyphicon glyphicon-off"></span> Выйти', ['class' => 'btn btn-link logout'])
				. Html::endForm()
			.'</li>'
		],
	]);
	NavBar::end();
	?>

<?php endif ?>

	<div class="container">
		<?= Breadcrumbs::widget([
			'homeLink' => [
				'label' => '<span class="glyphicon glyphicon-home"></span>',
				'url' => Url::to(['admin/home/index']),
				'encode' => false,
			],
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>

</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; WebPRO <?= date('Y') ?></p>
		<p class="pull-right"><?= Yii::powered() ?></p>
	</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>