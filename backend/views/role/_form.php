<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly'=> !$model->isNewRecord]) ?>

    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group text-right">
        <?= Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn  btn-default  btn-lg']) ?>
		<?= Html::submitButton('<i class="fa fa-save"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary  btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
