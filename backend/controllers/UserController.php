<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\UserDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update','delete'],
                        'allow' => true,
						'roles' => ['admin']
                    ],
                    
                ],
            ],
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
		$detailsModel = new UserDetails();
		if ($model->isNewRecord === true) {
            $model->created_at = time();
			$model->updated_at = time();
        }
		$transaction = \Yii::$app->db->beginTransaction();
        if ($model->load(Yii::$app->request->post())) {
			$role = $model->role;
			$password = $model->password_hash;
			$model->setPassword($password);
			$model->generateAuthKey();
			$model->username = trim($model->email);
			$model->email = trim($model->email);
			if($model->save()) {
				$dbRole = \Yii::$app->authManager->getRole($role);
				\Yii::$app->authManager->assign($dbRole, $model->id);
                $detailsModel->load(Yii::$app->request->post());
				$detailsModel->user_id = $model->id;
				if($detailsModel->save())
				{
					$transaction->commit();
					Yii::$app->session->setFlash('success', Yii::t('app',"User created successfully!"));
					return $this->redirect(['index']);
				}
			} 
			else {
				return $this->render('create', [
					'model' => $model,
					'detailsModel' => $detailsModel,
				]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
                'detailsModel' => $detailsModel,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $id = Yii::$app->util->decrypt($id);
		$model = $this->findModel($id);
        $detailsModel = $model->userDetails;
        $role=$model->getRole();
        $model->role = $role;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dbRole = \Yii::$app->authManager->getRole($role);
            \Yii::$app->authManager->revoke($dbRole, $model->id);
            $dbRole = \Yii::$app->authManager->getRole($model->role);
            \Yii::$app->authManager->assign($dbRole, $model->id);
            $detailsModel->load(Yii::$app->request->post());
			$detailsModel->save();
            \Yii::$app->session->setFlash('success', Yii::t('app',"User updated successfully!"));
			return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'detailsModel' => $detailsModel,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
