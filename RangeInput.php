<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.2.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;

/**
 * RangeInput widget is an enhanced widget encapsulating the HTML 5 range input.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class RangeInput extends Html5Input
{

    public $type = 'range';
    public $orientation;
    
    /**
     * @inherit doc
     */
    public function init() {
        if ($this->orientation == 'vertical') {
            Html::addCssClass($this->containerOptions, 'kv-range-vertical');
            $this->html5Options['orient'] = 'vertical';
        }
        parent::init();
    }
}
