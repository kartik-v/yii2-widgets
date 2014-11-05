<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.3.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for ColorInput Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ColorInputAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/spectrum']);
        $this->setupAssets('js', ['js/spectrum']);
        parent::init();
    }
}
