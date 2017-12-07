<?php
namespace app\modules\controllers;

use yii\rest\ActiveController;
use app\models\Account;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class AccountController extends ActiveController
{
    public $modelClass = 'app\models\Account';
	
	
	
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

    
	
	public function actionSelectList(){
        $model = \Yii::$app->user->identity;
		if(isset($model))
		{
			
			$models = Account::find()->selectList();
			$accounts = [];
			if(isset($models) && count($models) > 0) 
			{
				foreach($models as $model) 
				{
					$accounts[] = $model->apiData;
				}
			}
			$data = array('status'=>'success','data'=>['accounts'=>$accounts]);
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
	
}