<?php

namespace backend\controllers;

use Yii;
use backend\models\Order;
use backend\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
//            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDeleteProduct ()
    {
        if (Yii::$app->request->isAjax)
        {
            $buf = explode('^^', Yii::$app->request->post('id'));
            $num = $buf[0];
            $id = $buf[1];
            
            $products = (new Query())
                            ->select(['products'])
                            ->from('order')
                            ->where(['id' => $id])
                            ->limit(1)
                            ->one()['products'];
            
            $products = json_decode($products, true);
            
            $new_products = [];
            $new_total_price = 0;
            
            foreach ($products as $key => $value) {
                if ($key != $num) {
                    $new_products[$key] = $value;
                    $new_total_price += $value['price'] * $value['count'];
                }
            }
            $new_products['total_price'] = round($new_total_price, 2);
            
            $products = json_encode($new_products);
            
            Yii::$app->db->createCommand()->update('order', ['products' => $products], 'id = ' . $id)->execute();

            echo 1;
        }
    }
    
    public function actionPay ()
    {
        if (Yii::$app->request->isAjax)
        {
            $buf = explode('^^', Yii::$app->request->post('id'));
            $num = $buf[0];
            $id = $buf[1];
            $val = Yii::$app->request->post('value');
            
            $products = (new Query())
                            ->select(['products'])
                            ->from('order')
                            ->where(['id' => $id])
                            ->limit(1)
                            ->one()['products'];
            
            $products = json_decode($products, true);
            
            $new_products = [];
            
            foreach ($products as $key => $value) {
                if ($key != $num) {
                    $new_products[$key] = $value;
                }
                else
                {
                    $old_pay = $value['payed'];
                    $new_products[$key] = $value;
                    $new_products[$key]['payed'] = $val;
                }
            }
            
            $products = json_encode($new_products);
            
            Yii::$app->db->createCommand()->update('order', ['products' => $products], 'id = ' . $id)->execute();
            
            $old_pay = $old_pay;
            $new_pay = $val;
            
            if ($old_pay > $new_pay) {
                $different = $old_pay - $new_pay;
                
                $user = (new Query())
                            ->select(['user_id'])
                            ->from('order')
                            ->where(['id' => $id])
                            ->limit(1)
                            ->one()['user_id'];
                
                
                
                Yii::$app->db->createCommand()->insert('transaction', [
                'user_id' => $user,
                'math_op' => '+',
                'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                'value' => $different,
                'order_id' => $id,
                'admin_comment' => '-1',
                'comment_for_user' => '-1',
                ])->execute();
                
                Yii::$app->db->createCommand()->insert('messages', [
                    'user_id' => $user,
                    'admin' => 0,
                    'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                    'text' => 'ВАШ БАЛАНС ПОПОЛНЕН НА ' . $different . ' грн!',
                ])->execute();
                
                
                $old_balance = (new Query())
                                ->select(['balance'])
                                ->from('user')
                                ->where(['id' => $user])
                                ->limit(1)
                                ->one()['balance'];
                
                $new_balance = $old_balance + $different;
                
                Yii::$app->db->createCommand()->update('user', [
                    'balance' => $new_balance,
                ], 'id = ' . $user)->execute();
            }
            
            if ($old_pay < $new_pay) {
                
                $different = $new_pay - $old_pay;
                
                $user = (new Query())
                            ->select(['user_id'])
                            ->from('order')
                            ->where(['id' => $id])
                            ->limit(1)
                            ->one()['user_id'];
                
                
                
                Yii::$app->db->createCommand()->insert('transaction', [
                'user_id' => $user,
                'math_op' => '-',
                'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                'value' => $different,
                'order_id' => $id,
                'admin_comment' => '-1',
                'comment_for_user' => '-1',
                ])->execute();
                
                Yii::$app->db->createCommand()->insert('messages', [
                    'user_id' => $user,
                    'admin' => 0,
                    'date' => Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s'),
                    'text' => 'С ВАШЕГО БАЛАНСА СНЯТО ' . $different . ' грн!',
                ])->execute();
                
                
                $old_balance = (new Query())
                                ->select(['balance'])
                                ->from('user')
                                ->where(['id' => $user])
                                ->limit(1)
                                ->one()['balance'];
                
                $new_balance = $old_balance - $different;
                
                Yii::$app->db->createCommand()->update('user', [
                    'balance' => $new_balance,
                ], 'id = ' . $user)->execute();
            }

            echo 1;
        }
    }
    
    public function actionCount ()
    {
        if (Yii::$app->request->isAjax)
        {
            $buf = explode('^^', Yii::$app->request->post('id'));
            $num = $buf[0];
            $id = $buf[1];
            $val = Yii::$app->request->post('value');
            
            $products = (new Query())
                            ->select(['products'])
                            ->from('order')
                            ->where(['id' => $id])
                            ->limit(1)
                            ->one()['products'];
            
            $products = json_decode($products, true);
            
            $new_products = [];
            $new_total_price = 0;
            
            foreach ($products as $key => $value) {
                if ($key != $num) {
                    $new_products[$key] = $value;
                    $new_total_price += $value['price'] * $value['count'];
                }
                else
                {
                    $new_products[$key] = $value;
                    $new_products[$key]['count'] = $val;
                    $new_total_price += $value['price'] * $val;
                }
            }
            $new_products['total_price'] = round($new_total_price, 2);
            
            $products = json_encode($new_products);
            
            Yii::$app->db->createCommand()->update('order', ['products' => $products], 'id = ' . $id)->execute();

            echo 1;
        }
    }
    
    public function actionDost ()
    {
        if (Yii::$app->request->isAjax)
        {
            $id = Yii::$app->request->post('id');
            $val = Yii::$app->request->post('value');
            
            $products = (new Query())
                            ->select(['products'])
                            ->from('order')
                            ->where(['id' => $id])
                            ->limit(1)
                            ->one()['products'];
            
            $products = json_decode($products, true);
            
            $new_products = [];
            $new_total_price = 0;
            
            foreach ($products as $key => $value) {
                $new_products[$key] = $value;
                $new_total_price += $value['price'] * $value['count'];
            }
            $new_products['dostavka_val'] = intval($val);
            
            $new_products['total_price'] = round($new_total_price, 2);
            $new_products['total_price'] = $new_products['total_price'] + $val;
            
            $products = json_encode($new_products);
            
//            echo $products;
            
            Yii::$app->db->createCommand()->update('order', ['products' => $products], 'id = ' . $id)->execute();

            echo 1;
        }
    }
}