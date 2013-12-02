<?php
namespace kartik\widgets;

use yii\helpers\Html;

/**
 * Extends the ActiveField widget to handle various 
 * bootstrap form types and handle input groups.
 *
 * ADDITIONAL VARIABLES/PARAMETERS:
 * ===============================
 * @param boolean $autoPlaceholder whether to display the label as a placeholder (default false)
 * @param array $addon whether to prepend or append an addon to an input group - contains these keys:
 * 		- @param string $type whether 'prepend' or 'append'
 *		- @param string $content the addon content - this is not html encoded
 *		- @param boolean $asButton whether the addon is a button or button group
 *
 * Example(s):
 * ```php
 * 	echo $this->form->field($model, 'email', ['addon' => ['type'=>'prepend', 'content'=>'@']]);
 * 	echo $this->form->field($model, 'amount_paid', ['addon' => ['type'=>'append', 'content'=>'.00']]);
 * 	echo $this->form->field($model, 'phone', ['addon' => ['type'=>'prepend', 'content'=>'<i class="glyphicon glyphicon-phone']]);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */

 
/**
 * @author Kartik Visweswaran <kartik.visweswaran@krajee.com>
 * @since 2.0
 
 */
class ActiveField extends \yii\widgets\ActiveField
{
	const ADDON_PREPEND = 'prepend';
	const ADDON_APPEND  = 'append';
	
	const TYPE_RADIO    = 'radio';
	const TYPE_CHECKBOX = 'checkbox';
	const STYLE_INLINE  = 'inline';
	const MULTI_SELECT_HEIGHT = '145px';

	/**
	 * @var array addon options for text and password inputs
	 */
	public $addon = [];
	
	/**
	 * @var boolean whether the label is to be displayed as a placeholder
	 */
	public $autoPlaceholder;
	
	/**
	 * @var boolean whether the input is to be offset (like for checkbox or radio).
	 */
	private $_offsetInput = false;
	
	/**
	 * @var boolean the container for multi select
	 */
	private $_multiSelectContainer = '';
	
	/**
	 * Initialize widget
	 */	
	public function init() {
		parent::init();
		if ($this->form->type === ActiveForm::TYPE_INLINE && !isset($this->autoPlaceholder)) {
			$this->autoPlaceholder = true;
		}
		elseif (!isset($this->autoPlaceholder)) {
			$this->autoPlaceholder = false;
		}
		if ($this->form->type === ActiveForm::TYPE_HORIZONTAL) {
			Html::addCssClass($this->labelOptions, 'control-label');
		}
	}
	
	/**
	 * Renders the whole field.
	 * This method will generate the label, error tag, input tag and hint tag (if any), and
	 * assemble them into HTML according to [[template]].
	 * @param string|callable $content the content within the field container.
	 * If null (not set), the default methods will be called to generate the label, error tag and input tag,
	 * and use them as the content.
	 * If a callable, it will be called to generate the content. The signature of the callable should be:
	 *
	 * ~~~
	 * function ($field) {
	 *     return $html;
	 * }
	 * ~~~
	 *
	 * @return string the rendering result
	 */
	public function render($content = null)
	{
		$this->initTemplate();
		$this->initPlaceholder($this->inputOptions);
		$this->initAddon();
		return parent::render($content);
	}
	
	/**
	 * Initializes addon for inputs
	 */
	protected function initAddon() {
		if (!empty($this->addon)) {
			$addon = $this->addon;
			$type = isset($addon['type']) ? $addon['type'] : self::ADDON_PREPEND;
			if (isset($addon['asButton']) && $addon['asButton'] == true) {
				$tag = Html::tag('div', $addon['content'], ['class'=>'input-group-btn']);
			}
			else {
				$tag = Html::tag('span', $addon['content'], ['class'=>'input-group-addon']);
			}
			$addonText = ($type == self::ADDON_PREPEND) ? $tag . '{input}' : '{input}' . $tag;
			$addonText = "<div class='input-group'>{$addonText}</div>";
			$this->template = str_replace('{input}', $addonText, $this->template);
		}	
	}
	
	/**
	 * Initializes placeholder based on $autoPlaceholder
	 */
	protected function initPlaceholder(&$options) {
		if ($this->autoPlaceholder) {
			$label = Html::encode($this->model->getAttributeLabel($this->attribute));
			$this->inputOptions['placeholder'] = $label;
			$options['placeholder'] = $label;
		}
	}
	
	/**
	 * Initializes template for bootstrap 3 specific styling
	 */
	protected function initTemplate() {
		$inputDivClass = $this->form->getInputCss();
		$offsetDivClass = $this->form->getOffsetCss();
		if ($this->form->hasInputCss()) {
			$class = ($this->_offsetInput) ? $offsetDivClass : $inputDivClass;
			$input = "<div class='{$class}'>{input}</div>";
			$error = "{error}";
			$hint = "{hint}";
			if ($this->form->hasOffsetCss()) {
				$error = "<div class='{$offsetDivClass}'>{error}</div>";				
				$hint = "<div class='{$offsetDivClass}'>{hint}</div>";				
			}
			$this->template = "{label}\n{$input}\n{$error}\n{$hint}";
		}
		$showLabels = isset($this->form->formConfig['showLabels']) ? $this->form->formConfig['showLabels'] : true;
		if (!$showLabels || $this->autoPlaceholder) {
			$this->template = str_replace("{label}\n", "", $this->template);
		}
		if ($this->_multiSelectContainer != '') {
			$this->template = str_replace('{input}', $this->_multiSelectContainer, $this->template);
		}
	}
	
