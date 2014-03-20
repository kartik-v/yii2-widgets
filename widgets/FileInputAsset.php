<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for FileInput Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class FileInputAsset extends AssetBundle
{

	public function init()
	{
		$this->setSourcePath('@vendor/kartik-v/bootstrap-fileinput');
		$this->setupAssets('css', ['css/fileinput']);
		$this->setupAssets('js', ['js/fileinput']);
		parent::init();
	}

}