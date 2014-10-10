<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.1.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for DatePicker Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DatePickerAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/lib/bootstrap-datepicker');
        $this->setupAssets('css', ['css/datepicker3', 'css/datepicker-kv']);
        $this->setupAssets('js', ['js/bootstrap-datepicker']);
        parent::init();
    }
}
