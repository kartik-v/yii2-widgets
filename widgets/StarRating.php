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
 * StarRating widget is a simple star rating widget 
 * that converts a 'number' input to a star rating
 * control using JQuery. The widget is styled for
 * Twitter Bootstrap 3.0.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class StarRating extends InputWidget
{

    const LARGE = 'rating-lg';
    const MEDIUM = 'rating-md';
    const SMALL = 'rating-sm';
    const TINY = 'rating-xs';

    /**
     * @var string the star rating size
     */
    public $size = self::MEDIUM;

    /**
     * @var string the reset label
     */
    public $resetLabel = '<i class="glyphicon glyphicon-minus-sign"></i>';

    /**
     * @var array the HTML attributes for the reset label 
     */
    public $resetLabelOptions = [];

    /**
     * @var float the value to reset the control to
     */
    public $resetValue = 0;

    /**
     * @var string the title to be displayed on reset
     */
    public $resetTitle = 'Not Rated';

    /**
     * @var string the reset title CSS class
     */
    public $resetTitleClass = 'label label-default';

    /**
     * @var array the titles to be displayed for each star rating. 
     * Enter these as key value pairs, where the array key is the
     * star rating and the array value is the title for the star. 
     * If a title is not set, it will default to each star's 
     * rating value;
     */
    public $starTitles = [
        1 => 'One Star',
        2 => 'Two Stars',
        3 => 'Three Stars',
        4 => 'Four Stars',
        5 => 'Five Stars',
    ];

    /**
     * @var array the classes to be displayed for each title of the 
     * star rating. Enter these as key value pairs, where the array 
     * key is the star rating and the array value is the CSS class  
     * for the star title. 
     */
    public $starTitleClasses = [
        1 => 'label label-danger',
        2 => 'label label-warning',
        3 => 'label label-info',
        4 => 'label label-primary',
        5 => 'label label-success',
    ];

    /**
     * @var boolean whether to enable Right to Left input support
     */
    public $rtl = false;

    /**
     * @var array the HTML attributes for the star rating input
     * The number input is usually hidden. The input will be displayed 
     * instead of the star rating control in these circumstances:
     * - if the browser does not support JQuery/CSS3 (< IE9)
     * - if javascript is disabled on the browser
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the star rating container
     */
    public $containerOptions = [];

    /**
     * Initializes the widget
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->containerOptions['id'] = $this->options['id'] . '-container';
        $this->options['min'] = ArrayHelper::getValue($this->options, 'min', 1);
        $this->options['max'] = ArrayHelper::getValue($this->options, 'max', 5);
        $this->options['step'] = ArrayHelper::getValue($this->options, 'step', 1);
        $this->registerAssets();
        $this->renderInput();
    }

    protected function getStars()
    {
        $begin = $end = '';
        for ($i = $this->options['min']; $i <= $this->options['max']; $i += $this->options['step']) {
            $begin .= (!empty($this->value) && $i <= $this->value) ? '<s class="rated">' : '<s>';
            $end .= '</s>';
        }
        return $begin . $end;
    }

    /**
     * Renders the source Input for the Star Rating plugin as a HTML 5 Number input
     */
    protected function renderInput()
    {
        $input = $this->parseInput();
        $class = (($this->rtl) ? 'star-rating-rtl' : 'star-rating') . ' ' . $this->size;
        Html::addCssClass($this->containerOptions, $class);
        Html::addCssClass($this->resetLabelOptions, 'reset');
        if (empty($this->resetLabelOptions['title'])) {
            $this->resetLabelOptions['title'] = Yii::t('app', 'Reset Rating');
        }
        $reset = Html::tag('div', $this->resetLabel, $this->resetLabelOptions);
        $stars = $this->getStars();
        $content = ($this->rtl) ? $stars . $reset : $reset . $stars;
        $title = ArrayHelper::getValue($this->starTitles, $this->value, $this->resetTitle);
        $titleClass = ArrayHelper::getValue($this->starTitleClasses, $this->value, $this->resetTitleClass);
        $title = '<div class="caption"><span class="' . $titleClass . '">' . $title . '</span></div>';
        $content = ($this->rtl) ? $title . $content : $content . $title;
        echo Html::tag('div', $content, $this->containerOptions) . "\n" . $input;
    }

    /**
     * Parse the basic input to be generated by validating 
     * IE browser version and if javascript is enabled.
     */
    protected function parseInput()
    {
        Html::addCssClass($options, 'form-control');
        if ($this->hasModel()) {
            $input = Html::activeInput('number', $this->model, $this->attribute, $options);
            $hidden = Html::activeHiddenInput($this->model, $this->attribute, $options);
        }
        else {
            $input = Html::input('number', $this->name, $this->value, $options);
            $hidden = Html::hiddenInput($this->name, $this->value, $options);
        }

        $content = <<< EOT
<!--[if lt IE 9]>
    {$input}
<![endif]-->
<![if gt IE 8]>
    {$hidden}
<![endif]>
<noscript>
    {$input}
</noscript>
EOT;
        return $content;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        StarRatingAsset::register($view);
        $id = '$("#' . $this->containerOptions['id'] . '")';
        $this->pluginOptions = [
            'input' => '#' . $this->options['id'],
            'starTitles' => $this->starTitles,
            'starTitleClasses' => $this->starTitleClasses,
            'resetTitle' => $this->resetTitle,
            'resetTitleClass' => $this->resetTitleClass,
            'resetValue' => $this->resetValue,
        ];
        $this->registerPlugin('rating', $id);
    }

}