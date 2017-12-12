<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\MenuItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-items-form">

    <?php $form = ActiveForm::begin(); ?>
	<?php
		$allPermissions = \Yii::$app->authManager->getPermissions();
		$pList = [];
		foreach($allPermissions as $p)
		{
			//$pList[] = ['name'=>$p->description, 'id'=>$p->name];
			$pList[$p->name] = $p->name;
		}
	?>	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?=
		$form->field($model, "permission")
			->dropDownList(
				//ArrayHelper::map($pList, 'id', 'name'),           // Flat array ('id'=>'label')
				$pList,
				['prompt'=>'-- Select Permission --','class'=>'form-control',]    // options
			)
	?> 
	
	<?=
		$form->field($model, "parent_id")
			->dropDownList(
				ArrayHelper::map(\app\models\Links::find()->where(['is','parent_id', null])->all(), 'id', 'name'),           // Flat array ('id'=>'label')
				//pList,
				['prompt'=>'-- Select Parent Link --','class'=>'form-control',]    // options
			)
	?> 
    <?= $form->field($model, 'page_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group text-right">
        <?= Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn  btn-default  btn-lg']) ?>
		<?= Html::submitButton('<i class="fa fa-save"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary  btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
