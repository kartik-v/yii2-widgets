<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Base input widget class for yii2-widgets
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class InputWidget extends \yii\widgets\InputWidget
{

    /**
     * @var array the data (for list inputs)
     */
    public $data = [];

    /**
     * @var array widget plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array widget JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     *        "change" => "function() { log("change"); }",
     *        "open" => "function() { log("open"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @var string the hashed variable to store the pluginOptions
     */
    protected $_hashVar;

    /**
     * @var string the Json encoded options
     */
    protected $_encOptions = '';

    public function init()
    {
        parent::init();
        if ($this->hasModel()) {
            $this->name = ArrayHelper::remove($this->options, 'name', Html::getInputName($this->model, $this->attribute));
            $this->value = $this->model[Html::getAttributeName($this->attribute)];
        }
    }

    /**
     * Adds an asset to the view
     *
     * @param $view View object
     * @param $file string the asset file name
     * @param $file string the asset file type (css or js)
     * @param $class string the class name of the AssetBundle
     */
    protected function addAsset($view, $file, $type, $class)
    {
        if ($type == 'css' || $type == 'js') {
            $asset = $view->getAssetManager();
            $bundle = $asset->bundles[$class];
            if ($type == 'css') {
                $bundle->css[] = $file;
            } else {
                $bundle->js[] = $file;
            }
            $asset->bundles[$class] = $bundle;
            $view->setAssetManager($asset);
        }
    }

    /**
     * Generates an input
     */
    protected function getInput($type, $list = false)
    {
        if ($this->hasModel()) {
            $input = 'active' . ucfirst($type);
            return $list ?
                Html::$input($this->model, $this->attribute, $this->data, $this->options) :
                Html::$input($this->model, $this->attribute, $this->options);
        }
        $input = $type;
        $checked = false;
        if ($type == 'radio' || $type == 'checkbox') {
            $this->options['value'] = $this->value;
            $checked = ArrayHelper::remove($this->options, 'checked', false);
        }
        return $list ?
            Html::$input($this->name, $this->value, $this->data, $this->options) :
            (($type == 'checkbox' || $type == 'radio') ?
                Html::$input($this->name, $checked, $this->options) :
                Html::$input($this->name, $this->value, $this->options));
    }

    /**
     * Generates a hashed variable to store the pluginOptions. The following special data attributes
     * will also be setup for the input widget, that can be accessed through javascript:
     * - 'data-plugin-options' will store the hashed variable storing the plugin options.
     * - 'data-plugin-name' the name of the plugin
     *
     * @param string $name the name of the plugin
     */
    protected function hashPluginOptions($name)
    {
        $this->_encOptions = empty($this->pluginOptions) ? '' : Json::encode($this->pluginOptions);
        $this->_hashVar = $name . '_' . hash('crc32', $this->_encOptions);
        $this->options['data-plugin-name'] = $name;
        $this->options['data-plugin-options'] = $this->_hashVar;
    }

    /**
     * Registers plugin options by storing it in a hashed javascript variable
     */
    protected function registerPluginOptions($name) {
        $this->hashPluginOptions($name);
        $encOptions = empty($this->_encOptions) ? '{}' : $this->_encOptions;
        $view->registerJs("var {$this->_hashVar} = {$encOptions};\n", $view::POS_HEAD);    
    }
    
    /**
     * Registers a specific plugin and the related events
     *
     * @param string $name the name of the plugin
     * @param string $element the plugin target element
     */
    protected function registerPlugin($name, $element = null)
    {
        $id = ($element == null) ? "jQuery('#" . $this->options['id'] . "')" : $element;
        $view = $this->getView();
        if ($this->pluginOptions !== false) {
            $this->registerPluginOptions($name);
            $view->registerJs("{$id}.{$name}({$this->_hashVar});");
        }

        if (!empty($this->pluginEvents)) {
            $js = [];
            foreach ($this->pluginEvents as $event => $handler) {
                $function = new JsExpression($handler);
                $js[] = "{$id}.on('{$event}', {$function});";
            }
            $js = implode("\n", $js);
            $view->registerJs($js);
        }
    }

}