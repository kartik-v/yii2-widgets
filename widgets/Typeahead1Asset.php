<?php

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for Typeahead Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Typeahead1Asset extends AssetBundle {

    public $sourcePath = '@vendor/twitter/typeahead.js/dist';
	
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
	
	public function init() {
		$this->js = YII_DEBUG ? ['typeahead.js'] : ['typeahead.min.js'] ;
		parent::init();
	}
}
