<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * TimePicker widget is a Yii2 wrapper for the the JQuery plugin by rendom
 * and jdewit. Additional enhancements have been done to this timepicker input 
 * widget for compatibility with Twitter Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see https://github.com/rendom/bootstrap-3-timepicker
 * @see https://github.com/jdewit/bootstrap-timepicker
 */
class TimePicker extends InputWidget {

    /**
     * @var string the size of the input - 'lg', 'md', 'sm', 'xs'
     */
    public $size;

    /**
     * @var string/boolean the addon content
     */
    public $addon = '<i class="glyphicon glyphicon-time"></i>';

    /**
     * @var array HTML attributes for the addon container
     * the following special options are identified
     * - asButton: boolean if the addon is to be displayed like a button. 
     * - buttonOptions: array HTML attributes if the addon is to be 
     *   displayed like a button. If [[asButton]] is true, this will
     *   default to ['class' => 'btn btn-default']
     */
    public $addonOptions = [];

    /**
     * @var array HTML attributes for the input group container
     */
    public $containerOptions = [];

    /**
     * Initializes the widget
     * @throw InvalidConfigException
     */
    public function init() {
        parent::init();
        $this->registerAssets();
        echo Html::tag('div', $this->renderInput(), $this->containerOptions);
    }

    /**
     * Renders the input
     * @return string
     */
    protected function renderInput() {
        Html::addCssClass($this->options, 'form-control');
        if (ArrayHelper::getValue($this->pluginOptions, 'template', true) === false) {
            Html::addCssClass($this->containerOptions, 'bootstrap-timepicker');
            if (isset($this->size)) {
                Html::addCssClass($this->options, 'input-' . $this->size);
                return '<span class="inline-addon inline-addon-' . $this->size . '">' . $this->addon . '</span>' . $this->getTextInput();
            }
            return '<span class="inline-addon">' . $this->addon . '</span>' . $this->getTextInput();
        }
        Html::addCssClass($this->containerOptions, 'bootstrap-timepicker input-group');
        $asButton = ArrayHelper::remove($this->addonOptions, 'asButton', false);
        $buttonOptions = ArrayHelper::remove($this->addonOptions, 'buttonOptions', []);
        if ($asButton) {
            Html::addCssClass($this->addonOptions, 'input-group-btn picker');
            $buttonOptions['type'] = 'button';
            if (empty($buttonOptions['class'])) {
                Html::addCssClass($buttonOptions, 'btn btn-default');
            }
            $content = Html::button($this->addon, $buttonOptions);
        }
        else {
            Html::addCssClass($this->addonOptions, 'input-group-addon picker');
            $content = $this->addon;
        }
        $addon = Html::tag('span', $content, $this->addonOptions);
        if (isset($this->size)) {
            Html::addCssClass($this->containerOptions, 'input-group-' . $this->size);
        }
        return $this->getTextInput() . $addon;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets() {
        $view = $this->getView();
        TimePickerAsset::register($view);
        $this->registerPlugin('timepicker');
    }

}
