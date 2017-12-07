<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

		<div class="form-group  pull-right">
			<?= Html::a('<i class="fa fa-undo"></i> Cancel', ['index'], ['class' => 'btn btn-default btn-lg']) ?>
			&nbsp;&nbsp;
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Create' : '<i class="fa fa-save"></i> Update', ['class' =>'btn btn-primary btn-lg']) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
