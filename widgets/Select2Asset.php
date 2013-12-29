<?php

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Select2Asset extends AssetBundle {
    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/lib/select2';
	public $css = ['select2.css', 'select2-bootstrap3.css'];
	public $js = ['select2.js'];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
