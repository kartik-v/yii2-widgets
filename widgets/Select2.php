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
use yii\base\InvalidConfigException;
use yii\web\View;
use yii\web\JsExpression;

/**
 * Select2 widget is a Yii2 wrapper for the Select2 jQuery plugin. This
 * input widget is a jQuery based replacement for select boxes. It supports
 * searching, remote data sets, and infinite scrolling of results. The widget
 * is specially styled for Twitter Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://ivaynberg.github.com/select2/
 */
class Select2 extends \yii\widgets\InputWidget {

	const LARGE = 'lg';
	const MEDIUM = 'md';
	const SMALL = 'sm';
	
    /**
     * @var mixed the locale ID (e.g. 'fr', 'de') for the language to be used by the Select2 Widget.
     * If this property set to false, the widget will use English (en).
     */
    public $language = false;

    /**
     * @var ActiveForm the form object to which this
     * input will be attached to in case you are using 
     * the widget within an ActiveForm
     */
    public $form;

    /**
     * @var array input options for the ActiveForm input
     * applicable only if the [[form]] property is set
     */
    public $inputOptions = [];

	/**
	 * @var array addon to prepend or append to the Select2 widget
	 * - prepend: array the prepend addon configuration
	 *     - content: string the prepend addon content
	 *     - asButton: boolean whether the addon is a button or button group. Defaults to false.
	 * - append: array the append addon configuration
	 *     - content: string the append addon content
	 *     - asButton: boolean whether the addon is a button or button group. Defaults to false.
	 * - groupOptions: array HTML options for the input group
	 * - contentBefore: string content placed before addon
	 * - contentAfter: string content placed after addon
	 */
	public $addon = [];

	/**
	 * @var size of the Select2 input, must be one of the 
	 * [[LARGE]], [[MEDIUM]] or [[SMALL]]. Defaults to [[MEDIUM]]
	 */
	public $size = self::MEDIUM;
	
    /**
     * @var array $data the option data items. The array keys are option values, and the array values
     * are the corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * [[\yii\helpers\ArrayHelper::map()]].
     */
    public $data;

    /**
     * @var boolean whether the widget will be used inside a bootstrap modal window.
     * Fixes [issue # 6](https://github.com/kartik-v/yii2-widgets/issues/6) on an
     * interoperability issue with bootstrap modal.
     */
    public $modal = false;

    /**
     * @var array the HTML attributes for the input tag. The following options are important:
     * - multiple: boolean whether multiple or single item should be selected. Defaults to false.
     * - placeholder: string placeholder for the select item.
     */
    public $options = [];

    /**
     * @var array Select2 JQuery plugin options 
     */
    public $pluginOptions = [];

    /**
     * @var array Select2 JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     * 		"change" => "function() { log("change"); }",
     * 		"open" => "function() { log("open"); }",
     * 		"select2-opening" => "function() { log("select2-opening"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @var boolean indicator for displaying text inputs
     * instead of select fields
     */
    private $_hidden = false;

    /**
     * Initializes the widget
     * @throw InvalidConfigException
     */
    public function init() {
        parent::init();
        $this->_hidden = !empty($this->pluginOptions['data']) ||
                !empty($this->pluginOptions['query']) ||
                !empty($this->pluginOptions['ajax']) ||
                !empty($this->pluginOptions['tags']);
        if (isset($this->form) && !($this->form instanceof \kartik\widgets\ActiveForm)) {
            throw new InvalidConfigException("The 'form' property must be an object of type '\\kartik\\widgets\\ActiveForm'.");
        }
        if (isset($this->form) && !$this->hasModel()) {
            throw new InvalidConfigException("You must set the 'model' and 'attribute' when you are using the widget with ActiveForm.");
        }
		if (empty($this->data) && !$this->_hidden) {
			throw new InvalidConfigException("No 'data' source found for Select2. Either the 'data' property must be set OR one of 'data', 'query', 'ajax', or 'tags' must be set within 'pluginOptions'.");
		}
        if (!empty($this->options['placeholder']) && !$this->_hidden && !in_array("", $this->data) &&
                (empty($this->options['multiple']) || $this->options['multiple'] == false)) {
            $this->data = array_merge(["" => ""], $this->data);
        }
        if (($this->_hidden || !isset($this->form)) && !isset($this->options['style'])) {
            $this->options['style'] = 'width: 100%';
        }
		if (empty($this->addon)) {
			$this->addon = ArrayHelper::remove($this->inputOptions, 'addon', []);
		}
        $this->registerAssets();
        $this->renderInput();
    }