	/**
	 * Renders a static input (display only).
	 * @param array $options the tag options in terms of name-value pairs.
	 */
	public function staticInput($options = []) {
		Html::addCssClass($options, 'form-control-static');
		$content = isset($this->model[$this->attribute]) ? $this->model[$this->attribute] : '-';
		$this->parts['{input}'] = Html::tag('p', $content, $options);
		return $this;
	}
	
	/**
	 * Renders an input tag.
	 */
	public function input($type, $options = [])
	{
		if ($type !== 'range') {
			$options = array_merge($this->inputOptions, $options);
		}
		$this->parts['{input}'] = Html::activeInput($type, $this->model, $this->attribute, $options);
		return $this;
	}
	
	/**
	 * Renders a password input.
	 */	
	public function passwordInput($options = [])
	{
		$this->initPlaceholder($options);
		return parent::passwordInput($options);
	}
	
	/**
	 * Renders a text area.
	 */
	public function textarea($options = [])
	{
		$this->initPlaceholder($options);
		return parent::textarea($options);
	}
	
	/**
	 * Renders a checkbox.
	 */	
	public function checkbox($options = [], $enclosedByLabel = true) 
	{
		$this->_offsetInput = true;
		return parent::checkbox($options, $enclosedByLabel);
	}
	
	/**
	 * Renders a radio button
	 */	
	public function radio($options = [], $enclosedByLabel = true) 
	{
		$this->_offsetInput = true;
		return parent::radio($options, $enclosedByLabel);
	}
		
	/**
	 * Renders a list of checkboxes.
	 * @param array $options options (name => config) for the radio button list. In addition to checkboxList options 
	 * available in yii\widgets\ActiveField, the following additional options are specially handled:
	 *     - inline: boolean, whether the list should be displayed as a series on the same line, default is false
	 * @return static the field object itself
	 */
	public function checkboxList($items, $options = [])
	{
		if (isset($options['inline']) && $options['inline'] == true) {
			Html::addCssClass($options['itemOptions']['labelOptions'], self::TYPE_CHECKBOX . '-' . self::STYLE_INLINE);
			$options['itemOptions']['container'] = false;
			unset($options['inline']);
		}
		return parent::checkboxList($items, $options);
	}
	
	/**
	 * Renders a list of radio buttons.
	 * @param array $options options (name => config) for the radio button list. In addition to radioList options 
	 * available in yii\widgets\ActiveField, the following additional options are specially handled:
	 *     - inline: boolean, whether the list should be displayed as a series on the same line, default is false
	 * @return static the field object itself
	 */
	public function radioList($items, $options = [])
	{
		if (isset($options['inline']) && $options['inline'] == true) {
			Html::addCssClass($options['itemOptions']['labelOptions'], static::TYPE_RADIO . '-' . static::STYLE_INLINE);
			$options['itemOptions']['container'] = false;
			unset($options['inline']);
		}
		return parent::radioList($items, $options);
	}
	
	/**
	 * Renders a multi select list box. This control extends the checkboxList and radioList
	 * available in yii\widgets\ActiveField - to display a scrolling multi select list box.
	 * @param array $items the data item used to generate the checkboxes or radio.
	 * @param array $options the options for checkboxList or radioList. Additional parameters
	 *         - @param string height: the height of the multiselect control - defaults to 145px
	 *         - @param string selector: whether checkbox or radio - defaults to checkbox
	 *         - @param array container: options for the multiselect container
	 * @param string $selector 
	 *
	 */	
	public function multiselect($items, $options = [])
	{
		$height = static::MULTI_SELECT_HEIGHT;
		$selector = static::TYPE_CHECKBOX;
		$conOptions = [];
		$options['encode'] = false;
		if (isset($options['height'])) {
			$height = $options['height'];
			unset($options['height']);
		}
		if (isset($options['selector'])) {
			$selector = $options['selector'];
			unset($options['selector']);
		}
		if (isset($options['container'])) {
			$conOptions = $options['container'];
			unset($options['container']);
		}
		Html::addCssClass($conOptions, 'form-control');
		$style = isset($conOptions['style']) ? $conOptions['style'] : '';
		$conOptions['style'] = $style . "height: {$height}; overflow: auto;";
		$this->_multiSelectContainer = Html::tag('div', '{input}', $conOptions);
		
		if ($selector == static::TYPE_RADIO) {
			return static::radioList($items, $options);
		}
		else {
			return static::checkboxList($items, $options);
		}
	}
}
