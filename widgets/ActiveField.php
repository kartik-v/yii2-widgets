<?php
namespace kartik\widgets;

use yii\helpers\Html;

/**
 * Extends the ActiveField widget to handle various 
 * bootstrap form types and handle input groups.
 *
 * ADDITIONAL VARIABLES/PARAMETERS:
 * ===============================
 * @param boolean $hideLabel whether to hide the label for the field (default false)
 * @param boolean $labelAsPlaceholder whether to display the label as a placeholder (default false)
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

	/**
	 * @var array addon options for text and password inputs
	 */
	public $addon = [];
	
	
	/**
	 * @var boolean whether the label is to be displayed
	 */
	public $hideLabel = false;
	
	/**
	 * @var boolean whether the label is to be displayed as a placeholder
	 */
	public $labelAsPlaceholder;
	
	/**
	 * @var boolean whether the input is to be offset (like for checkbox or radio).
	 */
	private $_offsetInput = false;
	
	/**
	 * Initialize widget
	 */	
	public function init() {
		parent::init();
		if ($this->form->type === ActiveForm::TYPE_INLINE && !isset($this->labelAsPlaceholder)) {
			$this->labelAsPlaceholder = true;
		}
		elseif (!isset($this->labelAsPlaceholder)) {
			$this->labelAsPlaceholder = false;
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
	 * Initializes placeholder based on $labelAsPlaceholder
	 */
	protected function initPlaceholder(&$options) {
		if ($this->labelAsPlaceholder) {
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
		if ($this->hideLabel || $this->labelAsPlaceholder) {
			$this->template = str_replace("{label}\n", "", $this->template);
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
		return parent::checkbox($options, $enclosedByLabel);
	}
}
