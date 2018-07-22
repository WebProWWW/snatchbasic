<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Size */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="size-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'label')->textInput() ?>

  <?= $form->field($model, 'group')->textarea(['rows' => 10]) ?>

  <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
