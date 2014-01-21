<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Base widget class for yii2-widgets
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class InputWidget extends \yii\widgets\InputWidget {

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
    protected function addAsset($view, $file, $type, $class) {
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
     * Registers a specific plugin and the related events
     * @param string $name the name of the plugin
     */
    protected function registerPlugin($name) {
        $id = $this->options['id'];
        $view = $this->getView();
        if ($this->pluginOptions !== false) {
            $options = empty($this->pluginOptions) ? '' : Json::encode($this->pluginOptions);
            $js = "jQuery('#{$id}').{$name}({$options});";
            $view->registerJs($js);
        }

        if (!empty($this->pluginEvents)) {
            $js = [];
            foreach ($this->pluginEvents as $event => $handler) {
                $function = new JsExpression($handler);
                $js[] = "jQuery('#{$id}').on('{$event}', {$function});";
            }
            $js = implode("\n", $js);
            $view->registerJs($js);
        }
    }

}
