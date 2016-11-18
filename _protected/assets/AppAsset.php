<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Nenad Zivkovic <nenad@freetuts.org>
 * 
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    /*public $css = [
        'css/bootstrap.min.css',
        'css/style.css',
    ];*/
    public $css = [
        'light/css/bootstrap.min.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all',
        'frontend/assets/plugins/font-awesome/css/font-awesome.min.css',
        'frontend/assets/pages/css/animate.css',
        'frontend/assets/plugins/fancybox/source/jquery.fancybox.css',
        'frontend/assets/plugins/owl.carousel/assets/owl.carousel.css',
        'frontend/assets/pages/css/components.css',
        'frontend/assets/pages/css/slider.css',
        'frontend/assets/corporate/css/style.css',
        'frontend/assets/corporate/css/style-responsive.css',
        'frontend/assets/corporate/css/themes/red.css',
        'css/custom.css',
    ];
    
    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
