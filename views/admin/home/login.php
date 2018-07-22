<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<br><br><br>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

    <div class="panel panel-default">
      <div class="panel-heading">Администратор</div>
      <div class="panel-body">
        <div class="site-login">
          <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
              'template' => "<div>{input} {label}</div><div>{error}</div>",
            ]) ?>

            <div class="form-group">
              <?= Html::submitButton('Войти', ['class' => 'btn btn-default pull-right', 'name' => 'login-button']) ?>
            </div>

          <?php ActiveForm::end(); ?>

        </div>
      </div>
    </div>

  </div><!--/.col-->
</div><!--/.row-->