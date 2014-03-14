<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\View;
use yii\web\JsExpression;

/**
 * ColorInput widget is an enhanced widget encapsulating the HTML 5 color input.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class ColorInput extends Html5Input
{

    /**
     * @var boolean whether to use the native HTML5 color input
     */
    public $useNative = false;

    /**
     * @var boolean whether to automatically polyfill for 
     * the HTML5 color input in an unsupported browser when
     * you have set `useNative` to true
     */    
    public $polyFill = false;
    
    private $_defaultOptions = [
        'showInput' => true,
        'showInitial' => true,
        'showPalette' => true,
        'showSelectionPalette' => true,
        'showAlpha' => true,
        'allowEmpty' => true,
        'preferredFormat' => 'hex',
        'palette' => [
            ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
                "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(255, 255, 255)"],
            ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
            ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)"],
            ["rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)"],
            ["rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)"],
            ["rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)"],
            ["rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
        ]
    ];

    public function init()
    {
        $this->type = 'color';
        $this->width = '60px';
        if (!$this->useNative) {
            Html::addCssClass($this->html5Container, 'input-group-sp');
        }
        parent::init();
        if (!$this->useNative) {
            $this->pluginOptions += $this->_defaultOptions;
            $this->registerPluginAssets();
        }
        elseif ($this->polyFill) {
            ColorInputAsset::register($this->getView());
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerPluginAssets()
    {
        $view = $this->getView();
        ColorInputAsset::register($view);
        $input = '$("#' . $this->html5Options['id'] . '")';
        $this->registerPlugin('spectrum', $input);
        $caption = '$("#' . $this->options['id'] . '")';
        $input = '$("#' . $this->html5Options['id'] . '")';
        $view->registerJs("{$caption}.change(function(){{$input}.spectrum('set', this.value)});\n");
   }

}