<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\AdminLoginForm;
use frontend\models\PricesList;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionTest()
    {
        return $this->render('test');
    }
    
    
    public function actionLa()
    {
        return $this->render('la');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('/site/index');
        }

        $model = new AdminLoginForm();
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    
    public function actionAddPrice()
    {
        
        if(isset($_POST["Import"])){
            
            if(isset($_POST["pricelist"]) AND $_POST["pricelist"] !== 'Не указано!'){
                
                $filename = $_FILES["file"]["tmp_name"];		 
                if($_FILES["file"]["size"] > 0)
                {
                   
                    $num_rows = count(file($_FILES["file"]["tmp_name"]));
                    
                    (new PricesList())->setTotalRowsNewPrice($num_rows, $_POST["pricelist"]);
                    
                    Yii::$app->db->createCommand("UPDATE `prices_list` SET date = '".date('Y-m-d H:i:s')."' WHERE name = 'prc_".$_POST["pricelist"]."'")->execute();
                    
                    $file = fopen($filename, "r");
                    $sql = "TRUNCATE TABLE `prc_".$_POST["pricelist"]."`";
                    Yii::$app->db->createCommand($sql)->execute();   
                    while (($getData = fgetcsv($file, 1000000, ";")) !== FALSE)
                    {
                        $sql = "INSERT into `prc_".$_POST["pricelist"]."` (manufacturer,article,name,count,weight,min_order,price,this_price_name) 
                        values ('"
                            .(substr($_POST['manufacturer'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['manufacturer'] - 1])) : substr(substr($_POST['manufacturer'], 2), 0, -2) )."','"
                            .(substr($_POST['article'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['article'] - 1])) : substr(substr($_POST['article'], 2), 0, -2) )."','"
                            .(substr($_POST['name'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['name'] - 1])) : substr(substr($_POST['name'], 2), 0, -2) )."','"
                            .(substr($_POST['count'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['count'] - 1])) : substr(substr($_POST['count'], 2), 0, -2) )."','"
                            .(substr($_POST['weight'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['weight'] - 1])) : substr(substr($_POST['weight'], 2), 0, -2) )."','"
                            .(substr($_POST['min_order'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['min_order'] - 1])) : substr(substr($_POST['min_order'], 2), 0, -2) )."','"
                            .(substr($_POST['price'], 0, 1) != '^' ? str_replace("'", " ", htmlspecialchars($getData[$_POST['price'] - 1])) : substr(substr($_POST['price'], 2), 0, -2) )."','"
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
            
            return $this->render('/site/index', ['result' => $result]);
	}	
    }
}
