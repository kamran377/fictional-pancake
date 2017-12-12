<?php

namespace app\controllers;

use Yii;
use app\models\Role;
use app\models\RoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','update','index','delete','permissions'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
		$searchModel->type= 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
		$model->type = 1;
		$model->created_at = time();
		
        if ($model->load(Yii::$app->request->post())) {
            $auth = \Yii::$app->authManager;
			$name = strtolower($model->name);
			$role = $auth->createRole($name);
			$role->description = $model->description;
			$auth->add($role);
			\Yii::$app->session->setFlash('success', Yii::t('app', "Role created successfully !"));
			return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionPermissions($id) {
		$roleName = Yii::$app->util->decrypt($id);
		$auth = \Yii::$app->authManager;
		$role = $auth->getRole($roleName);
		$model = new Role;
		$model->name = $role->name;;
		$allPermissions = $auth->getPermissions();
		if ($model->load(Yii::$app->request->post())) {
			
			$checkedPermissions = $auth->getPermissionsByRole($roleName);
			$loaded = [];
			$original= [];
			if(isset($checkedPermissions))
			{
				foreach($checkedPermissions as $p1) 
				{
					$original[] = $p1->name;
				}
			}
			$loaded = $model->checkedPermissions;
			$deleted = array_diff($original,$loaded);
			$common = array_intersect($original, $loaded);
			$new = array_diff($loaded, $common);
			if(!empty($deleted)) {
				foreach($deleted as $d)
				{
					$per = $auth->getPermission($d);
					$auth->removeChild($role, $per);
				}
			}
			
			if(!empty($new)) {
				foreach($new as $d)
				{
					$per = $auth->getPermission($d);
					$auth->addChild($role, $per);
				}
			}
		   
			\Yii::$app->session->setFlash('success', Yii::t('app', "Role Permissions updated successfully !"));
			return $this->redirect(['index']);
		   
        } else {
            $checkedPermissions = $auth->getPermissionsByRole($roleName);
			return $this->render('permission', [
                'model' => $model,
				'allPermissions' => $allPermissions,
				'checkedPermissions' => $checkedPermissions
            ]);
        }
	}

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $id = Yii::$app->util->decrypt($id);
		$model = $this->findModel($id);
		$model->updated_at = time();
		if ($model->load(Yii::$app->request->post())) {
            $auth = \Yii::$app->authManager;
			$name = strtolower($model->name);
			$role = $auth->getRole($name);
			$role->description = $model->description;
			$auth->update($name, $role);
			\Yii::$app->session->setFlash('success', Yii::t('app', "Role updated successfully !"));
			return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::find()->where(['name'=> $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
