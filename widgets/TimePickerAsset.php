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
 * Asset bundle for TimePicker Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TimePickerAsset extends AssetBundle {

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        $this->sourcePath = __DIR__ . '/../assets';
        $this->css = YII_DEBUG ? ['css/bootstrap-timepicker.css'] : ['css/bootstrap-timepicker.min.css'];
        $this->js = YII_DEBUG ? ['js/bootstrap-timepicker.js'] : ['js/bootstrap-timepicker.min.js'];
        parent::init();
    }

}
