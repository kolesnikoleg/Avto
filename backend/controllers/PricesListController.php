<?php

namespace backend\controllers;

use Yii;
use backend\models\PricesList;
use backend\models\PricesListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PricesListController implements the CRUD actions for PricesList model.
 */
class PricesListController extends Controller
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

    /**
     * Lists all PricesList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PricesListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PricesList model.
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
     * Creates a new PricesList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PricesList();

        if ($model->load(Yii::$app->request->post())) {
            $model->name = 'prc_' . $model->name;
            $model->rows = 0;
            $model->date = Yii::$app->formatter->asDatetime('now', "php:Y-m-d H:i:s");
            
            $sql = '';
            $sql .= "CREATE TABLE `".$model->name."` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `article` varchar(255) CHARACTER SET utf8 NOT NULL,
  `count` varchar(255) CHARACTER SET utf8 NOT NULL,
  `weight` varchar(255) CHARACTER SET utf8 NOT NULL,
  `min_order` int(11) NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `this_price_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
            
            Yii::$app->db->createCommand($sql)->execute();
            
            Yii::$app->db->createCommand("INSERT INTO `markups` (`price_name`, `from`, `to`, `value`, `znak`) VALUES ('".$model->name."', '0', '50000', '20', '*')")->execute();
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        $model->name = substr($model->name, 4);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PricesList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->name = 'prc_' . $model->name;
            
            $sql = '';
            $sql .= "CREATE TABLE `".$model->name."` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `article` varchar(255) CHARACTER SET utf8 NOT NULL,
  `count` varchar(255) CHARACTER SET utf8 NOT NULL,
  `weight` varchar(255) CHARACTER SET utf8 NOT NULL,
  `min_order` int(11) NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `this_price_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
            
            Yii::$app->db->createCommand($sql)->execute();
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        $model->name = substr($model->name, 4);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PricesList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $obj = $this->findModel($id);
        
        $sql = '';
        $sql .= "DROP TABLE `".$obj->name."`";
        Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->db->createCommand("DELETE FROM `markups` WHERE `price_name` = '".$obj->name."'")->execute();
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PricesList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PricesList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PricesList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
