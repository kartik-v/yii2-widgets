<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 2.9.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\FormatConverter;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use kartik\datecontrol\DateControl;

/**
 * DatePicker widget is a Yii2 wrapper for the Bootstrap DatePicker plugin. The
 * plugin is a fork of Stefan Petre's DatePicker (of eyecon.ro), with improvements
 * by @eternicode.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://eternicode.github.io/bootstrap-datepicker/
 */
class DatePicker extends InputWidget
{

    const TYPE_INPUT = 1;
    const TYPE_COMPONENT_PREPEND = 2;
    const TYPE_COMPONENT_APPEND = 3;
    const TYPE_INLINE = 4;
    const TYPE_RANGE = 5;

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
     * @var ActiveForm the ActiveForm object which you can pass for seamless usage
     * with ActiveForm. This property is especially useful for client validation of
     * attribute2 for [[TYPE_RANGE]] validation
     */
    public $form;

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * @var string The addon that will be prepended/appended for a
     * [[TYPE_COMPONENT_PREPEND]] and [[TYPE_COMPONENT_APPEND]]
     */
    public $addon = '<i class="glyphicon glyphicon-calendar"></i>';

    /**
     * @var string the model attribute 2 if you are using [[TYPE_RANGE]]
     * for markup.
     */
    public $attribute2;

    /**
     * @var string the name of input number 2 if you are using [[TYPE_RANGE]]
     * for markup
     */
    public $name2;
    
    /**
     * @var string the name of value for input number 2 if you are using [[TYPE_RANGE]]
     * for markup
     */
    public $value2 = null;

    /**
     * @var array the HTML attributes for the input number 2 tag.
     * if you are using [[TYPE_RANGE]] for markup
     */
    public $options2 = [];

    /**
     * @var string the range input separator
     * if you are using [[TYPE_RANGE]] for markup.
     * Defaults to 'to'
     */
    public $separator = 'to';

    /**
     * @var string identifier for the target DatePicker element
     */
    private $_id;

    /**
     * @var array the HTML options for the DatePicker container
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
        if ($this->type === self::TYPE_RANGE && $this->attribute2 === null && $this->name2 === null) {
            throw new InvalidConfigException("Either 'name2' or 'attribute2' properties must be specified for a datepicker 'range' markup.");
        }
        if ($this->type === self::TYPE_RANGE && !class_exists('\\kartik\\field\\FieldRangeAsset')) {
            throw new InvalidConfigException("The yii2-field-range extension is not installed and is a pre-requisite for a DatePicker RANGE type. To install this extension run this command on your console: \n\nphp composer.phar require kartik-v/yii2-field-range \"*\"");
        }
        if ($this->type < 1 || $this->type > 5 || !is_int($this->type)) {
            throw new InvalidConfigException("Invalid value for the property 'type'. Must be an integer between 1 and 5.");
        }
        if (isset($this->form) && !($this->form instanceof \yii\widgets\ActiveForm)) {
            throw new InvalidConfigException("The 'form' property must be of type \\yii\\widgets\\ActiveForm");
        }
        if (isset($this->form) && !$this->hasModel()) {
            throw new InvalidConfigException("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
        if (isset($this->form) && ($this->type === self::TYPE_RANGE) && (!isset($this->attribute2))) {
            throw new InvalidConfigException("The 'attribute2' property must be set for a 'range' type markup and a defined 'form' property.");
        }
        $this->initLanguage();
        if (!isset($this->pluginOptions['format'])){
            $format = Yii::$app->formatter->dateFormat;
            if (strncmp($this->dateFormat, 'php:', 4) === 0) {
                $this->pluginOptions['format'] = static::convertDateFormat(substr($format, 4));
            } else {
                $format = FormatConverter::convertDateIcuToPhp($format, 'date');
                $this->pluginOptions['format'] = static::convertDateFormat($format);
            }
        } elseif ($this->convertFormat && isset($this->pluginOptions['format'])) {
            $this->pluginOptions['format'] = static::convertDateFormat($this->pluginOptions['format']);
        }
        $this->_id = ($this->type == self::TYPE_INPUT) ? 'jQuery("#' . $this->options['id'] . '")' : 'jQuery("#' . $this->options['id'] . '").parent()';
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Renders the source input for the DatePicker plugin.
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

        if (isset($this->form) && ($this->type !== self::TYPE_RANGE)) {
            $vars = call_user_func('get_object_vars', $this);
            unset($vars['form']);
            return $this->form->field($this->model, $this->attribute)->widget(self::classname(), $vars);
        }

        return $this->parseMarkup($this->getInput('textInput'));
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
            return Html::tag('div', "<span class='input-group-addon'>{$this->addon}</span>{$input}", $this->_container);
        }
        if ($this->type == self::TYPE_COMPONENT_APPEND) {
            Html::addCssClass($this->_container, 'date');
            return Html::tag('div', "{$input}<span class='input-group-addon'>{$this->addon}</span>", $this->_container);
        }
        if ($this->type == self::TYPE_RANGE) {
            Html::addCssClass($this->_container, 'input-daterange');
            if (isset($this->form)) {
                Html::addCssClass($this->options, 'form-control kv-field-from');
                Html::addCssClass($this->options2, 'form-control kv-field-to');
                $input = $this->form->field($this->model, $this->attribute, [
                    'template' => '{input}{error}',
                    'options' => ['class' => 'kv-container-from form-control'],
                ])->textInput($this->options);
                $input2 = $this->form->field($this->model, $this->attribute2, [
                    'template' => '{input}{error}',
                    'options' => ['class' => 'kv-container-to form-control'],
                ])->textInput($this->options2);
            } else {
                if (empty($this->options2['id'])) {
                    $this->options2['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute2) : $this->getId() . '-2';
                }
                Html::addCssClass($this->options2, 'form-control');
                $input2 = $this->hasModel() ?
                    Html::activeTextInput($this->model, $this->attribute2, $this->options2) :
                    Html::textInput($this->name2, $this->value2, $this->options2);
            }
            return Html::tag('div', "{$input}<span class='input-group-addon kv-field-separator'>{$this->separator}</span>{$input2}", $this->_container);
        }
        if ($this->type == self::TYPE_INLINE) {
            $this->_id = $this->options['id'] . '-inline';
            $this->_container['id'] = $this->_id;
            return Html::tag('div', '', $this->_container) . $input;
        }
    }

    /**
     * Registers the needed client assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        if (!empty($this->pluginOptions['language'])) {
            DatePickerAsset::register($view)->js[] = 'js/locales/bootstrap-datepicker.' . $this->pluginOptions['language'] . '.js';
        } else {
            DatePickerAsset::register($view);
        }
        $id = "jQuery('#" . $this->options['id'] . "')";
        if ($this->type == self::TYPE_INLINE) {
            $this->pluginEvents = ArrayHelper::merge($this->pluginEvents, ['changeDate' => 'function (e) { ' . $id . '.val(e.format());} ']);
        }
        if ($this->type === self::TYPE_INPUT) {
            $this->registerPlugin('datepicker');
        } elseif ($this->type === self::TYPE_RANGE && isset($this->form)) {
            $this->registerPlugin('datepicker', "{$id}.parent().parent()");
        } else {
            $this->registerPlugin('datepicker', "{$id}.parent()");
        }
        if ($this->type === self::TYPE_RANGE) {
            \kartik\field\FieldRangeAsset::register($view);
        }
    }
}
