<?php

namespace app\modules\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class UsersController extends \yii\rest\ActiveController
{
    public $modelClass = '\app\models\User';
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
			'except' => ['options','signup', 'login','profile-picture','custom-accounts'],
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],
		];
		$behaviors['verbs'] = [
			'class' => VerbFilter::className(),
			'actions' => [
				'login' => ['post'],
				'signup' => ['post'],
				'changepassword' => ['post'],
				'profileupdate' => ['post'],
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
	
	
	
	public function actionLogin()
    {
         
		/*$data = array('status'=>'error','message'=>\Yii::t('app','{field1} is required',array('field1'=>\Yii::t('app','Login Scenario'))));
		\Yii::$app->response->format = 'json';
		return $data;*/
		
		$post = \Yii::$app->request->post();
		
		if(!isset($post['email']) || empty($post['email']))
		{
			$data = array('status'=>'error','message'=>'Email is required');
			\Yii::$app->response->format = 'json';
			return $data;
		}
		
		if(!isset($post['password']) || empty($post['password']))
		{
			$data = array('status'=>'error','message'=>'Password is required');
			\Yii::$app->response->format = 'json';
			return $data;
		}

		$email = $post['email'];
		$password = $post['password'];
		$model = \app\models\User::findOne(["email" => $email]);
		if (empty($model)) {
			$data = array('status'=>'error','message'=>\Yii::t('app','Authentication Failed'));
			\Yii::$app->response->format = 'json';
			return $data;
		}
		if ($model->validatePassword($password)) {
			if(empty($model->whoseme_token)) {
				$model->whoseme_token = \Yii::$app->getSecurity()->generateRandomString();
			}
			$model->updated_at = \Yii::$app->formatter->asTimestamp(date_create());
			$model->save();
			$data = array('status'=>'success', 'data'=>['user'=>$model->apiData, 'userDetails'=>$model->userDetails->apiData]);
			\Yii::$app->response->format = 'json';
			return $data;
		} else {
			$data = array('status'=>'error','message'=>\Yii::t('app','Email Address or Password is not correct!'));
			\Yii::$app->response->format = 'json';
			return $data;
		}
    }
	
	public function actionChangePassword()
	{	
		$model = \Yii::$app->user->identity;
		if(isset($model))
		{
			$post = \Yii::$app->request->post();
			if(!isset($post['old_password']) || empty($post['old_password']))
			{
				$data = array('status'=>'error','message'=>\Yii::t('app','{field1} is required',array('field1'=>\Yii::t('app','old_password'))));
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			$old_password = $post['old_password'];
			if ($model->validatePassword($old_password)) 
			{
				if(!isset($post['new_password']) || empty($post['new_password']))
				{
					$data = array('status'=>'error','message'=>\Yii::t('app','{field1} is required',array('field1'=>\Yii::t('app','New Password'))));
					\Yii::$app->response->format = 'json';
					return $data;
				
				}
				if(!isset($post['password_repeat']) || empty($post['password_repeat']))
				{
					$data = array('status'=>'error','message'=>\Yii::t('app','{field1} is required',array('field1'=>\Yii::t('app','Password Repeat'))));
					\Yii::$app->response->format = 'json';
					return $data;
				
				}
				$new_password = $post['new_password'];
				$password_repeat = $post['password_repeat'];
				if($new_password == $password_repeat)
				{
					$model->setPassword($new_password);
					if($model->save())
					{
						$data = array('status'=>'success','message'=>\Yii::t('app','Password Updated Successfully'));
						\Yii::$app->response->format = 'json';
						return $data;
					}
				} else {
					$data = array('status'=>'error','message'=>\Yii::t('app','Password Not Match'));
					\Yii::$app->response->format = 'json';
					return $data;
				}
			} else {
				$data = array('status'=>'error','message'=>\Yii::t('app','Current Password is not correct'));
				\Yii::$app->response->format = 'json';
				return $data;
				
			}
		}
	}
}
