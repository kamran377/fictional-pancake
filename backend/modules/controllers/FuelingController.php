<?php
namespace app\modules\controllers;

use yii\rest\ActiveController;
use app\models\Fueling;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class FuelingController extends ActiveController
{
    public $modelClass = 'app\models\Fueling';
	
	
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$auth = $behaviors['authenticator'];
		unset($behaviors['authenticator']);
		 // add CORS filter
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
		];
    
		// re-add authentication filter
		$behaviors['authenticator'] = $auth;
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
    
		$behaviors['authenticator'] = [
			'class' => CompositeAuth::className(),
			'except' => ['options'],
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],
		];
		
		return $behaviors;
	}
	public function actions() 
	{
		$actions = parent::actions();
		$actions['options'] = [
			'class' => '\yii\rest\OptionsAction',
		];
		return $actions;
	}

	public function actionDeleteFueling(){
        $model = \Yii::$app->user->identity;
		if(isset($model))
		{
			$post = \Yii::$app->request->post();
			if(!isset($post['id']))
			{
				$data = array('status'=>'error','message'=> 'Fueling ID is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			$id = $post['id'];
			$id =  \Yii::$app->util->decrypt($id);
			$fueling = Fueling::findOne($id);
			$fueling->delete();
			$data = array('status'=>'success','message'=>'Fueling Deleted successfully!');
			\Yii::$app->response->format = 'json';
			return $data;
		}
		else
		{
			$data = array('status'=>'error','error'=>'You are not authorized to perform this action');
			\Yii::$app->response->format = 'json';
			return $data;	
		}
    }
	
    public function actionList(){
        $model = \Yii::$app->user->identity;
		if(isset($model))
		{
			$post = \Yii::$app->request->post();
			if(!isset($post['offset']))
			{
				$data = array('status'=>'error','message'=> 'Offset is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			$offset = $post['offset'];
			$models = Fueling::find()->active($offset);
			$fuelings = [];
			if(isset($models) && count($models) > 0) 
			{
				foreach($models as $model) 
				{
					$fuelings[] = $model->apiData;
				}
			}
			$data = array('status'=>'success','data'=>['fuelings'=>$fuelings]);
			\Yii::$app->response->format = 'json';
			return $data;
		}
		else
		{
			$data = array('status'=>'error','error'=>'You are not authorized to perform this action');
			\Yii::$app->response->format = 'json';
			return $data;	
		}
    }
	
	public function actionSave(){
		$model = \Yii::$app->user->identity;
		if(isset($model))
		{
			$post = \Yii::$app->request->post();
			if(!isset($post['fueling_date']) || empty($post['fueling_date']))
			{
				$data = array('status'=>'error','message'=> 'Fueling Date is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			if(!isset($post['cost']) || empty($post['cost']))
			{
				$data = array('status'=>'error','message'=> 'Fueling Cost is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			if(!isset($post['odometer_reading']) || empty($post['odometer_reading']))
			{
				$data = array('status'=>'error','message'=> 'Odometer Reading is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			if(!isset($post['vehicle_id']) || empty($post['vehicle_id']))
			{
				$data = array('status'=>'error','message'=> 'Vehicle ID is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			if(!isset($post['gallons']) || empty($post['gallons']))
			{
				$data = array('status'=>'error','message'=>'Gallons is required');
				\Yii::$app->response->format = 'json';
				return $data;
			}
			
			$fueling_date = date('Y-m-d H:i:s', strtotime($post['fueling_date']));
			$cost = $post['cost'];
			$odometer_reading = $post['odometer_reading'];
			$vehicle_id = $post['vehicle_id'];
			$gallons = $post['gallons'];
			
			$fueling = new \app\models\Fueling;
			$fueling->created_by = $model->id;
			$fueling->creation_time = date('Y-m-d H:i:s');
			$fueling->fueling_date = $fueling_date;
			$fueling->vehicle_id = \Yii::$app->util->decrypt($vehicle_id);
			$fueling->odometer_reading = $odometer_reading;
			$fueling->cost = $cost;
			$fueling->gallons = $gallons;
			if($fueling->save()){
				$data = array('status'=>'success','message'=>'Fueling added successfully!');
				\Yii::$app->response->format = 'json';
				return $data;
			}
			else
			{
				$data = array('status'=>'error','error'=>$fueling->getErrors());
				\Yii::$app->response->format = 'json';
				return $data;
			}	
		}
		else
		{
			$data = array('status'=>'error','error'=>'You are not authorized to perform this action');
			\Yii::$app->response->format = 'json';
			return $data;	
		}
    }
}