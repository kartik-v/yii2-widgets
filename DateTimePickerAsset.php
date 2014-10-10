<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.1.0
 */

namespace kartik\widgets;

/**
 * Asset bundle for DateTimePicker Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateTimePickerAsset extends AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/lib/bootstrap-datetimepicker');
        $this->setupAssets('css', ['css/bootstrap-datetimepicker']);
        $this->setupAssets('js', ['js/bootstrap-datetimepicker']);
        parent::init();
    }
}
