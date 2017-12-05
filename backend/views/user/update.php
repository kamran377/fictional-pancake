<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */


$this->params['heading'] = 'Update User: ' . $model->userDetails->name;
$this->params['description'] = 'Update the user details and press Update';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->userDetails->name];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_form', [
			'model' => $model,
			'detailsModel' => $detailsModel,  
		]) ?>
	</div>
</div>
