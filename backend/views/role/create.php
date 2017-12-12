<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Create User Role';
$this->params['heading'] = 'Create User Role';
$this->params['description'] = 'Enter the user role details and press Create';
$this->params['breadcrumbs'][] = ['label' => 'User Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
	<div class="panel-body">
			<?= $this->render('_form', [
				'model' => $model,
		]) ?>
	</div>
</div>
