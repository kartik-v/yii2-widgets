<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for ActiveForm Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ActiveFormAsset extends AssetBundle {

    public function init() {
        $this->sourcePath = __DIR__ . '/../assets';
        $this->css = YII_DEBUG ? ['css/activeform.css'] : ['css/activeform.min.css'];
        parent::init();
    }

}
