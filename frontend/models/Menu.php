<?php

namespace frontend\models;

use Yii;


class Menu extends \yii\base\Model
{
   public function getAllMenu ()
   {
       
       $arr = Yii::$app->params['main_menu'] ;
       
       foreach ($arr as $key => $value)
       {
           if (!is_array($value))
           {
               $menu[$key] = $value;
           }
           else
           {
               foreach ($value as $key_1 => $value_1)
               {
                   $menu[$key_1] = $value_1;
               }
           }
           
           if ($value == '/' . Yii::$app->controller->action->id)
           {
               $menu['active'] = $value;
           }
           if (Yii::$app->controller->action->id == 'index' AND Yii::$app->controller->id == 'site')
           {
               $menu['active'] = '/';
           }
       }
       return $menu;
   }
   
   public function getMenuMore ()
   {
       $menu = Yii::$app->params['main_menu'];
       foreach ($menu as $key => $value)
       {
           if ($value == '/' . Yii::$app->controller->action->id)
           {
               $menu['active'] = $value;
           }
           if (Yii::$app->controller->action->id == 'index' AND Yii::$app->controller->id == 'site')
           {
               $menu['active'] = '/';
           }
//           $menu[$value] = 'active';
       }
       return $menu;
   }
   
   public function getMenuWithoutMore ()
   {
       
       $arr = Yii::$app->params['main_menu'] ;
       
       foreach ($arr as $key => $value)
       {
           if (!is_array($value))
           {
               $menu[$key] = $value;
           }
           
           if ($value == '/' . Yii::$app->controller->action->id)
           {
               $menu['active'] = $value;
           }
           if (Yii::$app->controller->action->id == 'index' AND Yii::$app->controller->id == 'site')
           {
               $menu['active'] = '/';
           }
       }
       return $menu;
   }
   
   public function getAllMyMenu ()
   {
       
       $arr = Yii::$app->params['my_menu'] ;
       
       foreach ($arr as $key => $value)
       {
           $menu[$key] = $value;
           
           if ($value == '/user/' . Yii::$app->controller->action->id)
           {
               $menu['active'] = $value;
           }
           if (Yii::$app->controller->action->id == 'index' AND Yii::$app->controller->id == 'user')
           {
               $menu['active'] = '/user/index';
           }
       }
       return $menu;
   }
}
