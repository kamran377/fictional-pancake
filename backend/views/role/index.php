<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['heading'] = 'User Roles';
$this->params['description'] = 'Here you can view and manage user roles';
$this->title = 'User Roles';
$this->params['breadcrumbs'][] = $this->params['heading'];
?>
<div class="panel panel-default">
	<div class="panel-body">
		<p>
			<?= Html::a('<i class="fa fa-plus"></i> Create Role', ['create'], ['class' => 'btn btn-primary  btn-lg']) ?>
		</p>
		<?php Pjax::begin(); ?>    
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					'name',
					'description:ntext',
					[
						'class' => 'yii\grid\ActionColumn',
						'template'=>'{edit} {permission} ',
						'buttons'=>[
							'edit' => function ($url, $model) {
								return Html::a('<i class="fa fa-pencil"></i>', $url, [
									'title' => Yii::t('app', 'Edit'),
									'data-pjax'=>'0',
								]);
							},
							'permission' => function ($url, $model) {
								return Html::a('<i class="fa fa-toggle-off"></i>', $url, [
									'title' => Yii::t('app', 'Permission'),
									'data-pjax'=>'0',
								]);
							},
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'edit') {
								$url = Url::to(['/role/update', 'id'=>Yii::$app->util->encrypt($model->name)]); 
								return $url;
							}
							if ($action === 'permission') {
								$url = Url::to(['/role/permissions', 'id'=>Yii::$app->util->encrypt($model->name)]); 
								return $url;
							}
							
						}
					],
				],
			]); ?>
		<?php Pjax::end(); ?>
	</div>
</div>
