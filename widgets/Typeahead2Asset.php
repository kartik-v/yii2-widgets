<?php

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Typeahead2Asset extends AssetBundle {
    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/assets';
	
	public function init() {
		$this->js = YII_DEBUG ? ['js/hogan.js'] : ['js/hogan.min.js'] ;
		$this->css = YII_DEBUG ? ['css/typeahead.css'] : ['css/typeahead.min.css'] ;
		parent::init();
	}
}