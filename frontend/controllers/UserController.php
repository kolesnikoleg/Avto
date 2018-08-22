<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use frontend\models\user\Index;
use frontend\models\user\Settings;
use frontend\models\user\Address;
use yii\db\Query;
use frontend\models\PricesList;
use frontend\models\Order;
use yii\data\Pagination;
use frontend\models\Status;
use frontend\models\user\Transaction;
use yii\widgets\LinkPager;
use frontend\models\user\Wishlist;
use frontend\models\user\Messages;

/**
 * Site controller
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $model = new Index();
        
        $date_reg = $model->getDateReg();
        $date_reg = Yii::$app->formatter->asDate($date_reg, 'php:d M Y, H:i');
        
        $skidka = $model->getSkidka();
        
        $balance = $model->getBalance();
        
        $phone = $model->getPhone();
        
        $email_warn = $model->getEmailWarning();
        
        $name = $model->getName();
        
        $address = $model->getAddress();
        
        $total_orders = $model->getMyAllOrdersCount();
        if ($total_orders == 0)
        {
            $total_orders = 'ЗАКАЗОВ НЕТ';
        }
        else
        {
            $total_orders .= ' ШТ';
        }
        
        $date_last_order = $model->getMyLastOrder();
        if ($date_last_order == false)
        {
            $date_last_order = 'ЗАКАЗОВ НЕТ';
        }
        else
        {
            $date_last_order = Yii::$app->formatter->asDate($model->getMyLastOrder(), 'php:d.m.Y, H:i');
        }

        $total_parts = $model->getMyBoughtPartsCount();

        $total_parts_price = $model->getMyBoughtPartsPriceCount();
        
        return $this->render('index', compact('date_reg', 'balance', 'skidka', 'phone', 'email_warn', 'name', 'address', 'total_orders', 'date_last_order', 'total_parts', 'total_parts_price'));
    }
    
    public function actionOrders()
    {
        $query = Order::find()->where(['user_id' => Yii::$app->user->identity->id, 'user_archive' => -1, 'user_delete' => -1])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => (new \frontend\models\Settings())->getPageSizeOrders()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        foreach ($models as $key => &$value)
        {
            if ($value->dostavka == -1) $value->dostavka = 'НЕ УКАЗАН';
            if ($value->client_comment == -1) $value->client_comment = 'НЕ УКАЗАН';
        }

        return $this->render('orders', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
    
    public function actionArchive()
    {
        $query = Order::find()->where(['user_id' => Yii::$app->user->identity->id, 'user_archive' => 2, 'user_delete' => -1])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => (new \frontend\models\Settings())->getPageSizeOrders()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        foreach ($models as $key => &$value)
        {
            if ($value->dostavka == -1) $value->dostavka = 'НЕ УКАЗАН';
            if ($value->client_comment == -1) $value->client_comment = 'НЕ УКАЗАН';
        }
        
//        if (Order::find()->where(['user_id' => Yii::$app->user->identity->id, 'user_archive' => 2, 'user_delete' => -1])->count() === 0)
//            $models = 0;

        return $this->render('archive', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
    
    public function actionTransaction()
    {
        
        $query = Transaction::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('transaction', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
    
    public function actionWishlist()
    {
        $query = Wishlist::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('wishlist', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
    
    public function actionMessages()
    {
        $query = Messages::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('messages', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
    
    public function actionEmailWarn ()
    {
        if (Yii::$app->request->isAjax)
        {
            if (Yii::$app->db->createCommand("UPDATE `user` SET email_warning = '2' WHERE username = '".Yii::$app->user->identity->username."'")->execute())
            {
                echo true;
            }
            else
            {
                echo false;
            }
            
        }
    }
    
    public function actionSettings()
    {
        
        $model = SETTINGS::findOne(['username' => Yii::$app->user->identity->username]);
        if ($model->load(Yii::$app->request->post())) {
            
            $post = Yii::$app->request->post();
            
            if ($model->password_hash != '')
            {
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
                $model->password_confirm = $model->password_hash;
            }
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Настройки успешно сохранены!');
            } else {
                Yii::$app->session->setFlash('error', $model->errors);
            }

            return $this->refresh();
        } else {
            $model->email = $model->emptyEmail;
            $model->city = $model->emptyCity;
            $model->name = $model->emptyName;
            $model->address = $model->emptyAddress;
            $model->comment = $model->emptyComment;
            
            $model->password_hash = '';
            $model->password_confirm = '';
            
            return $this->render('settings', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAddress()
    {
        $model = ADDRESS::findOne(['username' => Yii::$app->user->identity->username]);
        if ($model->load(Yii::$app->request->post())) {
            
            $post = Yii::$app->request->post();
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Новый адрес доставки успешно сохранен!');
            } else {
                Yii::$app->session->setFlash('error', $model->errors);
            }

            return $this->refresh();
        } else {
            $model->address = $model->emptyAddress;
            
            return $this->render('address', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionOrdArc()
    {
        if (Yii::$app->request->isAjax)
        {
//            return json_encode(Yii::$app->request->post());
            if ((new Order())->checkOwnOrder(Yii::$app->request->post('id')))
            {
                $res = Yii::$app->db->createCommand("UPDATE `order` SET `user_archive` = '2' WHERE id = '".Yii::$app->request->post('id')."'")->execute();
                if ($res)
                {
                    Yii::$app->session->setFlash('success', 'Успех! Заказ был успешно отправлен в Архив!');
                    echo json_encode([true]);
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Ошибка! Заказ НЕ был отправлен в Архив!');
                    echo json_encode([true]);
                }
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Ошибка! Заказ НЕ был отправлен в Архив!');
                echo json_encode([true]);
            }
        }
    }
    
    public function actionOrdDel()
    {
        if (Yii::$app->request->isAjax)
        {
//            return json_encode(Yii::$app->request->post());
            if ((new Order())->checkOwnOrder(Yii::$app->request->post('id')))
            {
                $res = Yii::$app->db->createCommand("UPDATE `order` SET `user_delete` = '2' WHERE id = '".Yii::$app->request->post('id')."'")->execute();
                if ($res)
                {
                    Yii::$app->session->setFlash('success', 'Успех! Заказ был успешно удален!');
                    echo json_encode([true]);
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Ошибка! Заказ НЕ был удален!');
                    echo json_encode([true]);
                }
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Ошибка! Заказ НЕ был удален!');
                echo json_encode([true]);
            }
        }
    }
    
}
