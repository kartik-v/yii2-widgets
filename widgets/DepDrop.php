<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Dependent Dropdown widget is a wrapper widget for the dependent-dropdown
 * JQuery plugin by Krajee. The plugin enables setting up dependent dropdowns
 * with nested dependencies.
 *
 * @see http://plugins.krajee.com/dependent-dropdown
 * @see http://github.com/kartik-v/dependent-dropdown
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0.0
 */
class DepDrop extends InputWidget
{
    const TYPE_DEFAULT = 1;
    const TYPE_SELECT2 = 2;

    /**
     * @var int the type of the dropdown element.
     * - 1 or [[DepDrop::TYPE_DEFAULT]] will render using \yii\helpers\Html::dropDownList
     * - 2 or [[DepDrop::TYPE_SELECT2]] will render using \kartik\widgets\Select2 widget
     */
    public $type = self::TYPE_DEFAULT;

    /**
     * @var array the configuration options for the Select2 widget. Applicable
     * only if the `type` property is set to [[DepDrop::TYPE_SELECT2]].
     */
    public $select2Options = [];

    /**
     * @var \yii\web\View instance
     */
    private $_view;

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        if (empty($this->pluginOptions['url'])) {
            throw new InvalidConfigException("The 'pluginOptions[\"url\"]' property has not been set.");
        }
        if (empty($this->pluginOptions['depends']) || !is_array($this->pluginOptions['depends'])) {
            throw new InvalidConfigException("The 'pluginOptions[\"depends\"]' property must be set and must be an array of dependent dropdown element ID.");
        }
        if (empty($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }
        parent::init();
        if ($this->type !== self::TYPE_SELECT2 && !empty($this->options['placeholder'])) {
            $this->data = ['' => $this->options['placeholder']] + $this->data;
        }
        if ($this->type === self::TYPE_SELECT2 &&
            (!empty($this->options['placeholder']) || !empty($this->select2Options['options']['placeholder']))
        ) {
            $this->pluginOptions['placeholder'] = '';
        } elseif ($this->type === self::TYPE_SELECT2 && !empty($this->pluginOptions['placeholder']) && $this->pluginOptions['placeholder'] !== false) {
            $this->options['placeholder'] = $this->pluginOptions['placeholder'];
            $this->pluginOptions['placeholder'] = '';
        }
        $this->_view = $this->getView();
        $this->registerAssets();
        if ($this->type === self::TYPE_SELECT2) {
            if (empty($this->data)) {
                $this->data = ['' => ''];
            }
            if ($this->hasModel()) {
                $settings = ArrayHelper::merge($this->select2Options, [
                    'model' => $this->model,
                    'attribute' => $this->attribute,
                    'data' => $this->data,
                    'options' => $this->options
                ]);
            } else {
                $settings = ArrayHelper::merge($this->select2Options, [
                    'name' => $this->name,
                    'value' => $this->value,
                    'data' => $this->data,
                    'options' => $this->options
                ]);
            }
            echo Select2::widget($settings);

            $id = 'jQuery("#' . $this->options['id'] . '")';
            $text = ArrayHelper::getValue($this->pluginOptions, 'loadingText', 'Loading ...');
            $this->_view->registerJs("{$id}.on('depdrop.beforeChange',function(e,i,v){{$id}.select2('data',{text: '{$text}'});});");
            $this->_view->registerJs("{$id}.on('depdrop.change',function(e,i,v,c){{$id}.select2('val',{$id}.val());});");
        } else {
            echo $this->getInput('dropdownList', true);
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        DepDropAsset::register($this->_view);
        $this->registerPlugin('depdrop');
    }

}