<?php

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for Select2 Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DatepickerAsset extends AssetBundle {

    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/lib/datepicker';
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

	public function init() {
		$this->css = YII_DEBUG ? ['datepicker3.css'] : ['datepicker3.min.css'];
		$this->js = YII_DEBUG ? ['datepicker.js'] : ['datepicker.min.js'];
		parent::init();
	}

}
