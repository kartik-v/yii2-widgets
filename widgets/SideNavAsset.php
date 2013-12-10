<?php
namespace kartik\widgets;

use yii\web\AssetBundle;

/**
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class SideNavAsset extends AssetBundle
{
	public $sourcePath = '@vendor/kartik-v/yii2-widgets/kartik/assets';
	public $css = [
		'css/sidenav.css',
	];
	public $js = [
		'js/sidenav.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
