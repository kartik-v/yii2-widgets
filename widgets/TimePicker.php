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
     * @var array/boolean the addon that will be prepended/appended
     * to the input. Contains th
     * - prepend array:
     *   - content: string the prepend addon content
     *   - options: array the HTML attributes for the prepend addon content 
     *   - buttonOptions: array/boolean the HTML attributes for the prepend addon 
     *     if it is to be displayed as a button. If set to false will not be displayed
     *     as a button
     * - append array:
     *   - content: string the append addon content
     *   - options: array the HTML attributes for the append addon content 
     *   - buttonOptions: array/boolean the HTML attributes for the append addon 
     *     if it is to be displayed as a button. If set to false will not be displayed
     *     as a button.
     */
    public $addon = [];

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
        if (!is_array($this->addon) || empty($this->addon) ||
                (empty($this->addon['prepend']) && empty($this->addon['append']))) {
            $this->addon = [
                'append' => [
                    'content' => '<i class="glyphicon glyphicon-time"></i>'
                ],
            ];
        }
        $this->registerAssets();
        echo Html::tag('div', $this->renderInput(), $this->containerOptions);
    }

    /**
     * Renders the input
     * @return string
     */
    protected function renderInput() {
        Html::addCssClass($this->options, 'form-control');
        Html::addCssClass($this->containerOptions, 'bootstrap-timepicker input-group');
        $prepend = $this->renderAddon(ArrayHelper::getValue($this->addon, 'prepend', []));
        $append = $this->renderAddon(ArrayHelper::getValue($this->addon, 'append', []));
        if (isset($this->size)) {
            Html::addCssClass($this->containerOptions, 'input-group-' . $this->size);
        }
        return $prepend . $this->getTextInput() . $append;
    }

    /**
     * Returns the rendered addon
     * @param array $addon settings
     * @return string
     */
    protected function renderAddon($addon) {
        if (empty($addon)) {
            return '';
        }
        $content = ArrayHelper::getValue($addon, 'content', false);
        $buttonOptions = ArrayHelper::getValue($addon, 'buttonOptions', false);
        $options = ArrayHelper::getValue($addon, 'options', []);
        if (is_array($buttonOptions)) {
            Html::addCssClass($options, 'input-group-btn picker');
            if (empty($buttonOptions)) {
                Html::addCssClass($buttonOptions, 'btn btn-default');
            }
            $content = Html::button($content, $buttonOptions);
        }
        else {
            Html::addCssClass($options, 'input-group-addon picker');
        }
        return Html::tag('span', $content, $options);
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
