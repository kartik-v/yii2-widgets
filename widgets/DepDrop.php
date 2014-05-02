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
 * Dependent Dropdown widget is a wrapper widget for the dependent-dropdown
 * JQuery plugin by Krajee. The plugin enables setting up dependent dropdowns
 * with nested dependencies.
 *
 * @see http://plugins.krajee.com/dependent-dropdown
 * @see http://github.com/kartik-v/dependent-dropdown
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DepDrop extends InputWidget
{
    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
        if (empty($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }
        echo $this->getInput('dropdownList', true);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        DepDropAsset::register($view);
        $this->registerPlugin('depdrop');
    }

}