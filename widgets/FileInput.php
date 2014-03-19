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
 * FileInput widget styled for Bootstrap 3.0 with ability to multiple file
 * selection and preview, format button styles and inputs. Runs on all modern
 * browsers supporting HTML5 File Inputs and File Processing API. For browser
 * versions IE9 and below, this widget will gracefully degrade to normal HTML
 * file input.
 *
 * Bootstrap related file input styling inspired by the blog article at:
 * http://www.abeautifulsite.net/blog/2013/08/whipping-file-inputs-into-shape-with-bootstrap-3/
 * and Jasny's File Input plugin at http://jasny.github.io/bootstrap/javascript/#fileinput
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class FileInput extends InputWidget
{

	/**
	 * @var array HTML attributes for the main widget container
	 */
	public $containerOptions = [];

	/**
	 * @var array HTML attributes for the file picker button. The following
	 * special options are additionally recognized:
	 * - icon: string the Bootstrap glyphicon suffix
	 * - label: the label for the button, this will be translated by Yii's i18n
	 */
	public $buttonOptions = [];

	/*
	 * @var array HTML attributes for the file removal/clearing button. The
	 * following special options are additionally recognized:
	 * - icon: string the Bootstrap glyphicon suffix
	 * - label: the label for the button, this will be translated by Yii's i18n
	 */
	public $removeOptions = [];

	/**
	 * @var array HTML attributes for the file upload button. The [[uploadRoute]]
	 * parameter if passed will be used as an action, else this button will
	 * default to a submit button. The following special options are additionally
	 * recognized:
	 * - icon: string the Bootstrap glyphicon suffix
	 * - label: the label for the button, this will be translated by Yii's i18n
	 */
	public $uploadOptions = [];

	/**
	 * @var mixed The upload route/action url to process file upload when the
	 * upload button is clicked. If this variable is not set, the upload button
	 * action will default to a 'form submit'. This can be set to false to
	 * make the upload button behave like a normal HTML button without any action.
	 * This maybe useful for triggering customized javascript or ajax calls.
	 */
	public $uploadRoute;

	/*
	 * @var array HTML attributes for the file(s) preview container
	 */
	public $previewOptions = [];

	/**
	 * @var array HTML attributes for the bootstrap input group enclosing the
	 * file caption, file picker button, removal button, and the upload button
	 */
	public $groupOptions = [];

	/*
	 * @var array HTML attributes for the selected file(s) caption
	 */
	public $captionOptions = ['class' => 'form-control'];

	/**
	 * @var boolean whether to display the file caption. Defaults to true.
	 */
	public $showCaption = true;

	/**
	 * @var boolean whether to display the file preview. Defaults to true.
	 */
	public $showPreview = true;

	/**
	 * @var boolean whether to display the remove button. Defaults to true.
	 */
	public $showRemove = true;

	/*
	 * @var boolean whether to display the upload button. Defaults to true.
	 */
	public $showUpload = true;

	/**
	 * @var boolean whether to display a warning message for browsers running
	 * IE9 and below. Defaults to true.
	 */
	public $showMessage = true;

	/*
	 * @var array HTML attributes for the container for the warning
	 * message for browsers running IE9 and below.
	 */
	public $messageOptions = ['class' => 'alert alert-warning'];

	/**
	 * @var array the internalization configuration for this widget
	 */
	public $i18n = [];

	/**
	 * @var boolean whether the widget is disabled
	 */
	private $_disabled = false;

	/**
	 * @var array initialize the FileInput widget
	 */
	public function init()
	{
		parent::init();
		Yii::setAlias('@fileinput', dirname(__FILE__));
		if (empty($this->i18n)) {
			$this->i18n = [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => '@fileinput/messages'
			];
		}
		$this->_disabled = (!empty($this->options['disabled']) && $this->options['disabled']);
		Yii::$app->i18n->translations['fileinput'] = $this->i18n;
		Html::addCssClass($this->containerOptions, 'file-input file-input-new');
		if (empty($this->containerOptions['id'])) {
			$this->containerOptions['id'] = $this->options['id'] . '-container';
		}
		if (empty($this->buttonOptions['id'])) {
			$this->buttonOptions['id'] = $this->options['id'] . '-button';
		}
		if (empty($this->previewOptions['id'])) {
			$this->previewOptions['id'] = $this->options['id'] . '-preview';
		}
		if (empty($this->captionOptions['id'])) {
			$this->captionOptions['id'] = $this->options['id'] . '-caption';
		}
		$remove = ($this->showRemove) ? $this->renderRemove() . ' ' : '';
		$upload = ($this->showUpload) ? $this->renderUpload() . ' ' : '';
		$input = $remove . $upload . $this->renderInput();
		if ($this->showCaption) {
			Html::addCssClass($this->groupOptions, 'input-group');
			$placement = ArrayHelper::remove($this->captionOptions, 'placement', 'before');
			$button = Html::tag('div', $input, ['class' => 'input-group-btn']);
			$caption = $this->renderCaption();
			$content = ($placement == 'after') ? $button . $caption : $caption . $button;
			$input = Html::tag('div', $content, $this->groupOptions);
		}
		if ($this->showPreview) {
			$preview = $this->renderPreview();
			$input = $preview . "\n" . $input;
		}
		$this->registerAssets();
		if ($this->showMessage) {
			$validation = $this->showPreview ? 'file preview and multiple file upload' : 'multiple file upload';
			$message = '<strong>' . Yii::t('fileinput', 'Note:') . '</strong> ' . Yii::t('fileinput', 'Your browser does not support {validation}. Try an alternative or more recent browser to access these features.', ['validation' => $validation]);
			$content = Html::tag('div', $message, $this->messageOptions);
			$input .= "\n<br>" . $this->validateIE($content);
		}
		echo Html::tag('div', $input, $this->containerOptions);
	}

	/**
	 * Validates and returns content based on IE browser version validation
	 *
	 * @param string $content
	 * @param string $validation
	 * @return string
	 */
	protected function validateIE($content, $validation = 'lt IE 10')
	{
		return "<!--[if {$validation}]>{$content}<![endif]-->";
	}

	/**
	 * Renders the file picker input
	 *
	 * @return string
	 */
	protected function renderInput()
	{
		$class = (empty($this->buttonOptions['class']) ? 'btn btn-primary btn-file' : 'btn-file');
		Html::addCssClass($this->buttonOptions, $class);
		$label = ArrayHelper::remove($this->buttonOptions, 'label', Yii::t('fileinput', 'Browse') . '&hellip;');
		$icon = ArrayHelper::remove($this->buttonOptions, 'icon', 'folder-open');
		$label = ($label == false) ? '' : $label;
		$icon = ($icon == false) ? '' : '<i class="glyphicon glyphicon-' . $icon . '"></i> &nbsp;';
		if ($this->_disabled) {
			$this->buttonOptions['disabled'] = 'disabled';
		}
		$input = $this->getInput('fileInput');
		return Html::tag('div', $icon . $label . $input, $this->buttonOptions);
	}

	/**
	 * Renders the file(s) removal button
	 *
	 * @return string
	 */
	protected function renderRemove()
	{
		$class = (empty($this->removeOptions['class']) ? 'btn btn-default fileinput-remove fileinput-remove-button' : 'fileinput-remove fileinput-remove-button');
		Html::addCssClass($this->removeOptions, $class);
		$this->removeOptions['type'] = 'button';
		$label = ArrayHelper::remove($this->removeOptions, 'label', Yii::t('fileinput', 'Remove'));
		$icon = ArrayHelper::remove($this->removeOptions, 'icon', 'ban-circle');
		$label = ($label == false) ? '' : $label;
		$icon = ($icon == false) ? '' : '<i class="glyphicon glyphicon-' . $icon . '"></i> &nbsp;';
		return Html::button($icon . $label, $this->removeOptions);
	}

	/**
	 * Renders the file upload button
	 *
	 * @return string
	 */
	protected function renderUpload()
	{
		$class = (empty($this->uploadOptions['class']) ? 'btn btn-default fileinput-upload-button' : 'fileinput-upload-button');
		Html::addCssClass($this->uploadOptions, $class);
		$label = ArrayHelper::remove($this->uploadOptions, 'label', Yii::t('fileinput', 'Upload'));
		$icon = ArrayHelper::remove($this->uploadOptions, 'icon', 'upload');
		$label = ($label == false) ? '' : $label;
		$icon = ($icon == false) ? '' : '<i class="glyphicon glyphicon-' . $icon . '"></i> &nbsp;';
		if (isset($this->uploadRoute) && $this->uploadRoute != null) {
			return Html::a($icon . $label, $this->uploadRoute, $this->uploadOptions);
		} elseif ($this->uploadRoute === false) {
			return Html::button($icon . $label, $this->uploadOptions);
		} else {
			return Html::submitButton($icon . $label, $this->uploadOptions);
		}
	}

	/**
	 * Renders the file caption
	 *
	 * @return string
	 */
	protected function renderCaption()
	{
		Html::addCssClass($this->captionOptions, 'file-caption');
		if ($this->_disabled) {
			$this->captionOptions['disabled'] = 'disabled';
		}
		return Html::tag('div', '<span class="glyphicon glyphicon-file"></span> <span class="file-caption-name"></span>', $this->captionOptions);
	}

	/**
	 * Renders the preview container for the selected file(s)
	 *
	 * @return string
	 */
	protected function renderPreview()
	{
		Html::addCssClass($this->previewOptions, 'file-preview');
		$previewProgress = "<div class='file-preview-status text-center text-success'></div>\n";
		$previewContent = "<div class='close fileinput-remove text-right'>&times;</div>\n
            <div class='file-preview-thumbnails'></div>
            <div class='clearfix'></div>";
		$content = $previewProgress . "\n" . Html::tag('div', $previewContent, $this->previewOptions);
		return $this->validateIE('<style>.file-preview{display:none;}</style>') . $content;
	}

	/**
	 * Registers the needed assets
	 */
	public function registerAssets()
	{
		$view = $this->getView();
		FileInputAsset::register($view);
		/*
		  $view->registerJs('$(".wrap-indicator").popover({trigger: "hover"});');
		 */
		foreach ($this->pluginOptions as $key => $value) {
			if (substr($key, 0, 2) === "el" && !($value instanceof JsExpression)) {
				$this->pluginOptions[$key] = new JsExpression($value);
			}
		}
		$this->registerPlugin('fileinput', '$("#' . $this->containerOptions['id'] . '")');
	}

}