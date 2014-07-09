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

/**
 * DateTimePicker widget is a Yii2 wrapper for the Bootstrap DateTimePicker plugin by smalot
 * This is a fork of the DatePicker plugin by @eternicode and adds the time functionality.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://www.malot.fr/bootstrap-datetimepicker/
 */
class DateTimePicker extends InputWidget
{

    const TYPE_INPUT = 1;
    const TYPE_COMPONENT_PREPEND = 2;
    const TYPE_COMPONENT_APPEND = 3;
    const TYPE_INLINE = 4;

    /**
     * @var string the markup type of widget markup
     * must be one of the TYPE constants. Defaults
     * to [[TYPE_COMPONENT_PREPEND]]
     */
    public $type = self::TYPE_COMPONENT_PREPEND;

    /**
     * @var string The size of the input - 'lg', 'md', 'sm', 'xs'
     */
    public $size;
    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * @var mixed the calendar/time picker button configuration.
     * - if this is passed as a string, it will be displayed as is (will not be HTML encoded).
     * - if this is set to false, the picker button will not be displayed.
     * - if this is passed as an array (this is the DEFAULT) it will treat this as HTML attributes
     *   for the button (to be displayed as a Bootstrap addon). The following special keys are recognized;
     *   - icon - string, the bootstrap glyphicon name/suffix. Defaults to 'calendar'.
     *   - title - string, the title to be displayed on hover. Defaults to 'Select date & time'.
     */
    public $pickerButton = [];

    /**
     * @var mixed the calendar/time remove button configuration.
     * - if this is passed as a string, it will be displayed as is (will not be HTML encoded).
     * - if this is set to false, the remove button will not be displayed.
     * - if this is passed as an array (this is the DEFAULT) it will treat this as HTML attributes
     *   for the button (to be displayed as a Bootstrap addon). The following special keys are recognized;
     *   - icon - string, the bootstrap glyphicon name/suffix. Defaults to 'remove'.
     *   - title - string, the title to be displayed on hover. Defaults to 'Clear field'.
     */
    public $removeButton = [];

    /**
     * @var boolean whether the widget should automatically format the date from
     * the PHP DateTime format to the Bootstrap DateTimePicker plugin format
     * @see http://php.net/manual/en/function.date.php
     * @see http://www.malot.fr/bootstrap-datetimepicker/#options
     */
    public $convertFormat = false;

    /**
     * @var string identifier for the target DateTimePicker element
     */
    private $_id;

    /**
     * @var array the HTML options for the DateTimePicker container
     */
    private $_container = [];

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->type < 1 || $this->type > 4 || !is_int($this->type)) {
            throw new InvalidConfigException("Invalid value for the property 'type'. Must be an integer between 1 and 4.");
        }
        $this->initLanguage();
        if ($this->convertFormat && isset($this->pluginOptions['format'])) {
            $this->pluginOptions['format'] = static::convertDateFormat($this->pluginOptions['format']);
        }
        $this->_id = ($this->type == self::TYPE_INPUT) ? '$("#' . $this->options['id'] . '")' : '$("#' . $this->options['id'] . '").parent()';
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Renders the source input for the DateTimePicker plugin.
     * Graceful fallback to a normal HTML  text input - in
     * case JQuery is not supported by the browser
     */
    protected function renderInput()
    {
        if ($this->type == self::TYPE_INLINE) {
            if (empty($this->options['readonly'])) {
                $this->options['readonly'] = true;
            }
            if (empty($this->options['class'])) {
                $this->options['class'] = 'form-control input-sm text-center';
            }
        } else {
            Html::addCssClass($this->options, 'form-control');
        }
        return $this->parseMarkup($this->getInput('textInput'));
    }

    /**
     * Returns the addon to render
     *
     * @param array $options the HTML attributes for the addon
     * @param string $type whether the addon is the picker or remove
     * @return string
     */
    protected function renderAddon(&$options, $type = 'picker')
    {
        if ($options === false) {
            return '';
        }
        if (is_string($options)) {
            return $options;
        }
        Html::addCssClass($options, 'input-group-addon');
        $icon = ($type === 'picker') ? 'calendar' : 'remove';
        $icon = '<span class="glyphicon glyphicon-' . ArrayHelper::remove($options, 'icon', $icon) . '"></span>';
        if (empty($options['title'])) {
            $title = ($type === 'picker') ? Yii::t('app', 'Select date & time') : Yii::t('app', 'Clear field');
            if ($title != false) {
                $options['title'] = $title;
            }
        }
        return Html::tag('span', $icon, $options);
    }

    /**
     * Parses the input to render based on markup type
     *
     * @param string $input
     * @return string
     */
    protected function parseMarkup($input)
    {
        if ($this->type == self::TYPE_INPUT || $this->type == self::TYPE_INLINE) {
            if (isset($this->size)) {
                Html::addCssClass($this->options, 'input-' . $this->size);
            }
        } elseif (isset($this->size)) {
            Html::addCssClass($this->_container, 'input-group input-group-' . $this->size);
        } else {
            Html::addCssClass($this->_container, 'input-group');
        }
        if ($this->type == self::TYPE_INPUT) {
            return $input;
        }
        if ($this->type == self::TYPE_COMPONENT_PREPEND) {
            Html::addCssClass($this->_container, 'date');
            $addon = $this->renderAddon($this->pickerButton) . $this->renderAddon($this->removeButton, 'remove');
            return Html::tag('div', $addon . $input, $this->_container);
        }
        if ($this->type == self::TYPE_COMPONENT_APPEND) {
            Html::addCssClass($this->_container, 'date');
            $addon = $this->renderAddon($this->removeButton, 'remove') . $this->renderAddon($this->pickerButton);
            return Html::tag('div', $input . $addon, $this->_container);
        }
        if ($this->type == self::TYPE_INLINE) {
            $this->_id = $this->options['id'] . '-inline';
            $this->_container['id'] = $this->_id;
            return Html::tag('div', '', $this->_container) . $input;
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        if (!empty($this->pluginOptions['language'])) {
            DateTimePickerAsset::register($view)->js[] = 'js/locales/bootstrap-datetimepicker.' . $this->pluginOptions['language'] . '.js';
        } else {
            DateTimePickerAsset::register($view);
        }
        $id = "$('#" . $this->options['id'] . "')";
        if ($this->type == self::TYPE_INLINE) {
            $this->pluginOptions['linkField'] = $this->options['id'];
            if (!empty($this->pluginOptions['format'])) {
                $this->pluginOptions['linkFormat'] = $this->pluginOptions['format'];
            }
        }
        if ($this->type === self::TYPE_INPUT) {
            $this->registerPlugin('datetimepicker');
        } else {
            $this->registerPlugin('datetimepicker', "{$id}.parent()");
        }
    }
}
