<?php

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Typeahead2Asset extends AssetBundle {
    public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/assets/css';
	public $css = ['typeahead.css'];
	
	public function init() {
		$this->css = YII_DEBUG ? ['typeahead.css'] : ['typeahead.min.css'] ;
		parent::init();
	}
}
