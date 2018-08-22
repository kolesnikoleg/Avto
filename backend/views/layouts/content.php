<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use backend\assets\AppAsset;

?>
<div class="content-wrapper" style="overflow-x: auto">
    <section class="content-header">

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
</footer>



<?php $this->registerJsFile('libs/magnific-popup/jquery.magnific-popup.min.js', ['depends' => [
AppAsset::className()
]]); ?>

