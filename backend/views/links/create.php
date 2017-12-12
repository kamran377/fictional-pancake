<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Link */

$this->title = 'Create Link';
$this->params['heading'] = 'Create Link';
$this->params['description'] = 'Enter the link details and press Create';
$this->params['breadcrumbs'][] = ['label' => 'Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
	<div class="panel-body">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</div>
