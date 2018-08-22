<?php

namespace backend\controllers;

use Yii;
use backend\models\Admin;
use backend\models\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\i18n\Formatter;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    

    public function beforeAction($action)
    {
        if (in_array($action->id, ['index', 'view', 'create', 'delete'])) {
            if (Yii::$app->admin->identity->username != 'admin1' AND Yii::$app->admin->identity->username != 'admin2') {
                return $this->redirect(['/site/index']);
            }
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();
        
        if (!isset($model->auth_key)) {
            $model->auth_key = Yii::$app->security->generateRandomString();
        }
        
        if ($model->created_at == '') {
            $model->created_at = Yii::$app->formatter->asTimestamp('now');
        }
        
        if ($model->updated_at == '') {
            $model->updated_at = Yii::$app->formatter->asTimestamp('now');
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->password_hash == '' OR $model->password_hash == null OR is_null($model->password_hash)) {
                $model->password_hash = (new Query())->select(['password_hash'])->from('admin')->where(['id' => $model->id])->limit(1)->one()['password_hash'];
            } else {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            }
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $model->password_hash = '';

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
//        print_r($model); exit();
        
        
        if ($model->load(Yii::$app->request->post())) {
            
//            print_r($model); exit();
            
            if ($model->password_hash == '' OR $model->password_hash == null OR is_null($model->password_hash)) {
                $model->password_hash = (new Query())->select(['password_hash'])->from('admin')->where(['id' => $model->id])->limit(1)->one()['password_hash'];
            } else {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            }
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        
        
        $model->password_hash = '';

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
