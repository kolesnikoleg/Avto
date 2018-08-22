<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Menu;
use frontend\models\user\Messages;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои автомобили';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="page">
	<div class="container">
		<div class="row">
                        <div class="col-xs-12">
                            
                                <h2><?= Html::encode($this->title) ?></h2>
                            
                                <div class="my_menu">
					<?php
					$my_model = new Menu();
					$menu = $my_model->getAllMyMenu();
					foreach ($menu as $key => $value):
                                                if ($key != 'active'):
                                                        ?>
                                                        <?php $nazv = str_replace(' ', '&nbsp;', $key); ?>
                                                        <a href="<?= $value ?>"><?= $nazv ?><?php if ($value == '/user/messages') if ((new Messages())->getCountNotReadMyMessages() > 0) echo '<span class="new_mess">'.(new Messages())->getCountNotReadMyMessages().'</span>'; ?></a>
                                                        <?php
                                                endif;
                                        endforeach;

					$exit_form = '';
					$exit_form 

					.= Html::beginForm(['/site/logout'], 'post',  ['class' => 'my_form my_mnu', 'style' => "display:inline-block;"])
					. Html::submitButton(
						'ВЫХОД',
						['class' => 'btn btn-link logout']
					)
					. Html::endForm();

					echo $exit_form ;
					?>
				</div>
                            
                            
                                <div class="my-cars-index">

                                    

                                    <p>
                                        <?= Html::a('Создать автомобиль', ['create'], ['class' => 'btn_us mt-20 mb-20']) ?>
                                    </p>

                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'summary' => 'Показано {count} из {totalCount}',
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            //'id',
                                            //'user_id',
                                            'vin',
                                            'brand',
                                            'model',
                                            'year',
                                            'kpp',
                                            'engine',
                                            'comment:ntext', // короткий вид записи формата
                                            
                                            ['class' => 'yii\grid\ActionColumn'],
                                        ],
                                    ]); ?>
                                </div>
                        </div>
                </div>
        </div>
</section>

<?php


$js = <<<JS
        
$('table tbody tr td').css('display', function(){
    if ($(this).html() == '') return 'none';
});
   
JS;

$this->registerJs($js);
?>