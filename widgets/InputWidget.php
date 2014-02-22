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
     * 		"change" => "function() { log("change"); }",
     * 		"open" => "function() { log("open"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * Adds an asset to the view
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
            }
            else {
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
        return $list ?
                Html::$input($this->name, $this->value, $this->data, $this->options) :
                Html::$input($this->name, $this->value, $this->options);
    }

    /**
     * Registers a specific plugin and the related events
     * @param string $name the name of the plugin
     * @param string $element the plugin target element
     */
    protected function registerPlugin($name, $element = null)
    {
        $id = ($element == null) ? "jQuery('#" . $this->options['id'] . "')" : $element;
        $view = $this->getView();
        if ($this->pluginOptions !== false) {
            $options = empty($this->pluginOptions) ? '' : Json::encode($this->pluginOptions);
            $js = "{$id}.{$name}({$options});";
            $view->registerJs($js);
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