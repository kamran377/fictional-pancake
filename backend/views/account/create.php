<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = 'Create Account';
$this->params['heading'] = 'Create Account';
$this->params['description'] = 'Enter the account details and press Create';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</div>
