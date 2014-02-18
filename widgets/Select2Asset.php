<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for Select2 Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Select2Asset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/../lib/select2');
        $this->setupAssets('css', ['select2', 'select2-bootstrap3']);
        $this->setupAssets('js', ['select2']);
        parent::init();
    }

}