<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Account */



$this->title = 'Update Account: ' . $model->name;
$this->params['heading'] = 'Update Account: ' . $model->name;
$this->params['description'] = 'Update the account details and press Update';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</div>
