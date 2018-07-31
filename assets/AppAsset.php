<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i
        'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800&amp;subset=cyrillic',
        'lib/fontawesome/css/all.css',
        'lib/bxslider/dist/jquery.bxslider.min.css',
        'lib/fancybox/dist/jquery.fancybox.css',
        'css/main.css?v=133',
    ];
    public $js = [
        'lib/bxslider/dist/jquery.bxslider.min.js',
        'lib/fancybox/dist/jquery.fancybox.js',
        'lib/jquery.maskedinput.min.js',
        'js/main.js?v=133'
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        'app\assets\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
