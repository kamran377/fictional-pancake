<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Permission */

$this->title = 'Update Permission: ' . $model->name;
$this->params['heading'] = 'Update  Permission: ' . $model->name;
$this->params['description'] = 'Update the Permission  details and press Update';
$this->params['breadcrumbs'][] = ['label' => ' Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="permission-update">

    <section class="card">
		<header class="card-header">
			<h3><?= Html::encode($this->title) ?></h3>
		</header>
		<div class="card-block">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</section>
</div>
