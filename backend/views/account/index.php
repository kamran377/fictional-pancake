<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['heading'] = 'Accounts';
$this->params['description'] = 'Here you can manage Accounts used thoughout the system';
$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
	<div class="panel-body">
		<p>
			<?= Html::a('<i class="fa fa-plus"></i> Add Account', ['create'], ['class' => 'btn btn-primary']) ?>
		</p>
		<?php Pjax::begin(['id'=>'Accounts-pjax','clientOptions' => ['method' => 'POST']]); ?>    
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					[
						'attribute'=>'name',
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search vehicles ...'
						]
					],
					
					[
						'class' => 'yii\grid\ActionColumn',
						'template'=>'{edit} {delete}',
						'buttons'=>[
							'edit' => function ($url, $model) {
								return Html::a('<i class="fa fa-pencil-square-o"></i> ', $url, [
											'title' => Yii::t('app', 'Edit'),
								]);
							},
							'delete' => function ($url, $model) {
								$message = \Yii::t('app','Are you sure you want to delete the selected account?');
							
								return Html::a('<i class="fa fa-times"></i> ', $url, [
									'title' => Yii::t('app', 'Delete'),
									'onclick' => "
										if (confirm('$message')) {
											$.ajax('$url', {
												type: 'POST'
											}).done(function(data) {
												$.pjax.reload({container: '#Accounts-pjax'});
											});
										}
										return false;
									",
								]);
							}
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'edit') {
								$url = Url::to(['account/update','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
							if ($action === 'delete') {
								$url = Url::to(['account/delete','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
							
						}
					],
				],
			]); ?>
		<?php Pjax::end(); ?>
	</div>
</div>