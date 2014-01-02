<?php

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\View;
use yii\web\JsExpression;

/**
 * Datepicker widget is a Yii2 wrapper for the Bootstrap Datepicker plugin. The
 * plugin is a fork of Stefan Petre's Datepicker (of eyecon.ro), with improvements
 * by @eternicode. 
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://eternicode.github.io/bootstrap-datepicker/
 */
class Datepicker extends \yii\widgets\InputWidget {

	const TYPE_INPUT = 1;
	const TYPE_COMPONENT_PREPEND = 2;
	const TYPE_COMPONENT_APPEND = 3;
	const TYPE_RANGE = 4;
	const TYPE_INLINE = 5;
	
    /**
     * @var ActiveForm the form object to which this
     * input will be attached to in case you are using 
	 * the widget within an ActiveForm
     */
    public $form;

    /**
     * @var string the markup type of widget markup
	 * must be one of the TYPE constants. Defaults
	 * to [[TYPE_COMPONENT_APPEND]]
     */
    public $type = self::TYPE_COMPONENT_APPEND;
	
    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];
	
	/**
	 * @var array the datepicker plugin options
	 * @see http://bootstrap-datepicker.readthedocs.org/en/latest/options.html
	 */
	public $pluginOptions = [];
	
    /**
     * @var array Datepicker JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     * 		"show" => "function(e) {  # `e` here contains the extra attributes }",
     * 		"hide" => "function(e) {  # `e` here contains the extra attributes }",
     * 		"clearDate" => "function(e) {  # `e` here contains the extra attributes }",
     * 		"changeDate" => "function(e) {  # `e` here contains the extra attributes }",
     * 		"changeYear" => "function(e) {  # `e` here contains the extra attributes }",
     * 		"changeMonth" => "function(e) {  # `e` here contains the extra attributes }",
     * ~~~
	 * @see http://bootstrap-datepicker.readthedocs.org/en/latest/events.html
     */
    public $pluginEvents = [];
	
    /**
     * Initializes the widget
     * @throw InvalidConfigException
     */
    public function init() {
        parent::init();
        if (isset($this->form) && !($this->form instanceof \kartik\widgets\ActiveForm)) {
            throw new InvalidConfigException("The 'form' property must be an object of type 'kartik\\widgets\\ActiveForm'.");
        }
        if (isset($this->form) && !$this->hasModel()) {
            throw new InvalidConfigException("You must set the 'model' and 'attribute' when you are using the widget with ActiveForm.");
        }
        $this->registerAssets();
        $this->renderInput();
    }

    /**
     * Renders the source Input for the Datepicker plugin.
     * Graceful fallback to a normal HTML  text input - in 
	 * case JQuery is not supported by the browser
     */
    protected function renderInput() {
		if (isset($this->form)) {
			$input = $this->form->field($this->model, $this->attribute)->textInput($this->options);
		}
		elseif ($this->hasModel()) {
			$input = Html::activeTextInput($this->model, $this->attribute, $this->options);
		}
		else {
			$input = Html::textInput($this->name, $this->value, $this->options);
		}
    }
	
	/**
	 * Validates and sets plugin options
	 */
	protected function setPluginOptions() {
		$i = 1;
		$data = [];
		foreach ($this->dataset as $d) {
			/* Generate name */
			if (empty($d['name'])) {
				$d['name'] = $this->options['id'] . '-ta-' . $i;
			}
			/* Parse engine */
			if (!empty($d['engine']) && !$d['engine'] instanceof JsExpression) {
				$d['engine'] = new JsExpression($d['engine']);
			}
			/* Add a spinning indicator for remote calls */
			if (!empty($d['remote'])) {
				$r = is_array($d['remote']) ? $d['remote'] : ['url' => $d['remote']];        
				$hint = '$("#' . $this->options['id'] . '").parent().children(".tt-hint")';
				if (empty($r['beforeSend'])) {
					$r['beforeSend'] = new JsExpression("function (xhr) { {$hint}.addClass('loading'); }");
				}
				if (empty($r['filter'])) {
					$r['filter'] = new JsExpression("function (parsedResponse) { {$hint}.removeClass('loading'); return parsedResponse; }");
				}
				$d['remote'] = $r;
			}
			$data[] = $d;
			$i++;
		}
		$this->_pluginOptions = Json::encode($data);
	}
	
    /**
     * Adds an asset to the view
     */
    protected function addAsset($view, $file, $type) {
        if ($type == 'css' || $type == 'js') {
            $asset = $view->getAssetManager();
            $name = DatepickerAsset::classname();
            $bundle = $asset->bundles[$name];
            if ($type == 'css') {
                $bundle->css[] = $file;
            }
            else {
                $bundle->js[] = $file;
            }
            $asset->bundles[$name] = $bundle;
            $view->setAssetManager($asset);
        }
    }
	
    /**
     * Registers the needed assets
     */
    public function registerAssets() {
        $view = $this->getView();
        DatepickerAsset::register($view);
        if (!empty($this->pluginOptions['language'])) {
            $this->addAsset($view, 'js/locales/bootstrap.datepicker.' . $this->pluginOptions['language'] . '.js', 'js');
        }
        $id = '$("#' . $this->options['id'] . '")';
		$this->setPluginOptions();
        $js = "{$id}.datepicker(" . Json::encode($this->pluginOptions) . ");";
        if (!empty($this->pluginEvents)) {
            $js .= "\n{$id}";
            foreach ($this->pluginEvents as $event => $function) {
                $func = new JsExpression($function);
                $js .= ".on('{$event}', {$func})\n";
            }
        }
        $view->registerJs($js);
    }

}
