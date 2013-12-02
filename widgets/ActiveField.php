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
	 * @var boolean whether the label is to be hidden and auto-displayed as a placeholder
	 */
	public $autoPlaceholder;
	
	/**
	 * @var boolean whether the input is to be offset (like for checkbox or radio).
	 */
	private $_offset = false;
	
	/**
	 * @var boolean the container for multi select
	 */
	private $_multiselect = '';
	
	/**
	 * Initializes the widget
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
	 * Initializes the addon for text inputs
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
			$class = ($this->_offset) ? $offsetDivClass : $inputDivClass;
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
		if ($this->_multiselect != '') {
			$this->template = str_replace('{input}', $this->_multiselect, $this->template);
		}
	}
	
	/**
	 * Renders a static input (display only).
	 * @param array $options the tag options in terms of name-value pairs.
	 * @return static the field object itself
	 */
	public function staticInput($options = []) {
		Html::addCssClass($options, 'form-control-static');
		$content = isset($this->model[$this->attribute]) ? $this->model[$this->attribute] : '-';
		$this->parts['{input}'] = Html::tag('p', $content, $options);
		return $this;
	}
	
	/**
	 * Renders an input tag.
	 * @param string $type the input type (e.g. 'text', 'password')
	 * @param array $options the tag options in terms of name-value pairs. These will be rendered as
	 * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
	 * @return static the field object itself
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
	 * This method will generate the "name" and "value" tag attributes automatically for the model attribute
	 * unless they are explicitly specified in `$options`.
	 * @param array $options the tag options in terms of name-value pairs. These will be rendered as
	 * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
	 * @return static the field object itself
	 */
	public function passwordInput1($options = [])
	{
		$this->initPlaceholder($options);
		return parent::passwordInput($options);
	}
	
	/**
	 * Renders a text area.
	 * The model attribute value will be used as the content in the textarea.
	 * @param array $options the tag options in terms of name-value pairs. These will be rendered as
	 * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
	 * @return static the field object itself
	 */
	public function textarea($options = [])
	{
		$this->initPlaceholder($options);
		return parent::textarea($options);
	}
	
	/**
	 * Renders a radio button.
	 * This method will generate the "checked" tag attribute according to the model attribute value.
	 * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
	 *
	 * - uncheck: string, the value associated with the uncheck state of the radio button. If not set,
	 *   it will take the default value '0'. This method will render a hidden input so that if the radio button
	 *   is not checked and is submitted, the value of this attribute will still be submitted to the server
	 *   via the hidden input.
	 * - label: string, a label displayed next to the radio button.  It will NOT be HTML-encoded. Therefore you can pass
	 *   in HTML code such as an image tag. If this is is coming from end users, you should [[Html::encode()]] it to prevent XSS attacks.
	 *   When this option is specified, the radio button will be enclosed by a label tag.
	 * - labelOptions: array, the HTML attributes for the label tag. This is only used when the "label" option is specified.
	 *
	 * The rest of the options will be rendered as the attributes of the resulting tag. The values will
	 * be HTML-encoded using [[Html::encode()]]. If a value is null, the corresponding attribute will not be rendered.
	 * @param boolean $enclosedByLabel whether to enclose the radio within the label.
	 * If true, the method will still use [[template]] to layout the checkbox and the error message
	 * except that the radio is enclosed by the label tag.
	 * @return static the field object itself
	 */
	public function radio($options = [], $enclosedByLabel = true) 
	{
		$this->_offset = true;
		return parent::radio($options, $enclosedByLabel);
	}
	
	/**
	 * Renders a checkbox.
	 * This method will generate the "checked" tag attribute according to the model attribute value.
	 * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
	 *
	 * - uncheck: string, the value associated with the uncheck state of the radio button. If not set,
	 *   it will take the default value '0'. This method will render a hidden input so that if the radio button
	 *   is not checked and is submitted, the value of this attribute will still be submitted to the server
	 *   via the hidden input.
	 * - label: string, a label displayed next to the checkbox.  It will NOT be HTML-encoded. Therefore you can pass
	 *   in HTML code such as an image tag. If this is is coming from end users, you should [[Html::encode()]] it to prevent XSS attacks.
	 *   When this option is specified, the checkbox will be enclosed by a label tag.
	 * - labelOptions: array, the HTML attributes for the label tag. This is only used when the "label" option is specified.
	 *
	 * The rest of the options will be rendered as the attributes of the resulting tag. The values will
	 * be HTML-encoded using [[Html::encode()]]. If a value is null, the corresponding attribute will not be rendered.
	 * @param boolean $enclosedByLabel whether to enclose the checkbox within the label.
	 * If true, the method will still use [[template]] to layout the checkbox and the error message
	 * except that the checkbox is enclosed by the label tag.
	 * @return static the field object itself
	 */
	public function checkbox($options = [], $enclosedByLabel = true) 
	{
		$this->_offset = true;
		return parent::checkbox($options, $enclosedByLabel);
	}
		
	/**
	 * Renders a list of checkboxes.
	 * A checkbox list allows multiple selection, like [[listBox()]].
	 * As a result, the corresponding submitted value is an array.
	 * The selection of the checkbox list is taken from the value of the model attribute.
	 * @param array $items the data item used to generate the checkboxes.
	 * The array values are the labels, while the array keys are the corresponding checkbox values.
	 * Note that the labels will NOT be HTML-encoded, while the values will.
	 * @param array $options options (name => config) for the checkbox list. The following options are specially handled:
	 *
	 * - unselect: string, the value that should be submitted when none of the checkboxes is selected.
	 *   By setting this option, a hidden input will be generated.
	 * - separator: string, the HTML code that separates items.
	 * - item: callable, a callback that can be used to customize the generation of the HTML code
	 *   corresponding to a single item in $items. The signature of this callback must be:
	 * - inline: boolean, whether the list should be displayed as a series on the same line, default is false
	 *
	 * ~~~
	 * function ($index, $label, $name, $checked, $value)
	 * ~~~
	 *
	 * where $index is the zero-based index of the checkbox in the whole list; $label
	 * is the label for the checkbox; and $name, $value and $checked represent the name,
	 * value and the checked status of the checkbox input.
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
	 * A radio button list is like a checkbox list, except that it only allows single selection.
	 * The selection of the radio buttons is taken from the value of the model attribute.
	 * @param array $items the data item used to generate the radio buttons.
	 * The array keys are the labels, while the array values are the corresponding radio button values.
	 * Note that the labels will NOT be HTML-encoded, while the values will.
	 * @param array $options options (name => config) for the radio button list. The following options are specially handled:
	 *
	 * - unselect: string, the value that should be submitted when none of the radio buttons is selected.
	 *   By setting this option, a hidden input will be generated.
	 * - separator: string, the HTML code that separates items.
	 * - item: callable, a callback that can be used to customize the generation of the HTML code
	 *   corresponding to a single item in $items. The signature of this callback must be:
	 * - inline: boolean, whether the list should be displayed as a series on the same line, default is false
	 *
	 * ~~~
	 * function ($index, $label, $name, $checked, $value)
	 * ~~~
	 *
	 * where $index is the zero-based index of the radio button in the whole list; $label
	 * is the label for the radio button; and $name, $value and $checked represent the name,
	 * value and the checked status of the radio button input.
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
	 * - height: string, the height of the multiselect control - defaults to 145px
	 * - selector: string, whether checkbox or radio - defaults to checkbox
	 * - container: array, options for the multiselect container
	 * - unselect: string, the value that should be submitted when none of the radio buttons is selected.
	 *   By setting this option, a hidden input will be generated.
	 * - separator: string, the HTML code that separates items.
	 * - item: callable, a callback that can be used to customize the generation of the HTML code
	 *   corresponding to a single item in $items. The signature of this callback must be:
	 * - inline: boolean, whether the list should be displayed as a series on the same line, default is false	 * @param string $selector 
	 *
	 */	
	public function multiselect($items, $options = [])
	{
		$height = static::MULTI_SELECT_HEIGHT;
		$selector = static::TYPE_CHECKBOX;
		$container = [];
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
			$container = $options['container'];
			unset($options['container']);
		}
		Html::addCssClass($container, 'form-control');
		$style = isset($container['style']) ? $container['style'] : '';
		$container['style'] = $style . "height: {$height}; overflow: auto;";
		$this->_multiselect = Html::tag('div', '{input}', $container);
		
		if ($selector == static::TYPE_RADIO) {
			return static::radioList($items, $options);
		}
		else {
			return static::checkboxList($items, $options);
		}
	}
}
