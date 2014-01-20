<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use yii\web\AssetBundle;

/**
 * Asset bundle for SideNav Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class SideNavAsset extends AssetBundle {

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        $this->sourcePath = __DIR__ . '/../assets';
        $this->css = YII_DEBUG ? ['css/sidenav.css'] : ['css/sidenav.min.css'];
        $this->js = YII_DEBUG ? ['js/sidenav.js'] : ['js/sidenav.min.js'];
        parent::init();
    }

}
