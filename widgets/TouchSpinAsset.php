<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for TouchSpin Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TouchSpinAsset extends AssetBundle {

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        $this->sourcePath = __DIR__ . '/../assets';
        $this->js = YII_DEBUG ? ['js/bootstrap.touchspin.js'] : ['js/bootstrap.touchspin.min.js'];
        parent::init();
    }

}
