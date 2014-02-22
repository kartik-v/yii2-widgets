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
 * Switch widget is a Yii2 wrapper for the Bootstrap Switch plugin by Mattia, Peter, & Emanuele. 
 * This input widget is a jQuery based replacement for checkboxes and radio buttons and converts
 * them to toggle switches. 
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://www.bootstrap-switch.org/
 */
class SwitchInput extends InputWidget
{

    const CHECKBOX = 1;
    const RADIO = 2;

    /**
     * @var integer the input type - one
     * of the constants above.
     */
    public $type = self::CHECKBOX;

    /**
     * @var array the list of items for radio input
     * (applicable only if `type` = 2). The following 
     * keys could be setup:
     * - label: string the label of each radio item. If this is 
     *   set to false or null, the label will not be displayed.
     * - value: string the value of each radio item
     * - options: HTML attributes for the radio item
     * - labelOptions: HTML attributes for each radio item label
     */
    public $items = [];

    /**
     * @var array default HTML attributes for each radio item
     * (applicable only if `type` = 2)
     */
    public $itemOptions = [];

    /**
     * @var array default HTML attributes for each radio item label
     */
    public $labelOptions = [];

    /**
     * @var string the separator content between each radio item
     * (applicable only if `type` = 2)
     */
    public $separator = " &nbsp;";

    /**
     * @var array HTML attributes for the radio group container
     * (applicable only if `type` = 2)
     */
    public $containerOptions = [];

    /**
     * @var string the generated name of the radio switch element(s)
     */
    private $_name;

    /**
     * Initializes the widget
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->type) && $this->type !== self::CHECKBOX && $this->type !== self::RADIO) {
            throw new InvalidConfigException("You must define a valid 'type' which must be either 1 (for checkbox) or 2 (for radio).");
        }
        if ($this->type == self::RADIO) {
            if (empty($this->items) || !is_array($this->items)) {
                throw new InvalidConfigException("You must setup the 'items' array for the 'radio' type.");
            }
            $this->_name = $this->hasModel() ? ArrayHelper::remove($this->options, 'name', static::getInputName($model, $attribute)) : $this->name;
        }
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Renders the source Input for the Switch plugin.
     * Graceful fallback to a normal HTML checkbox or radio input
     * in case JQuery is not supported by the browser
     */
    protected function renderInput()
    {
        if ($this->type == self::CHECKBOX) {
            return $this->getInput('checkbox');
        }
        $output = '';
        foreach ($this->items as $item) {
            if (!is_array($item)) {
                continue;
            }
            $label = ArrayHelper::getValue($item, 'label', false);
            $options = ArrayHelper::getValue($item, 'options', []) + $this->itemOptions;
            $labelOptions = ArrayHelper::getValue($item, 'labelOptions', []) + $this->labelOptions;
            $value = ArrayHelper::getValue($item, 'value', null);
            $output .= Html::label($label, $this->_name, $labelOptions) . "\n" .
                    Html::radio($this->_name, $value, $options) . "\n" .
                    $this->separator;
        }
        if (empty($this->containerOptions['class'])) {
            $this->containerOptions['class'] = 'form-group';
        }
        return Html::tag('div', $output, $this->containerOptions) . "\n";
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        SwitchInputAsset::register($view);
        if (!isset($this->pluginOptions['animate'])) {
            $this->pluginOptions['animate'] = true;
        }
        if (empty($this->_name)) {
            $this->registerPlugin('bootstrapSwitch');
        }
        else {
            $this->registerPlugin('bootstrapSwitch', '$("[name = \'' . $this->_name . '\']")');
        }
    }

}