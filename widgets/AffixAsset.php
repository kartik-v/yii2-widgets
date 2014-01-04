<?php
namespace kartik\widgets;

use yii\web\AssetBundle;

/**
 * Asset bundle for Affix Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class AffixAsset extends AssetBundle
{

	public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/assets';
	public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
	];

	public function init() {
		$this->css = YII_DEBUG ? ['css/affix.css'] : ['css/affix.min.css'];
		$this->js = YII_DEBUG ? ['js/affix.js'] : ['js/affix.min.js'];
		parent::init();
	}

}
