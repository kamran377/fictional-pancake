<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Permission */

$this->title = 'Create Permission';
$this->params['heading'] = 'Create Permission';
$this->params['description'] = 'Enter the permission details and press Create';
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</div>
