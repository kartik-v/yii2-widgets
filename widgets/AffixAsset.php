<?php
namespace kartik\widgets;

use yii\web\AssetBundle;

/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class AffixAsset extends AssetBundle
{
	public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/assets';
	public $css = [
		'css/affix.css',
	];
	public $js = [
		'js/affix.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
