<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\i18n\Formatter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
//    /**
//     * {@inheritdoc}
//     */
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = (new \backend\models\Settings())->getSettings('admin_count_page_users');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        
        if (!isset($model->auth_key)) {
            $model->auth_key = Yii::$app->security->generateRandomString();
        }

        if ($model->load(Yii::$app->request->post())) {
            
//            print_r($model); exit();
            
            if ($model->password_hash == '' OR $model->password_hash == null OR is_null($model->password_hash)) {
                $model->password_hash = (new Query())->select(['password_hash'])->from('user')->where(['id' => $model->id])->limit(1)->one()['password_hash'];
            } else {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            }
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
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
                $model->password_hash = (new Query())->select(['password_hash'])->from('user')->where(['id' => $model->id])->limit(1)->one()['password_hash'];
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
     * Deletes an existing User model.
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
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    public function actionAddBalance ()
    {
        if (is_numeric(Yii::$app->request->post('value')) AND Yii::$app->request->post('value') > 0 AND Yii::$app->request->post('action') == 'add-balance')
        {
            if (Yii::$app->request->isAjax)
            {
                $comment = Yii::$app->request->post('comment');
                if ($comment == ''): $comment = '-1'; endif;
                
                $old_balance = (new Query())->select(['balance'])->from('user')->where(['id' => Yii::$app->request->post('id')])->limit(1)->one()['balance'];
                $new_balance = $old_balance + Yii::$app->request->post('value');
                Yii::$app->db->createCommand()->update('user', ['balance' => $new_balance], 'id = ' . Yii::$app->request->post('id'))->execute();

                $old_total_payed = (new Query())->select(['total_balance_plus'])->from('user')->where(['id' => Yii::$app->request->post('id')])->limit(1)->one()['total_balance_plus'];
                $new_total_payed = $old_total_payed + Yii::$app->request->post('value');
                Yii::$app->db->createCommand()->update('user', ['total_balance_plus' => $new_total_payed], 'id = ' . Yii::$app->request->post('id'))->execute();

                Yii::$app->db->createCommand()->insert('messages', [
                    'user_id' => Yii::$app->request->post('id'),
                    'admin' => 'ERROR!!!!!!!',
                    'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                    'text' => 'ВАШ БАЛАНС ПОПОЛНЕН НА '.Yii::$app->request->post('value').' ГРН!',
                ])->execute();

                Yii::$app->db->createCommand()->insert('transaction', [
                    'user_id' => Yii::$app->request->post('id'),
                    'math_op' => '+',
                    'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                    'value' => Yii::$app->request->post('value'),
                    'order_id' => '-1',
                    'admin_comment' => '-1',
                    'comment_for_user' => $comment,
                    'admin' => Yii::$app->admin->identity->username,
                ])->execute();

                echo 1;
            }
        } else {
            echo -1;
        }
    }
    
    
    public function actionMinusBalance ()
    {
        if (is_numeric(Yii::$app->request->post('value')) AND Yii::$app->request->post('value') > 0 AND Yii::$app->request->post('action') == 'minus-balance')
        {
            if (Yii::$app->request->isAjax)
            {
                $comment = Yii::$app->request->post('comment');
                if ($comment == ''): $comment = '-1'; endif;
                
                $old_balance = (new Query())->select(['balance'])->from('user')->where(['id' => Yii::$app->request->post('id')])->limit(1)->one()['balance'];
                $new_balance = $old_balance - Yii::$app->request->post('value');
                Yii::$app->db->createCommand()->update('user', ['balance' => $new_balance], 'id = ' . Yii::$app->request->post('id'))->execute();
               
                Yii::$app->db->createCommand()->insert('messages', [
                    'user_id' => Yii::$app->request->post('id'),
                    'admin' => 'ERROR!!!!!!!',
                    'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                    'text' => 'С ВАШЕГО БАЛАНСА БЫЛО СНЯТО '.Yii::$app->request->post('value').' ГРН!',
                ])->execute();

                Yii::$app->db->createCommand()->insert('transaction', [
                    'user_id' => Yii::$app->request->post('id'),
                    'math_op' => '-',
                    'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                    'value' => Yii::$app->request->post('value'),
                    'order_id' => '-1',
                    'admin_comment' => '-1',
                    'comment_for_user' => $comment,
                    'admin' => Yii::$app->admin->identity->username,
                ])->execute();

                echo 1;
            }
        } else {
            echo -1;
        }
    }
}
