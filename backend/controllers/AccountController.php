<?php

namespace app\controllers;

use Yii;
use app\models\Account;
use app\models\AccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
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
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch();
        $searchModel->status = 1;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
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
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account();
		$model->creation_time = date('Y-m-d H:i:s');
		$model->created_by = \Yii::$app->user->getId();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', Yii::t('app',"Account created successfully!"));
			return $this->redirect(['index']); 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $id = \Yii::$app->util->decrypt($id);
		$model = $this->findModel($id);
		$model->updated_by = \Yii::$app->user->getId();
        $model->updated_time = date('Y-m-d H:i:s');
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success', Yii::t('app',"Account updated successfully!"));
			return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $id = Yii::$app->util->decrypt($id);
		$model = $this->findModel($id);
		$model->updated_by = \Yii::$app->user->getId();
        $model->updated_time = date('Y-m-d H:i:s');
		$model->status = 0;
		$model->save();
		if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
