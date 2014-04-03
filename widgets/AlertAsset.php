<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for \kartik\widgets\Alert
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class AlertAsset extends AssetBundle
{

	public function init()
	{
		$this->setSourcePath(__DIR__ . '/../assets');
		$this->setupAssets('css', ['css/alert']);
		parent::init();
	}

}