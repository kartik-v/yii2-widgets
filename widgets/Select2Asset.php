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
 * Asset bundle for Select2 Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Select2Asset extends AssetBundle {

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        $this->sourcePath = __DIR__ . '/../lib/select2';
        $this->css = YII_DEBUG ? ['select2.css', 'select2-bootstrap3.css'] : ['select2.min.css', 'select2-bootstrap3.min.css'];
        $this->js = YII_DEBUG ? ['select2.js'] : ['select2.min.js'];
        parent::init();
    }

}
