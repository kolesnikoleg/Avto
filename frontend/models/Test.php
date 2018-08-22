<?php

namespace frontend\models;

use Yii;

class Test
{

	public static function getNewsList($maxNews)
	{

		$maxNews = intval($maxNews);
		$sql = 'SELECT * FROM `news` LIMIT ' . $maxNews;
		
                $result = Yii::$app->db->createCommand($sql)->queryAll();
                
                $max_limit = Yii::$app->params['shortTextLimit'];
                
                if (!empty($result) AND is_array($result))
                {
                    
                    foreach ($result as &$item)
                    {
                        $item['content'] = Yii::$app->stringHelper->getShort($item['content']);
                    }
                }
                
		return $result;

	}

}