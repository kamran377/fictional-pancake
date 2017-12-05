<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FuelingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['heading'] = 'Fuel Service';
$this->params['description'] = 'Here you can view fuel services added by the field staff';
$this->title = 'Fuel Service';
$this->params['breadcrumbs'][] = $this->params['heading'];
?>
<div class="panel panel-default">
	<div class="panel-body">
		
		<?php Pjax::begin(['id'=>'Fuelings-pjax','clientOptions' => ['method' => 'POST']]); ?>    
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					[
						'attribute'=>'fueling_date',
						'format' => ['date', 'php:m/d/Y'],
						'filter'=>  DatePicker::widget([
							'name' => 'fueling_date', 
							'model' =>$searchModel,
							'attribute'=>'fueling_date',
							'value'=>'fueling_date',
							//'value' => date('d-M-Y', strtotime('+2 days')),
							'options' => ['placeholder' => 'Select fuelingdate ...'],
									'pluginOptions' => [
										'format' => 'mm/dd/yyyy',
										'todayHighlight' => true,
										'autoclose'=>true
									]
						]),
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search fuelings ...'
						]
					],
					[
						'attribute'=>'cost',
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search fuelings ...'
						]
					],
					[
						'attribute'=>'odometer_reading',
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search fuelings ...'
						]
					],
					[
						'attribute'=>'vehicle_id',
						'value' =>'vehicle.name',
						'filter' => \yii\helpers\ArrayHelper::map(\app\models\Vehicle::find()->all(), 'id', 'name'),
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search fuelings ...'
						]
					],
					[
						'attribute'=>'gallons',
						'filterInputOptions' => [
							'class'       => 'form-control',
							'placeholder' => 'Type in some characters to search fuelings ...'
						]
					],

					[
						'class' => 'yii\grid\ActionColumn',
						'template'=>'{delete}',
						'buttons'=>[
							'edit' => function ($url, $model) {
								return Html::a('<i class="fa fa-pencil-square-o"></i> ', $url, [
											'title' => Yii::t('app', 'Edit'),
								]);
							},
							'delete' => function ($url, $model) {
								$message = \Yii::t('app','Are you sure you want to delete the selected fueling?');
							
								return Html::a('<i class="fa fa-times"></i> ', $url, [
									'title' => Yii::t('app', 'Delete'),
									'onclick' => "
										if (confirm('$message')) {
											$.ajax('$url', {
												type: 'POST'
											}).done(function(data) {
												$.pjax.reload({container: '#Fuelings-pjax'});
											});
										}
										return false;
									",
								]);
							}
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'edit') {
								$url = Url::to(['fueling/update','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
							if ($action === 'delete') {
								$url = Url::to(['fueling/delete','id'=>Yii::$app->util->encrypt($model->id)]); // your own url generation logic
								return $url;
							}
							
						}
					],
				],
			]); ?>
		<?php Pjax::end(); ?>
	</div>
</div>
