<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use yii\base\InvalidConfigException;

/**
 * Dependent Dropdown widget is a wrapper widget for the dependent-dropdown
 * JQuery plugin by Krajee. The plugin enables setting up dependent dropdowns
 * with nested dependencies.
 *
 * @see http://plugins.krajee.com/dependent-dropdown
 * @see http://github.com/kartik-v/dependent-dropdown
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0.0
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
        if (empty($this->pluginOptions['url'])) {
            throw new InvalidConfigException("The 'pluginOptions[\"url\"]' property has not been set.");
        }
        if (empty($this->pluginOptions['depends']) || !is_array($this->pluginOptions['depends'])) {
            throw new InvalidConfigException("The 'pluginOptions[\"depends\"]' property must be set and must be an array of dependent dropdown element ID.");
        }
        if (empty($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }
        parent::init();
        $this->registerAssets();
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