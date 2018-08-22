<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Menu;
use frontend\models\user\Messages;

/* @var $this yii\web\View */
/* @var $model frontend\models\user\MyCars */

$this->title = 'АВТО С VIN: '.$model->vin;
$this->params['breadcrumbs'][] = ['label' => 'My Cars', 'url' => ['index']];
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


                                <div class="my-cars-view">

                                    <p>
                                        <?= Html::a('ИЗМЕНИТЬ', ['update', 'id' => $model->id], ['class' => 'btn_us mt-20 mb-20 mr-10']) ?>
                                        <?= Html::a('УДАЛИТЬ', ['delete', 'id' => $model->id], [
                                            'class' => 'btn_us mt-20 mb-20',
                                            'data' => [
                                                'confirm' => 'Вы удаляете Ваш автомобиль! Вы уверены?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </p>

                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            //'id',
                                            //'user_id',
                                            'vin',
                                            'brand',
                                            'model',
                                            'year',
                                            'kpp',
                                            'engine',
                                            'comment:ntext',
                                        ],
                                    ]) ?>

                                

                                
                                </div>
                        </div>
                </div>
        </div>
</section>