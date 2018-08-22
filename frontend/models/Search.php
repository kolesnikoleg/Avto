<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class Search extends Model
{
        public $search;
    
        public function rules()
        {
            return [
                  [['search'], 'required'],  
            ];


	}

}