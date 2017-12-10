<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>
		<?php 
			$accounts = ArrayHelper::map(\app\models\Account::find()->active(), 'id', 'name');
			echo	$form->field($model, 'accountIds')->widget(Select2::classname(), [
				'data' => $accounts,
				'options' => [
					'placeholder' => 'Select Accounts',
				],
				'language' => 'en',
				'pluginOptions' => [
					'allowClear' => true,
					'multiple'=>true,
					'tags'=>false,
				],
				'pluginEvents' => [
					"change" => "function() {  }",
				],
			]);
		?>

		<div class="form-group  pull-right">
			<?= Html::a('<i class="fa fa-undo"></i> Cancel', ['index'], ['class' => 'btn btn-default btn-lg']) ?>
			&nbsp;&nbsp;
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Create' : '<i class="fa fa-save"></i> Update', ['class' =>'btn btn-primary btn-lg']) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
