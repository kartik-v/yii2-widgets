<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 3.3.0
 */

namespace kartik\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * TouchSpin widget is a Yii2 wrapper for the bootstrap-touchspin plugin by
 * István Ujj-Mészáros. This input widget is a mobile and touch friendly input
 * spinner component for Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://www.virtuosoft.eu/code/bootstrap-touchspin/
 */
class TouchSpin extends InputWidget
{

    /**
     * @var array HTML attributes for the `up` button. The following special
     * attributes are recognized
     * - icon: string the glyphicon prefix which will be used for the button label
     * - label: string the label which will be printed after the icon. This is
     *   not HTML encoded.
     */
    public $upOptions = ['icon' => 'forward', 'class' => 'btn btn-default'];

    /**
     * @var array HTML attributes for the `down` button. The following special
     * attributes are recognized
     * - icon: string the glyphicon prefix which will be used for the button label
     * - label: string the label which will be printed after the icon. This is
     *   not HTML encoded.
     */
    public $downOptions = ['icon' => 'backward', 'class' => 'btn btn-default'];

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->setPluginOptions();
        $this->registerAssets();
        echo $this->getInput('textInput');
    }

    /**
     * Set the plugin options
     */
    protected function setPluginOptions()
    {
        $defaults = [];
        Html::addCssClass($this->upOptions, 'bootstrap-touchspin-up');
        Html::addCssClass($this->downOptions, 'bootstrap-touchspin-down');
        $defaults['buttonup'] = $this->renderButton($this->upOptions);
        $defaults['buttondown'] = $this->renderButton($this->downOptions);
        $this->pluginOptions = array_replace($defaults, $this->pluginOptions);
        if (ArrayHelper::getValue($this->pluginOptions, 'verticalbuttons', false) 
            && empty($this->pluginOptions['prefix'])) {
            Html::addCssClass($this->options, 'input-left-rounded');
        }
    }

    /**
     * Renders the touchspin button
     *
     * @param array $options the button html options
     * @return string
     */
    protected function renderButton($options = [])
    {
        if (!empty($this->options['disabled']) && $this->options['disabled'] == true) {
            $options['disabled'] = true;
        }
        $label = ArrayHelper::remove($options, 'label', '');
        $icon = ArrayHelper::remove($options, 'icon', '');
        if ($icon != '') {
            $icon = "<i class='glyphicon glyphicon-{$icon}'></i>";
            $label = ($label != '') ? $icon . ' ' . $label : $icon;
        }
        $options['type'] = 'button';
        return Html::button($label, $options);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $id = 'jQuery("#' . $this->options['id'] . '").parent()';  //unused
        TouchSpinAsset::register($view);
        $this->registerPlugin('TouchSpin');
    }
}
