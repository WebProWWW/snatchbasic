<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Size */

$this->title = 'Новая группа';
$this->params['breadcrumbs'][] = ['label' => 'Размеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="size-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
