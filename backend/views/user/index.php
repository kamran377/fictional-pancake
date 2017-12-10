<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modelsUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['heading'] = 'Users';
$this->params['description'] = 'Here you can manage users used thoughout the system';
$this->params['breadcrumbs'][] = $this->params['heading'];
?>
<div class="panel panel-default">
	<div class="panel-body">
		<p>
			<?= Html::a('<i class="fa fa-plus"></i> Add User', ['create'], ['class' => 'btn btn-primary']) ?>
		</p>
		<?php Pjax::begin(['id'=>'Users-pjax','clientOptions' => ['method' => 'POST']]); ?>    
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					[
						'label'=>'name',
						'value' => 'userDetails.name',
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search users ...'
						]
					],
					[
						'attribute'=>'email',
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search users ...'
						]
					],

					[
						'class' => 'yii\grid\ActionColumn',
						'template'=>'{edit}  {assign}',
						'buttons'=>[
							'edit' => function ($url, $model) {
								return Html::a('<i class="fa fa-pencil-square-o"></i> ', $url, [
											'title' => Yii::t('app', 'Edit'),
								]);
							},
							'assign' => function ($url, $model) {
								return Html::a('<i class="fa fa-bank"></i> ', $url, [
											'title' => Yii::t('app', 'Assigned Accounts'),
								]);
							},
							'delete' => function ($url, $model) {
								$message = \Yii::t('app','Are you sure you want to delete the selected user?');
							
								return Html::a('<i class="fa fa-times"></i> ', $url, [
									'title' => Yii::t('app', 'Delete'),
									'onclick' => "
										if (confirm('$message')) {
											$.ajax('$url', {
												type: 'POST'
											}).done(function(data) {
												$.pjax.reload({container: '#Users-pjax'});
											});
										}
										return false;
									",
								]);
							}
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'edit') {
								$url = Url::to(['user/update','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
							if ($action === 'delete') {
								$url = Url::to(['user/delete','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
							if ($action === 'assign') {
								$url = Url::to(['user/assign','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
						}
					],
				],
			]); ?>
		<?php Pjax::end(); ?>
	</div>
</div>
