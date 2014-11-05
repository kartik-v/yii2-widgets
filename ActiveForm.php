<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.3.0
 */

namespace kartik\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Extends the ActiveForm widget to handle various
 * bootstrap form types.
 *
 * Example(s):
 * ```php
 * // Horizontal Form
 * $form = ActiveForm::begin([
 *      'id' => 'form-signup',
 *      'type' => ActiveForm::TYPE_HORIZONTAL
 * ]);
 * // Inline Form
 * $form = ActiveForm::begin([
 *      'id' => 'form-login',
 *      'type' => ActiveForm::TYPE_INLINE
 *      'fieldConfig' => ['autoPlaceholder'=>true]
 * ]);
 * // Horizontal Form Configuration
 * $form = ActiveForm::begin([
 *      'id' => 'form-signup',
 *      'type' => ActiveForm::TYPE_HORIZONTAL
 *      'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
 * ]);
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ActiveForm extends \yii\widgets\ActiveForm
{

    const NOT_SET = '';
    const DEFAULT_LABEL_SPAN = 2; // this will offset the adjacent input accordingly
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
     * @var int set the bootstrap grid width. Defaults to [[ActiveForm::FULL_SPAN]].
     */
    public $fullSpan = self::FULL_SPAN;

    /**
     * @var array the configuration for the form
     *
     * ```
     * [
     *      'labelSpan' => 2, // must be between 1 and 12
     *      'deviceSize' => ActiveForm::SIZE_MEDIUM, // must be one of the SIZE modifiers
     *      'showLabels' => true, // show or hide labels (mainly useful for inline type form)
     *      'showErrors' => true // show or hide errors (mainly useful for inline type form)
     * ],
     * ```
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
    protected function initForm()
    {
        if (!isset($this->type) || strlen($this->type) == 0) {
            $this->type = self::TYPE_VERTICAL;
        }
        $this->formConfig = ArrayHelper::merge($this->_config[$this->type], $this->formConfig);
        if (!isset($this->fieldConfig['class'])) {
            $this->fieldConfig['class'] = ActiveField::className();
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
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (!is_int($this->fullSpan) && $this->fullSpan < 1) {
            throw new InvalidConfigException("The 'fullSpan' property must be a valid positive integer.");
        }
        $this->registerAssets();
        $this->initForm();
        $config = $this->formConfig;
        $span = $config['labelSpan'];
        $size = $config['deviceSize'];
        $formStyle = $this->getFormLayoutStyle();
        $labelCss = $formStyle['labelCss'];
        $this->_inputCss = $formStyle['inputCss'];
        $this->_offsetCss = $formStyle['offsetCss'];

        if ($span != self::NOT_SET && intval($span) > 0) {
            $span = intval($span);

            /* Validate if invalid labelSpan is passed - else set to DEFAULT_LABEL_SPAN */
            if ($span <= 0 && $span >= $this->fullSpan) {
                $span = self::DEFAULT_LABEL_SPAN;
            }

            /* Validate if invalid deviceSize is passed - else default to medium */
            if ($size == self::NOT_SET) {
                $size = self::SIZE_MEDIUM;
            }

            $prefix = "col-{$size}-";
            $labelCss = $prefix . $span;
            $this->_inputCss = $prefix . ($this->fullSpan - $span);
            $this->_offsetCss = "col-" . $size . "-offset-" . $span . " " . $this->_inputCss;
        }

        if ($this->_inputCss == self::NOT_SET && empty($this->fieldConfig['template'])) {
            $this->fieldConfig['template'] = "{label}\n{input}\n{error}\n{hint}";
        }

        if ($config['showLabels'] === false) {
            Html::addCssClass($this->fieldConfig['labelOptions'], self::SCREEN_READER);
        } elseif ($labelCss != self::NOT_SET) {
            Html::addCssClass($this->fieldConfig['labelOptions'], $labelCss);
        }

        parent::init();
    }

    public function getFormLayoutStyle() {
        $config = $this->formConfig;
        $span = $config['labelSpan'];
        $size = $config['deviceSize'];
        $labelCss = $inputCss = $offsetCss = self::NOT_SET;

        if ($span != self::NOT_SET && intval($span) > 0) {
            $span = intval($span);

            /* Validate if invalid labelSpan is passed - else set to DEFAULT_LABEL_SPAN */
            if ($span <= 0 && $span >= $this->fullSpan) {
                $span = self::DEFAULT_LABEL_SPAN;
            }

            /* Validate if invalid deviceSize is passed - else default to medium */
            if ($size == self::NOT_SET) {
                $size = self::SIZE_MEDIUM;
            }

            $prefix = "col-{$size}-";
            $labelCss = $prefix . $span;
            $inputCss = $prefix . ($this->fullSpan - $span);
            $offsetCss =  "col-" . $size . "-offset-" . $span . " " . $inputCss;
        }
        return ['labelCss'=> $labelCss, 'inputCss'=>$inputCss, 'offsetCss'=>$offsetCss];
    }
    
    /**
     * Gets input css property
     *
     * @return string
     */
    public function getInputCss()
    {
        return $this->_inputCss;
    }

    /**
     * Sets input css property
     */
    public function setInputCss($class)
    {
        $this->_inputCss = $class;
    }

    /**
     * Checks if input css property is set
     *
     * @return bool
     */
    public function hasInputCss()
    {
        return ($this->_inputCss != self::NOT_SET);
    }

    /**
     * Gets offset css property
     *
     * @return string
     */
    public function getOffsetCss()
    {
        return $this->_offsetCss;
    }

    /**
     * Sets offset css property
     */
    public function setOffsetCss($class)
    {
        $this->_offsetCss = $class;
    }

    /**
     * Checks if offset css property is set
     *
     * @return bool
     */
    public function hasOffsetCss()
    {
        return ($this->_offsetCss != self::NOT_SET);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        ActiveFormAsset::register($view);
    }
}