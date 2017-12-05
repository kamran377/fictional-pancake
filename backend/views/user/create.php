<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->params['heading'] = 'Create User';
$this->params['description'] = 'Enter the user details and press Create';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create User';
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_form', [
			'model' => $model,
			'detailsModel' => $detailsModel,  
		]) ?>
	</div>
</div>
