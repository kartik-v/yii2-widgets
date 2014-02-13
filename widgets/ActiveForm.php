<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use yii\helpers\Html;

/**
 * Extends the ActiveForm widget to handle various
 * bootstrap form types.
 *
 * Example(s):
 * ```php
 * // Horizontal Form
 * $form = ActiveForm::begin([
 * 		'id' => 'form-signup', 
 * 		'type' => ActiveForm::TYPE_HORIZONTAL
 * ]);
 * // Inline Form
 * $form = ActiveForm::begin([
 * 		'id' => 'form-login', 
 * 		'type' => ActiveForm::TYPE_INLINE
 * 		'fieldConfig' => ['labelAsPlaceholder'=>true]
 * ]);
 * // Horizontal Form Configuration
 * $form = ActiveForm::begin([
 * 		'id' => 'form-signup', 
 * 		'type' => ActiveForm::TYPE_HORIZONTAL
 * 		'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
 * ]);
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ActiveForm extends \yii\widgets\ActiveForm {

    const NOT_SET = '';
    const DEFAULT_LABEL_SPAN = 2;  // this will offset the adjacent input accordingly
    const FULL_SPAN = 12; // bootstrap default full grid width

    /* Form Types */
    const TYPE_VERTICAL = 'vertical';
    const TYPE_HORIZONTAL = 'horizontal';
    const TYPE_INLINE = 'inline';

    /* Size Modifiers */
    const SIZE_TINY = 'xs';
    const SIZE_SMALL = 'sm';
    const SIZE_MEDIUM = 'md';
    const SIZE_LARGE = 'lg';

    /* Label Display Settings */
    const SCREEN_READER = 'sr-only';

    /**
     * @var string form orientation type (for bootstrap styling)
     * Defaults to 'vertical'.
     */
    public $type;

    /**
     * @var array the configuration for the form
     * 	[
     *      'labelSpan' => 2, // must be between 1 and 12
     * 	    'deviceSize' => ActiveForm::SIZE_MEDIUM, // must be one of the SIZE modifiers
     * 	    'showLabels' => true, // show or hide labels (mainly useful for inline type form)
     *      'showErrors' => true // show or hide errors (mainly useful for inline type form)
     * 	],
     */
    public $formConfig = [];

    /**
     * @var string the extra input container css class for horizontal forms 
     * and special inputs like checkbox and radio. 
     */
    private $_inputCss;

    /**
     * @var string the offset class for error and hint for horizontal forms
     * or for special inputs like checkbox and radio.
     */
    private $_offsetCss;

    /**
     * @var array the default form configuration
     */
    private $_config = [
        self::TYPE_VERTICAL => [
            'labelSpan' => self::NOT_SET, // must be between 1 and 12
            'deviceSize' => self::NOT_SET, // must be one of the SIZE modifiers
            'showLabels' => true, // show or hide labels (mainly useful for inline type form)
            'showErrors' => true, // show or hide errors (mainly useful for inline type form)
        ],
        self::TYPE_HORIZONTAL => [
            'labelSpan' => self::DEFAULT_LABEL_SPAN,
            'deviceSize' => self::SIZE_MEDIUM,
            'showLabels' => true,
            'showErrors' => true,
        ],
        self::TYPE_INLINE => [
            'labelSpan' => self::NOT_SET,
            'deviceSize' => self::NOT_SET,
            'showLabels' => false,
            'showErrors' => false,
        ],
    ];

    /**
     * Initializes the form configuration array
     * and parameters for the form.
     */
    protected function initForm() {
        if (!isset($this->type) || strlen($this->type) == 0) {
            $this->type = self::TYPE_VERTICAL;
        }
        $this->formConfig = $this->formConfig + $this->_config[$this->type];
        if (!isset($this->fieldConfig['class'])) {
            $this->fieldConfig['class'] = \kartik\widgets\ActiveField::className();
        }
        $this->_inputCss = self::NOT_SET;
        $this->_offsetCss = self::NOT_SET;
        $class = 'form-' . $this->type;
        /* Fixes the button alignment for inline forms containing error block */
        if ($this->type == self::TYPE_INLINE && $this->formConfig['showErrors']) {
            $class .= ' ' . $class . '-block';
        }
        Html::addCssClass($this->options, $class);
    }

    /**
     * Initializes the widget.
     */
    public function init() {
        $this->registerAssets();
        $this->initForm();
        $config = $this->formConfig;
        $span = $config['labelSpan'];
        $size = $config['deviceSize'];
        $labelCss = self::NOT_SET;

        if ($span != self::NOT_SET && intval($span) > 0) {
            $span = intval($span);

            /* Validate if invalid labelSpan is passed - else set to DEFAULT_LABEL_SPAN */
            if ($span <= 0 && $span >= self::FULL_SPAN) {
                $span = self::DEFAULT_LABEL_SPAN;
            }

            /* Validate if invalid deviceSize is passed - else default to medium */
            if ($size == self::NOT_SET) {
                $size = self::SIZE_MEDIUM;
            }

            $prefix = "col-{$size}-";
            $labelCss = $prefix . $span;
            $this->_inputCss = $prefix . (self::FULL_SPAN - $span);
            $this->_offsetCss = "col-" . $size . "-offset-" . $span . " " . $this->_inputCss;
        }

        if ($this->_inputCss == self::NOT_SET) {
            $this->fieldConfig['template'] = "{label}\n{input}\n{error}\n{hint}";
        }

        if ($config['showLabels'] === false) {
            Html::addCssClass($this->fieldConfig['labelOptions'], self::SCREEN_READER);
        }
        elseif ($labelCss != self::NOT_SET) {
            Html::addCssClass($this->fieldConfig['labelOptions'], $labelCss);
        }

        parent::init();
    }

    public function getInputCss() {
        return $this->_inputCss;
    }

    public function setInputCss($class) {
        $this->_inputCss = $class;
    }

    public function hasInputCss() {
        return ($this->_inputCss != self::NOT_SET);
    }

    public function getOffsetCss() {
        return $this->_offsetCss;
    }

    public function setOffsetCss($class) {
        $this->_offsetCss = $class;
    }

    public function hasOffsetCss() {
        return ($this->_offsetCss != self::NOT_SET);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets() {
        $view = $this->getView();
        ActiveFormAsset::register($view);
    }

}
