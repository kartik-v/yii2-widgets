<?php

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Select2Asset extends AssetBundle {
    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/lib/select2';
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

	public function init() {
		$this->css = YII_DEBUG ? ['select2.css', 'select2-bootstrap3.css'] : ['select2.min.css', 'select2-bootstrap3.min.css'];
		$this->js = YII_DEBUG ? ['select2.js'] : ['select2.min.js'];
		parent::init();
	}
}
