<?php
namespace app\modules\controllers;

use yii\rest\ActiveController;
use app\models\Links;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class LinksController extends ActiveController
{
    public $modelClass = 'app\models\Links';
	
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
			$role = \Yii::$app->util->getRole();
			$auth = \Yii::$app->authManager;
			$permissions = $auth->getPermissionsByRole($role->name);
			$_ps = [];
			foreach($permissions as $p) 
			{
				$_ps[] = $p->name;
				//$menuItem = \app\models\MenuItems::find()->byPermission($p->name);
			}
			$parentLinks = \app\models\Links::find()->where(['permission' => $_ps])->andWhere(['is','parent_id',null])->orderBy(['order'=>SORT_ASC])->all();
			$returnData = [];
			foreach($parentLinks as $plink) 
			{
				$obj = new \stdClass;
				$obj = $plink->apiData;
				//$obj->childLinks = [];
				$childLinks = \app\models\Links::find()->where(['permission' => $_ps,'parent_id'=>$plink->id])->orderBy(['order'=>SORT_ASC])->all();
				foreach($childLinks as $clink) 
				{
					$obj->childLinks[] = $clink->apiData;
				}
				$returnData[] = $obj;
			}

			$data = array('status'=>'success', 'data'=>['links'=>$returnData]);
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
	
	public function actionDeleteLinks(){
        $model = \Yii::$app->user->identity;
		if(isset($model))
		{
			$post = \Yii::$app->request->post();
			if(!isset($post['id']))
			{
				$data = array('status'=>'error','message'=> 'Links ID is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			$id = $post['id'];
			$id =  \Yii::$app->util->decrypt($id);
			$Links = Links::findOne($id);
			$Links->updated_by = $model->id;
			$Links->updated_time = date('Y-m-d H:i:s');
			$Links->status = 0;
			$Links->save();
			$data = array('status'=>'success','message'=>'Links Deleted successfully!');
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
			
			$models = Links::find()->selectList();
			$Linkss = [];
			if(isset($models) && count($models) > 0) 
			{
				foreach($models as $model) 
				{
					$Linkss[] = $model->apiData;
				}
			}
			$data = array('status'=>'success','data'=>['Linkss'=>$Linkss]);
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
				$data = array('status'=>'error','message'=> 'Links Name is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			
			if(!isset($post['number']) || empty($post['number']))
			{
				$data = array('status'=>'error','message'=> 'Links Number is required');
				\Yii::$app->response->format = 'json';
				return $data;
			
			}
			$name = $post['name'];
			$number = $post['number'];
			if(isset($post['id']) && !empty($post['id']))
			{
				$id = $post['id'];
				$id = \Yii::$app->util->decrypt($id);
				$Links = Links::findOne($id);
				$Links->updated_by = $model->id;
				$Links->updated_time = date('Y-m-d H:i:s');
			} 
			else
			{
				$Links = new Links;
				$Links->created_by = $model->id;
				$Links->creation_time = date('Y-m-d H:i:s');
			}
			$Links->name = $name;
			$Links->number = $number;
			if($Links->save())
			{
				$data = array('status'=>'success');
				\Yii::$app->response->format = 'json';
				return $data;	
			}
			else
			{
				$data = array('status'=>'error','error'=>$Links->getErrors());
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