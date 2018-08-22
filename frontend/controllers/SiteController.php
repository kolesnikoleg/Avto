<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Search;
use yii\db\Query;
use frontend\models\PricesList;
use frontend\models\Settings;
use frontend\models\User;
use frontend\models\Markups;
use frontend\models\Carts;
use frontend\models\Vin;
use frontend\models\Order;
use frontend\models\user\Wishlist;
use frontend\models\user\Messages;
use SoapClient;
use frontend\models\Api;
use frontend\models\Product;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
use backend\models\News;
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionOfferta()
    {
        return $this->render('offerta');
    }
    
    
    public function actionAdmenter()
    {
        if (isset($_GET["id"]))
        {
            $identity = User::findOne(['id' => $_GET["id"]]);;
            Yii::$app->user->login($identity);
        }
        return $this->render('index');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionNewClient()
    {
        $total_asia = (new Query())->select('*')->from('prc_ASIA')->count();
        $total_europe = (new Query())->select('*')->from('prc_EUROPE')->count();
        
        
        
        return $this->render('new-client', compact('total_asia', 'total_europe'));
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAddPrice()
    {
        
        if(isset($_POST["Import"])){
            
            if(isset($_POST["pricelist"]) AND $_POST["pricelist"] !== 'Не указано!'){
		
                $filename=$_FILES["file"]["tmp_name"];		  
                if($_FILES["file"]["size"] > 0)
                {
                   
                    $num_rows = count(file($_FILES["file"]["tmp_name"]));
                    
                    (new PricesList())->setTotalRowsNewPrice($num_rows, $_POST["pricelist"]);
                    
                    
                    $file = fopen($filename, "r");
                    $sql = "TRUNCATE TABLE `prc_".$_POST["pricelist"]."`";
                    Yii::$app->db->createCommand($sql)->execute();   
                    while (($getData = fgetcsv($file, 1000000, ";")) !== FALSE)
                    {
                        $sql = "INSERT into `prc_".$_POST["pricelist"]."` (manufacturer,article,name,count,weight,min_order,price,this_price_name) 
                        values ('"
                            .(substr($_POST['manufacturer'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['manufacturer'] - 1]) : substr(substr($_POST['manufacturer'], 2), 0, -2) )."','"
                            .(substr($_POST['article'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['article'] - 1]) : substr(substr($_POST['article'], 2), 0, -2) )."','"
                            .(substr($_POST['name'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['name'] - 1]) : substr(substr($_POST['name'], 2), 0, -2) )."','"
                            .(substr($_POST['count'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['count'] - 1]) : substr(substr($_POST['count'], 2), 0, -2) )."','"
                            .(substr($_POST['weight'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['weight'] - 1]) : substr(substr($_POST['weight'], 2), 0, -2) )."','"
                            .(substr($_POST['min_order'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['min_order'] - 1]) : substr(substr($_POST['min_order'], 2), 0, -2) )."','"
                            .(substr($_POST['price'], 0, 1) != '^' ? htmlspecialchars($getData[$_POST['price'] - 1]) : substr(substr($_POST['price'], 2), 0, -2) )."','"
                            ."prc_".$_POST["pricelist"]
                        ."')";
                        Yii::$app->db->createCommand($sql)->execute();
                    }
                    fclose($file);
                        
                    
                }
            
                $result = $_POST["pricelist"];
            }
            else
            {
                $result = 'Ошибка! Выберите Прайслист для загрузки!';
            }
            
            return $this->render('new-client', ['result' => $result]);
	}	
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionGraphic()
    {
        return $this->render('graphic');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionOplataIDostavka()
    {
        return $this->render('oplata-i-dostavka');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionFaq()
    {
        return $this->render('faq');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionNews()
    {
        $query = News::find()->where(['status' => 1])->orderBy('id DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('news', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionOrd()
    {
        $model = new Order();
        $settings = new \frontend\models\Settings();
        if ($model->load(Yii::$app->request->post())) {
            
            $post = Yii::$app->request->post();
            
            if (Yii::$app->user->isGuest)
            {
                if (isset($_SESSION['cart']))
                {
                    $model->user_id = '-1';
                    $model->date = date('Y-m-d H:i:s');
                    $model->status = -1;
                    
                    $product = [];
                    
                    $cart = new Carts();
                    $products = $cart->getCartAsArray()['products'];
                    
                    foreach ($products as $key => $value)
                    {
                        $product[$key]['name'] = $value['product_info']['name'];
                        $product[$key]['api'] = $value['product_info']['api'];
                        $product[$key]['api_num'] = $value['product_info']['api_num'];
                        $product[$key]['weight'] = $value['product_info']['weight'];
                        $product[$key]['term'] = $value['product_info']['term'];
                        $product[$key]['ident'] = $value['product_info']['ident'];
                        $product[$key]['min_order'] = $value['product_info']['min_order'];
                        $product[$key]['currency'] = $value['product_info']['currency'];
                        $product[$key]['manufacturer'] = $value['product_info']['manufacturer'];
                        
                        $prod_obj = new Product();
                        $prod_obj->getFromArrayProduct($value['product_info']);
                        $product[$key]['price'] = round($prod_obj->getPriceCurrencyProduct(), 2);
                        
                        
                        $product[$key]['id'] = $value['product_info']['price_id'];
                        $product[$key]['article'] = $value['product_info']['article'];
                        $product[$key]['price_list'] = $value['product_info']['this_price_name'];
                        $product[$key]['count'] = $value['product_count'];
                        $product[$key]['payed'] = 0;
                    }
                    $product['total_price'] = round((new Carts())->getTotalProductsPricesCurrencyCart(), 2);
                    $product['dostavka_val'] = 0;
                    
                    $model->products = json_encode($product);
                    
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Ваш заказ был успешно оформлен! Наши менеджеры вскоре свяжутся с Вами!');
                        unset($_SESSION['cart']);
                    } else {
                        Yii::$app->session->setFlash('error', $model->errors);
                    }
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Ошибка! Ваша корзина была очищена в процессе оформления заказа! Оформить заказ не удалось!');
                    return $this->refresh();
                }
            }
            else
            {
                if ((new Carts())->find()->where(['user_id' => Yii::$app->user->identity->id])->count() > 0)
                { 
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->date = date('U');
                    $model->status = -1;
                    
                    $product = [];
                    
                    $cart = new Carts();
                    $products = $cart->getCartAsArray()['products'];
                    
                    foreach ($products as $key => $value)
                    {
                        $product[$key]['name'] = $value['product_info']['name'];
                        $product[$key]['api'] = $value['product_info']['api'];
                        $product[$key]['api_num'] = $value['product_info']['api_num'];
                        $product[$key]['weight'] = $value['product_info']['weight'];
                        $product[$key]['term'] = $value['product_info']['term'];
                        $product[$key]['ident'] = $value['product_info']['ident'];
                        $product[$key]['min_order'] = $value['product_info']['min_order'];
                        $product[$key]['currency'] = $value['product_info']['currency'];
                        $product[$key]['manufacturer'] = $value['product_info']['manufacturer'];
                        
                        $prod_obj = new Product();
                        $prod_obj->getFromArrayProduct($value['product_info']);
                        $product[$key]['price'] = round($prod_obj->getPriceCurrencyProduct(), 2);
                        
                        
                        $product[$key]['id'] = $value['product_info']['price_id'];
                        $product[$key]['article'] = $value['product_info']['article'];
                        $product[$key]['price_list'] = $value['product_info']['this_price_name'];
                        $product[$key]['count'] = $value['product_count'];
                        $product[$key]['payed'] = 0;
                    }
                    $product['total_price'] = round((new Carts())->getTotalProductsPricesCurrencyCart(), 2);
                    $product['dostavka_val'] = 0;
                    
                    $model->products = json_encode($product);
                    
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Ваш заказ был успешно оформлен! Наши менеджеры вскоре свяжутся с Вами!');
                        $res = Yii::$app->db->createCommand("DELETE FROM `carts` WHERE `user_id` = '".Yii::$app->user->identity->id."'")->execute();
                    } else {
                        Yii::$app->session->setFlash('error', $model->errors);
                    }
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Ошибка! Ваша корзина была очищена в процессе оформления заказа! Оформить заказ не удалось!');
                    return $this->refresh();
                }
            }
            
            

            return $this->refresh();
        } else {
            
            if (!Yii::$app->user->isGuest)
            {
                $model->phone = $model->emptyPhone;
                $model->dostavka = $model->emptyDostavka;
            }
                
            return $this->render('ord', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionContacts()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Успех! Сообщение было отправлено!');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка! Сообщение НЕ было отправлено!');
            }

            return $this->refresh();
        } else {
            return $this->render('contacts', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionStock()
    {
        return $this->render('stock');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionVin()
    {
        $model = new Vin();
        if ($model->load(Yii::$app->request->post())) {
            
            $post = Yii::$app->request->post();
            
            if (Yii::$app->user->isGuest)
            {
                $model->user_id = '-1';
            }
            else
            {
                $model->user_id = Yii::$app->user->identity->id;
            }
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'VIN-запрос был успешно отправлен!');
            } else {
                Yii::$app->session->setFlash('error', $model->errors);
            }

            return $this->refresh();
        } else {
            
            
            return $this->render('vin', [
                'model' => $model,
            ]);
        }
        
        return $this->render('vin');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionPrice()
    {
        return $this->render('price');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout(false);

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//            } else {
//                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
//            }
//
//            return $this->refresh();
//        } else {
//            return $this->render('contact', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays search page.
     *
     * @return mixed
     */
    public function actionSearch()
    {

            if (Yii::$app->request->post()) {

                
            $model = new PricesList();
            $tbls = $model->getListPricesAll();
            
            $apis = (new Api())->getAllApisID();
            
            return $this->render('search', [
                'search_str' => Yii::$app->request->post('search'),
                'tbls' => $tbls,
                'apis' => $apis,
            ]);
        } else {
            return $this->render('search', [
            ]);
        }
    }
    
    public function actionCart()
    {
           
        return $this->render('cart', [
            'all_carts_products' => (new Carts())->getCartAsArray()['products'],
            'total_products' => (new Carts())->getTotalProductsCart(),
            'total_products_price' => (new Carts())->getTotalProductsPricesCart(),
            'user_id' => '',
        ]);
    }
    
    public function actionSearchResult ()
    {
        if (Yii::$app->request->isAjax)
        {
            if (Yii::$app->request->post('api') === '-1')
            {
            
                $model = new PricesList();
                $m_markups = new Markups();
                $settings = new \frontend\models\Settings();
                $rows = (new \yii\db\Query())
                    ->select(['*'])
                    ->from(Yii::$app->request->post('tbl'))
                    ->where(['like binary', 'article', Yii::$app->request->post('search_string')])
                    ->all();

                foreach ($rows as $key => &$value)
                {
                    $value['term'] = $model->getPriceListTerm($value['this_price_name']);
                    $value['weight'] = $value['weight'] . ' КГ';
                    $value['price_null'] = '';

                    $m_user = new User();

                    if ( (new PricesList())->getPriceListCurrency($value['this_price_name']) === 'USD' ):
                        $val_curr = Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($value['id'], $value['this_price_name'], $value['article']), 2);
                        $val_uah = Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($value['id'], $value['this_price_name'], $value['article']) * $settings->getCurrencyUSD(), 2);

                        $value['price'] = $val_curr.' USD<br /><span class="gr_uah">'.$val_uah.' ГРН</span>';
                        $value['price_uah'] = floatval($val_uah);
                    endif;
                    if ( (new PricesList())->getPriceListCurrency($value['this_price_name']) === 'EURO' ):
                        $val_curr = Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($value['id'], $value['this_price_name'], $value['article']), 2);
                        $val_uah = Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($value['id'], $value['this_price_name'], $value['article']) * $settings->getCurrencyEURO(), 2);

                        $value['price'] = $val_curr.' EURO<br /><span class="gr_uah">'.$val_uah.' ГРН</span>';
                        $value['price_uah'] = floatval($val_uah);
                    endif;
                    if ( (new PricesList())->getPriceListCurrency($value['this_price_name']) === 'UAH' ):
                        $val_curr = Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($value['id'], $value['this_price_name'], $value['article']), 2);
                        $val_uah = Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($value['id'], $value['this_price_name'], $value['article']), 2);

                        $value['price'] = $val_curr.' ГРН';
                        $value['price_uah'] = floatval($val_uah);
                    endif;

                }

                echo json_encode($rows);
            }
            else
            {
                $model = new PricesList();
                $m_markups = new Markups();
                $settings = new \frontend\models\Settings();
                
                $api = (new Api())->getDataApiFromID(Yii::$app->request->post('api'));
                
                $client = new SoapClient($api['address'],array('encoding'=>'UTF-8'));  

                // авторизация и получение session key
                $session_key = $client->login($api['login'], $api['password']);

                // поиск запчастей
                $search = Yii::$app->request->post('search_string'); // искомая запчасть
                $result = $client->searchParts($session_key, $search); // возвращает ассоциативные массивы
//                if (is_array($result) AND !empty($result)) {
                if (isset($result[0])) {
//                echo json_encode($result); return;
                $result = $result[0];
                
                $res_arr = [];

                $i = 0;

                
                    $res_arr[$i]['manufacturer'] = $result['manufacturer'];
                    $res_arr[$i]['name'] = $result['name'];
                    $res_arr[$i]['article'] = $result['article'];
                    $res_arr[$i]['this_price_name'] = 'prc_'.(new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'));
                    $res_arr[$i]['term'] = $result['delivery'] . ' ДНЕЙ';
                    $res_arr[$i]['id'] = 'API-' . Yii::$app->request->post('api');

                    // USD  USD  USD  USD  USD  USD  USD  USD  USD  USD  USD  USD  
//                    $res_arr[$i]['price'] = $value['price'];

                    
                    if ( $api['currency'] === 'USD' ):
                        $val_curr = Yii::$app->formatter->asDecimal( (new PricesList())->getApiProductPrice($result['price'], 'prc_' . (new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'))), 2);
                        $val_uah = Yii::$app->formatter->asDecimal( (new PricesList())->getApiProductPrice($result['price'], 'prc_' . (new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'))) * $settings->getCurrencyUSD(), 2);

                        $res_arr[$i]['price'] = $val_curr.' USD<br /><span class="gr_uah">'.$val_uah.' ГРН</span>';
                        $res_arr[$i]['price_uah'] = floatval($val_uah);
                    endif;
                    if ( $api['currency'] === 'EURO' ):
                        $val_curr = Yii::$app->formatter->asDecimal( (new PricesList())->getApiProductPrice($result['price'], 'prc_' . (new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'))), 2);
                        $val_uah = Yii::$app->formatter->asDecimal( (new PricesList())->getApiProductPrice($result['price'], 'prc_' . (new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'))) * $settings->getCurrencyEURO(), 2);

                        $res_arr[$i]['price'] = $val_curr.' EURO<br /><span class="gr_uah">'.$val_uah.' ГРН</span>';
                        $res_arr[$i]['price_uah'] = floatval($val_uah);
                    endif;
                    if ( $api['currency'] === 'UAH' ):
                        $val_curr = Yii::$app->formatter->asDecimal( (new PricesList())->getApiProductPrice($result['price'], 'prc_' . (new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'))), 2);
                        $val_uah = Yii::$app->formatter->asDecimal( (new PricesList())->getApiProductPrice($result['price'], 'prc_' . (new Api())->getApiPriceListNameByID(Yii::$app->request->post('api'))), 2);

                        $res_arr[$i]['price'] = $val_curr.' ГРН';
                        $res_arr[$i]['price_uah'] = floatval($val_uah);
                    endif;


                    $res_arr[$i]['weight'] = strval($result['weight'] / 1000) . ' КГ';
                    $res_arr[$i]['min_order'] = (new Api())->getApiPriceListMinOrderByID(Yii::$app->request->post('api'));
                    $res_arr[$i]['count'] = $result['available'];
                    $i++;
                

                    echo json_encode($res_arr);
                
                
                }
                else
                {
                    $arr = [];
                    return json_encode($arr);
                }
            }
        }
    }

    
    public function actionCartRel ()
    {
        if (Yii::$app->request->isAjax)
        {
            $count = intval(Yii::$app->request->post('count'));
            $id = Yii::$app->request->post('id');
            
            $cart = new Carts();
            $res = $cart->setProductCountCart($id, $count);
            
            if ($res)
            {
                echo json_encode([true]);
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }

    
    public function actionCartDel ()
    {
        if (Yii::$app->request->isAjax)
        {
            $id = Yii::$app->request->post('id');
            
            $cart = new Carts();
            $res = $cart->delProductCart($id);
            
            if ($res)
            {
                echo json_encode([true]);
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionMesRead ()
    {
        if (Yii::$app->request->isAjax)
        {
            $id = intval(Yii::$app->request->post('id'));
            
           
            $res = false;
            if ((new Messages())->checkOwnMessage($id))
            {
                $res = Yii::$app->db->createCommand("UPDATE `messages` SET `readed` = '2' WHERE id = '".Yii::$app->request->post('id')."'")->execute();
            }

            if ($res)
            {
                Yii::$app->session->setFlash('success', 'Успех! Сообщение было помечено как прочитанное!');
                echo json_encode([true, $id]);
            }
            else
            {                
                Yii::$app->session->setFlash('error', 'Ошибка! Сообщение НЕ было помечено как прочитанное!');
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionMesDel ()
    {
        if (Yii::$app->request->isAjax)
        {
            $id = intval(Yii::$app->request->post('id'));
            
           
            $res = false;
            if ((new Messages())->checkOwnMessage($id))
            {
                $res = Yii::$app->db->createCommand("DELETE FROM `messages` WHERE id = '".Yii::$app->request->post('id')."'")->execute();
            }
            
            $how_lost = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `messages` WHERE user_id = '".Yii::$app->user->identity->id."'")->queryOne();
            $how_lost = intval($how_lost['COUNT(*)']);

            if ($res)
            {
                Yii::$app->session->setFlash('success', 'Успех! Сообщение было успешно удалено!');
                echo json_encode([true, $id, $how_lost]);
            }
            else
            {                
                Yii::$app->session->setFlash('error', 'Ошибка! Сообщение НЕ было удалено!');
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionWishDel ()
    {
        if (Yii::$app->request->isAjax)
        {
            $id = intval(Yii::$app->request->post('id'));
            
                $res = false;
                if ((new Wishlist())->checkOwnWish($id))
                {
                    $res = Yii::$app->db->createCommand("DELETE FROM `wishlist` WHERE id = '".Yii::$app->request->post('id')."'")->execute();
                }

                $how_lost = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `wishlist` WHERE user_id = '".Yii::$app->user->identity->id."'")->queryOne();
                $how_lost = intval($how_lost['COUNT(*)']);           
            
            if ($res)
            {
                echo json_encode([true, $id, $how_lost]);
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionCartErase ()
    {
        if (Yii::$app->request->isAjax)
        {
            if ((new Carts())->eraseCart())
            {
                echo json_encode([true]);
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionRecall ()
    {
        if (Yii::$app->request->isAjax)
        {
            if ('GO!')
            {
                echo json_encode([true]);
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionWishAdd ()
    {
        if (Yii::$app->request->isAjax)
        {
            $arr = explode('^^', (Yii::$app->request->post('id')));
            
            $res = false;
            
//            $article = $arr[2];
//            $product_price_name = $arr[0];
//            $product_id = $arr[1];
//            
//            $product = (new PricesList())->getProductBy($product_price_name, $article, $product_id);
            
            
            if (substr($arr[1], 0, 3) === 'API')
            {
                $article = $arr[2];
                $api_num = substr($arr[1], 4);
                $product = (new API())->getProductByArticle($article, $api_num);
            }
            else
            {
                $pricelist = $arr[0];
                $article = $arr[2];
                $id = $arr[1];
                $product = (new PricesList())->getProductBy($pricelist, $article, $id);
            }
            
            $product_info = json_encode($product, JSON_UNESCAPED_UNICODE);
            
            
            $check_isset_wishlist = (new Query())->select(['*'])->from('wishlist')->where(['user_id' => Yii::$app->user->identity->id, 'product_article' => $product['article'], 'product_price_name' => $product['this_price_name']])->limit(1)->one();
            if (!$check_isset_wishlist)
            {
                $res = Yii::$app->db->createCommand("INSERT INTO `wishlist` (user_id, product_article, product_price_name, product_info, product_id) VALUES ('".Yii::$app->user->identity->id."', '".$arr[2]."', '".$arr[0]."', '".$product_info."', '".$arr[1]."')")->execute();
            }
            else
            {
                echo json_encode([false, 'isset']);
                return;
            }
            
            
            
            if ($res)
            {
                echo json_encode([true]);
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }
    
    
    public function actionCartAdd ()
    {
        if (Yii::$app->request->isAjax)
        {
            $arr = explode('^^', (Yii::$app->request->post('id')));
            if (substr($arr[1], 0, 3) === 'API')
            {
                $article = $arr[2];
                $api_num = substr($arr[1], 4);
                $product = new Product(true, ['api_num' => $api_num, 'article' => $article]);
            }
            else
            {
                $pricelist = $arr[0];
                $article = $arr[2];
                $id = $arr[1];
                $product = new Product(false, ['pricelist' => $pricelist, 'article' => $article, 'id' => $id]);
            }
            
            $res = $product->addProductCart(Yii::$app->request->post('count'));
            if ($res === true)
            {
                $new_total_products = (new Carts())->getTotalProductsCart();
                $new_total_products_price = (new Carts())->getTotalProductsPricesCurrencyCart();
                echo json_encode([true, $new_total_products, $new_total_products_price]);
            }
            else
            {
                if ($res[1] == 'isset')
                {
                    echo json_encode([false, $res[1]]);
                }
                if ($res[1] == 'min_order')
                {
                    echo json_encode([false, $res[1], $res[2]]);
                }
            }
        }
    }
    
    
    public function actionAct ()
    {
        $cart = new Carts();
        $products = $cart->getCartAsArray()['products'];
        $date_now = date('Y-m-d H:i:s');
        foreach ($products as $product)
        {
            $prod_obj = new Product();
            $prod_obj->getFromArrayProduct($product['product_info']);
            if ($prod_obj->isRealProduct()):
                $count = $cart->getProductCountByIdentCart($prod_obj->ident);
        
                $prod_obj->delProductCart($prod_obj->ident); 
                if ($prod_obj->api):
                    $new_product = new Product(true, ['api_num' => $prod_obj->api_num, 'article' => $prod_obj->article]);
                else:
                    $new_product = new Product(false, ['pricelist' => 'prc_' . $prod_obj->this_price_name, 'article' => $prod_obj->article, 'id' => $prod_obj->price_id]);
                endif;
                $new_product->addProductCart($count, $date_now);
            else:
                $prod_obj->delProductCart($prod_obj->ident);
            endif;
        }
        $_SESSION['help_flash'] = ['cart_act_true'];
        return $this->redirect(['cart']);
    }
    
    public function actionCartImp ()
    {
        if (Yii::$app->request->isAjax)
        {
            if (isset($_SESSION['cart']))
            {
                $total_added = 0;
                $total_missed = 0;
                foreach ($_SESSION['cart'] as $key => $value)
                {
                    $obj = json_decode($value['product_info'], true);
                    $product_cart = (new Query())->select(['*'])->from('carts')->where(['user_id' => Yii::$app->user->identity->id, 'ident' => $obj['ident']])->one();
                    if ($product_cart)
                    {
                        $total_missed += 1;
                    }
                    else
                    {
                        
                        
                        
                        $buf_arr['api'] = $obj['api'];
                        $buf_arr['api_num'] = $obj['api_num'];
                        $buf_arr['article'] = $obj['article'];
                        $buf_arr['price'] = $obj['price'];
                        $buf_arr['price_id'] = $obj['price_id'];
                        $buf_arr['manufacturer'] = $obj['manufacturer'];
                        $buf_arr['term'] = $obj['term'];
                        $buf_arr['ident'] = $obj['ident'];
                        $buf_arr['min_order'] = $obj['min_order'];
                        $buf_arr['name'] = $obj['name'];
                        $buf_arr['weight'] = $obj['weight'];
                        $buf_arr['currency'] = $obj['currency'];
                        $buf_arr['this_price_name'] = $obj['this_price_name'];
                        
                        $product = new Product();
                        $product->getFromArrayProduct($buf_arr);
                        if ($product->addProductCart($value['product_count'])): $total_added += 1; endif;
                        
//                        $buf_arr['name'] = $_SESSION['cart'][$key]['name'];
//                        $buf_arr['min_order'] = $_SESSION['cart'][$key]['min_order'];
//                        
//                        $buf_arr['price'] = $_SESSION['cart'][$key]['price'];
//                        $buf_arr['weight'] = $_SESSION['cart'][$key]['weight'];
//
//                        if (substr($_SESSION['cart'][$key]['product_id'], 0, 3) == 'API')
//                        {
//                            $buf_arr['term'] = $_SESSION['cart'][$key]['term'];
//                        }
//                        else
//                        {
//                            $buf_arr['term'] = $_SESSION['cart'][$key]['term'];
//                        }
//
//                        $sql = "INSERT INTO `carts` (";
//                        $sql .= "user_id, product_article, product_price_name, product_id, product_info, product_count";
//                        $sql .= ") VALUES (";
//                        $sql .= "'".Yii::$app->user->identity->id."', ";
//                        $sql .= "'".$_SESSION['cart'][$key]['article']."', ";
//
//
//                        if (substr($_SESSION['cart'][$key]['product_id'], 0, 3) == 'API')
//                        {
//                            $sql .= "'".$_SESSION['cart'][$key]['this_price_name']."', ";
//                        }
//                        else
//                        {
//                            $sql .= "'".$_SESSION['cart'][$key]['this_price_name']."', ";
//                        }
//
//
//                        $sql .= "'".$_SESSION['cart'][$key]['product_id']."', ";
//                        $sql .= "'".json_encode($buf_arr, JSON_UNESCAPED_UNICODE)."', ";
//                        $sql .= "'".$_SESSION['cart'][$key]['product_count']."'";
//                        $sql .= ')';
//
//                        $res = Yii::$app->db->createCommand($sql)->execute();
//                        
//                        
////                        {"manufacturer":"TOYOTA","name":"GASKET KIT, ENGINE","min_order":"1","price":"110,44","weight":"0","term":"3-7 ДНЕЙ"}
                        
                    }
                }

                if ($total_added > 0 OR $total_missed > 0)
                {
                    echo json_encode([true]);
                    $_SESSION['imp_added'] = $total_added;
                    $_SESSION['imp_missed'] = $total_missed;
                }
                else
                {
                    echo json_encode([false]);
                }
            }
            else
            {
                echo json_encode([false]);
            }
        }
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
