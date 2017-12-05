<?php
namespace app\modules\controllers;

use yii\rest\ActiveController;
use app\models\Vehicle;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class VehicleController extends ActiveController
{
    public $modelClass = 'app\models\Vehicle';
	
	
	
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
			$models = Vehicle::find()->active($offset);
			$vehicles = [];
			if(isset($models) && count($models) > 0) 
			{
				foreach($models as $model) 
				{
					$vehicles[] = $model->apiData;
				}
			}
			$data = array('status'=>'success','data'=>['vehicles'=>$vehicles]);
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
	
	public function actionDeleteVehicle(){
        $model = \Yii::$app->user->identity;
		if(isset($model))
		{
			$post = \Yii::$app->request->post();
			if(!isset($post['id']))
			{
				$data = array('status'=>'error','message'=> 'Vehicle ID is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			$id = $post['id'];
			$id =  \Yii::$app->util->decrypt($id);
			$vehicle = Vehicle::findOne($id);
			$vehicle->updated_by = $model->id;
			$vehicle->updated_time = date('Y-m-d H:i:s');
			$vehicle->status = 0;
			$vehicle->save();
			$data = array('status'=>'success','message'=>'Vehicle Deleted successfully!');
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
	
	public function actionSelectList(){
        $model = \Yii::$app->user->identity;
		if(isset($model))
		{
			
			$models = Vehicle::find()->selectList();
			$vehicles = [];
			if(isset($models) && count($models) > 0) 
			{
				foreach($models as $model) 
				{
					$vehicles[] = $model->apiData;
				}
			}
			$data = array('status'=>'success','data'=>['vehicles'=>$vehicles]);
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
			if(!isset($post['name']) || empty($post['name']))
			{
				$data = array('status'=>'error','message'=> 'Vehicle Name is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			if(!isset($post['number']) || empty($post['number']))
			{
				$data = array('status'=>'error','message'=> 'Vehicle Number is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			$name = $post['name'];
			$number = $post['number'];
			if(isset($post['id']) && !empty($post['id']))
			{
				$id = $post['id'];
				$id = \Yii::$app->util->decrypt($id);
				$vehicle = Vehicle::findOne($id);
				$vehicle->updated_by = $model->id;
				$vehicle->updated_time = date('Y-m-d H:i:s');
			} 
			else
			{
				$vehicle = new Vehicle;
				$vehicle->created_by = $model->id;
				$vehicle->creation_time = date('Y-m-d H:i:s');
			}
			$vehicle->name = $name;
			$vehicle->number = $number;
			if($vehicle->save())
			{
				$data = array('status'=>'success');
				\Yii::$app->response->format = 'json';
				return $data;	
			}
			else
			{
				$data = array('status'=>'error','error'=>$vehicle->getErrors());
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