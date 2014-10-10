<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.1.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Html5Input widget is a widget encapsulating the HTML 5 inputs.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class Html5Input extends InputWidget
{

    /**
     * @var string the HTML 5 input type
     */
    public $type;

    /**
     * @var string the width in 'px' or '%' of the HTML5 input container
     */
    public $width;

    /**
     * @var array the HTML attributes for the widget container
     */
    public $containerOptions = [];

    /**
     * @var array the HTML attributes for the HTML-5 input.
     */
    public $html5Options = [];

    /**
     * @var array the HTML attributes for the HTML-5 input container
     */
    public $html5Container = [];

    /**
     * @var string/boolean the message shown for unsupported browser. If set to false
     * will not be displayed
     */
    public $noSupport = 'Its recommended you use an upgraded browser to display the {type} control properly.';

    /**
     * @var string array the HTML attributes for container displaying unsupported browser message
     */
    public $noSupportOptions = [];

    /**
     * @var string one of the SIZE modifiers 'lg', 'md', 'sm', 'xs'
     */
    public $size;

    /**
     * @var array the addon content
     * - prepend: array/string the prepend addon content. If set as an array, the
     *   following options can be set:
     *   - content: string the prepend addon content
     *   - asButton: boolean whether the addon is a button
     *   - options: array the HTML attributes for the prepend addon
     * - append: array/string the append addon content. If set as an array, the
     *   following options can be set:
     *   - content: string the append addon content
     *   - asButton: boolean whether the addon is a button
     *   - options: array the HTML attributes for the append addon
     * - preCaption: array/string the addon content placed before the caption. If
     *   set as an array, the following options can be set:
     *   - content: string the append addon content
     *   - asButton: boolean whether the addon is a button
     *   - options: array the HTML attributes for the append addon     */
    public $addon = [];

    /**
     * @var array the special inputs which need captions
     */
    private static $_specialInputs = [
        'color',
        'range'
    ];

    /**
     * Runs the widget
     */
    public function init()
    {
        parent::init();
        $this->initInput();
    }

    protected function initInput()
    {
        if (in_array($this->type, self::$_specialInputs)) {
            $this->html5Options['id'] = $this->options['id'] . '-source';
            $this->registerAssets();
            echo $this->renderInput();
        } else {
            ArrayHelper::merge($this->options, $this->html5Options);
            if (isset($this->size)) {
                Html::addCssClass($this->options, ['class' => 'input-' . $this->size]);
            }
            echo $this->getHtml5Input();
        }
    }

    /**
     * Gets the HTML5 input
     * return string
     */
    protected function getHtml5Input()
    {
        if ($this->hasModel()) {
            return Html::activeInput($this->type, $this->model, $this->attribute, $this->options);
        }
        return Html::input($this->type, $this->name, $this->value, $this->options);
    }

    /**
     * Renders the special HTML5 input
     * Mainly useful for the color and range inputs
     */
    protected function renderInput()
    {
        Html::addCssClass($this->options, 'form-control');
        $size = isset($this->size) ? ' input-group-' . $this->size : '';
        Html::addCssClass($this->containerOptions, 'input-group input-group-html5' . $size);
        $style = empty($this->html5Container['style']) ? '' : $this->html5Container['style'] . ';';
        if (isset($this->width) && ($this->width > 0)) {
            $this->html5Container['style'] = $style . 'width:' . $this->width . ';';
        }
        Html::addCssClass($this->html5Container, 'input-group-addon addon-' . $this->type);
        $caption = $this->getInput('textInput');
        $value = $this->hasModel() ? $this->model[Html::getAttributeName($this->attribute)] : $this->value;
        $input = Html::input($this->type, $this->html5Options['id'], $value, $this->html5Options);
        $prepend = static::getAddonContent(ArrayHelper::getValue($this->addon, 'prepend', ''));
        $append = static::getAddonContent(ArrayHelper::getValue($this->addon, 'append', ''));
        $preCaption = static::getAddonContent(ArrayHelper::getValue($this->addon, 'preCaption', ''));
        $prepend .= Html::tag('span', $input, $this->html5Container);
        $content = Html::tag('div', $prepend . $preCaption . $caption . $append, $this->containerOptions);
        Html::addCssClass($this->noSupportOptions, 'alert alert-warning');
        if ($this->noSupport == false) {
            $message = '';
        } else {
            $message = "\n<br>" . Html::tag('div', Yii::t('app', $this->noSupport, ['type' => $this->type]), $this->noSupportOptions);
        }
        return "<!--[if lt IE 10]>\n{$caption}{$message}\n<![endif]--><![if gt IE 9]>\n{$content}\n<![endif]>";
    }

    /**
     * Parses and returns addon content
     *
     * @param string /array $addon the addon parameter
     * @return string
     */
    protected static function getAddonContent($addon)
    {
        if (is_array($addon)) {
            $content = ArrayHelper::getValue($addon, 'content', '');
            $options = ArrayHelper::getValue($addon, 'options', []);
            if (ArrayHelper::getValue($addon, 'asButton', false) == true) {
                Html::addCssClass($options, 'input-group-btn');
                return Html::tag('div', $content, $options);
            } else {
                Html::addCssClass($options, 'input-group-addon');
                return Html::tag('span', $content, $options);
            }
        }
        return $addon;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        Html5InputAsset::register($view);
        $caption = 'jQuery("#' . $this->options['id'] . '")';
        $input = 'jQuery("#' . $this->html5Options['id'] . '")';
        $js = "{$caption}.change(function(){{$input}.val(this.value)});\n" .
            "{$input}.change(function(){{$caption}.val(this.value); {$caption}.trigger('change');});";
        $view->registerJs($js);
    }
}
