<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Role */


$this->title = 'Update Role Permissions: ' . $model->name;
$this->params['heading'] = 'Update Role Permissions: ' . $model->name;
$this->params['description'] = 'Select and unselect the permissions and click update';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Update Role Permissions';
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_permission', [
			'model' => $model,
			'allPermissions' => $allPermissions,
			'checkedPermissions' => $checkedPermissions
		]) ?>
	</div>
</div>
