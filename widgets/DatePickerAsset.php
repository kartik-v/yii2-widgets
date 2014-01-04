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
 * Asset bundle for Select2 Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DatePickerAsset extends AssetBundle {

    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/lib/bootstrap-datepicker';
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        $this->css = YII_DEBUG ? ['css/datepicker3.css'] : ['css/datepicker3.min.css'];
        $this->js = YII_DEBUG ? ['js/bootstrap-datepicker.js'] : ['js/bootstrap-datepicker.min.js'];
        parent::init();
    }

}
