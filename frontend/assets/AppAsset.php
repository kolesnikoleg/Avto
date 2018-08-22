<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fonts.css',
        'css/main.css',
        'css/media.css',
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
        'libs/magnific-popup/magnific-popup.css',
        'https://use.fontawesome.com/releases/v5.0.13/css/all.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
