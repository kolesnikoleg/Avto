<?php

namespace frontend\components;

use Yii;

/**
 * Description of StringHelper
 *
 * @author Home
 */

class StringHelper {
    private $limit;
    
    public function __construct()
    {
        $this->limit = Yii::$app->params['shortTextLimit'];
    }
    
    public function getShort($string, $limit = null)
    {
        if ($limit === null): $limit = $this->limit; endif;
        return mb_substr ($string, 0, $limit) .  '...';
    }
}