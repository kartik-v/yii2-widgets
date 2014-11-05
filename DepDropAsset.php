<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.3.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for Dependent Dropdown widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DepDropAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/dependent-dropdown');
        $this->setupAssets('css', ['css/dependent-dropdown']);
        $this->setupAssets('js', ['js/dependent-dropdown']);
        parent::init();
    }
}
