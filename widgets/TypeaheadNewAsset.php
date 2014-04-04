<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for Typeahead Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TypeaheadNewAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/../assets');
        $this->setupAssets('css', ['css/typeahead']);
        $this->setupAssets('js', ['js/typeahead.bundle']);
        parent::init();
    }

}