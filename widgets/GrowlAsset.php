<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 2.9.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for \kartik\widgets\Growl
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class GrowlAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/../assets');
        $this->setupAssets('css', ['css/growl', 'css/animate']);
        $this->setupAssets('js', ['js/bootstrap-growl']);
        parent::init();
    }
}
