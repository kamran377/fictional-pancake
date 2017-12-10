<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Account */



$this->title = 'Assign Account to  User: ' . $model->userDetails->name;
$this->params['heading'] = $this->title;
$this->params['description'] = 'Assign accounts to this user and press update';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Assign Accounts to User';
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_assignAccounts', [
			'model' => $model,
		]) ?>
	</div>
</div>