    /**
     * Embeds the input group addon
     */
    protected function embedAddon($input) {
        if (!empty($this->addon)) {
            $addon = $this->addon;
			$prepend = ArrayHelper::getValue($addon, 'prepend', ''); ;
			$append = ArrayHelper::getValue($addon, 'append', ''); ;
            $group = ArrayHelper::getValue($addon, 'groupOptions', []);
			$size = isset($this->size) ? ' input-group-' . $this->size  : '';
			if (is_array($prepend)) {
				$content = ArrayHelper::getValue($prepend, 'content', ''); 
				if (isset($prepend['asButton']) && $prepend['asButton'] == true) {
					$prepend = Html::tag('div', $content, ['class' => 'input-group-btn']);
				}
				else {
					$prepend = Html::tag('span', $content, ['class' => 'input-group-addon']);
				}
				Html::addCssClass($group, 'input-group' . $size . ' select2-bootstrap-prepend');
			}
			if (is_array($append)) {
				$content = ArrayHelper::getValue($append, 'content', ''); 
				if (isset($append['asButton']) && $append['asButton'] == true) {
					$append = Html::tag('div', $content, ['class' => 'input-group-btn']);
				}
				else {
					$append = Html::tag('span', $content, ['class' => 'input-group-addon']);
				}
				Html::addCssClass($group, 'input-group' . $size . ' select2-bootstrap-append');
			}
            $addonText = $prepend . $input . $append;
            $contentBefore = ArrayHelper::getValue($addon, 'contentBefore', '');
            $contentAfter = ArrayHelper::getValue($addon, 'contentAfter', '');
            return Html::tag('div', $contentBefore . $addonText . $contentAfter, $group);
        }
		return $input;
    }
	
    /**
     * Renders the source Input for the Select2 plugin.
     * Graceful fallback to a normal HTML select dropdown
     * or text input - in case JQuery is not supported by 
     * the browser
     */
    protected function renderInput() {
		if (!isset($this->addon) && isset($this->size)) {
			Html::addCssClass($this->options, 'input-' . $this->size);
		}
		if (isset($this->form) && !empty($this->addon)) {
            $addon = $this->addon;
            $type = isset($addon['type']) ? $addon['type'] : 'prepend';
			$size = isset($this->size) ? ' input-group-' . $this->size  : '';
            $group = ArrayHelper::getValue($addon, 'groupOptions', []);
			if (!empty($addon['prepend'])) {
				Html::addCssClass($group, 'input-group' . $size . ' select2-bootstrap-prepend');
			}
			if (!empty($addon['append'])) {
				Html::addCssClass($group, 'input-group' . $size . ' select2-bootstrap-append');
			}
			$addon['groupOptions'] = $group;
			$this->inputOptions['addon'] = $addon;
		}
        if ($this->_hidden) {
            if (isset($this->form)) {
                $input = $this->form->field($this->model, $this->attribute, $this->inputOptions)->textInput($this->options);
            }
            elseif ($this->hasModel()) {
                $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
            }
            else {
                $input = Html::textInput($this->name, $this->value, $this->options);
            }
        }
        else {
            if (isset($this->form)) {
                $input = $this->form->field($this->model, $this->attribute, $this->inputOptions)->dropDownList($this->data, $this->options);
            }
            elseif ($this->hasModel()) {
                $input = Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
            }
            else {
                $input = Html::dropDownList($this->name, $this->value, $this->data, $this->options);
            }
        }
		if (isset($this->form)) {
			echo $input;
		}
		else {
			echo $this->embedAddon($input);
		}
    }

    /**
     * Adds an asset to the view
     */
    protected function addAsset($view, $file, $type) {
        if ($type == 'css' || $type == 'js') {
            $asset = $view->getAssetManager();
            $name = Select2Asset::classname();
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
        Select2Asset::register($view);
        if ($this->language != false) {
            $this->addAsset($view, 'select2_locale_' . $this->language . '.js', 'js');
        }
        $id = '$("#' . $this->options['id'] . '")';
		$this->pluginOptions['width'] = 'resolve';
        $js = "{$id}.select2(" . Json::encode($this->pluginOptions) . ");";
        if (!empty($this->pluginEvents)) {
            $js .= "\n{$id}";
            foreach ($this->pluginEvents as $event => $function) {
                $func = new JsExpression($function);
                $js .= ".on('{$event}', {$func})\n";
            }
        }
        if ($this->modal) {
            $js .= "\n$.fn.modal.Constructor.prototype.enforceFocus = function() {};";
        }
        $view->registerJs($js);
    }

}
