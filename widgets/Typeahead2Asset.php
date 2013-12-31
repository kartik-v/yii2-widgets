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
class Typeahead2Asset extends AssetBundle {

    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/assets';
	
	public function init() {
		$this->css = YII_DEBUG ? ['css/typeahead.css'] : ['css/typeahead.min.css'] ;
		$this->js = YII_DEBUG ? ['js/hogan.js'] : ['js/hogan.min.js'] ;
		parent::init();
	}

}