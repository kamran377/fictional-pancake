<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php if (count($model->getErrors()) > 0): ?>
        <div class="callout callout-danger">
            <?= $form->errorSummary($model); ?>
        </div>
    <?php endif; ?>
	
    <?= $form->field($detailsModel, 'first_name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($detailsModel, 'last_name')->textInput(['maxlength' => true]) ?>

	
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord) { ?>
		<?= $form->field($model, 'password_hash')->passwordInput(['value'=>'']) ?>
	<?php } ?>

	<?=$form->field($model, 'role')->dropDownList(
			yii\helpers\ArrayHelper::map([['id'=>'admin', 'name'=>'Administrator'],['id'=>'user', 'name'=>'Field Staff']], 'id', 'name'), 
			['prompt' => \Yii::t('app','--- Select Access Level ---')]
		);
	?>
	
    <div class="form-group  pull-right">
        <?= Html::a('<i class="fa fa-undo"></i> Cancel', ['index'], ['class' => 'btn btn-default btn-lg']) ?>
		&nbsp;&nbsp;
		<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Create' : '<i class="fa fa-save"></i> Update', ['class' =>'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
