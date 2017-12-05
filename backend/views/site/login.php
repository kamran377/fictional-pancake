<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::$app->name . ' | Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
		<div class="login-panel panel panel-default">
			<div class="userpic"><img src="/backend/web/img/default_profile.png" alt="" ></div>
			<div class="panel-body">
				<h2 class="text-center">Please Sign In</h2>
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
					<fieldset>
						<?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Email']) ?>

						<?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password']) ?>

						<?= $form->field($model, 'rememberMe')->checkbox() ?>
						<br/>
						<div class="form-group">
							<?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
						</div>
					</fieldset>
					
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
				
