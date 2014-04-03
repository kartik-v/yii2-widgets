<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Widget that wraps the Bootstrap Growl plugin by remabledesigns.
 * @http://bootstrap-growl.remabledesigns.com/
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Growl extends \yii\bootstrap\Widget
{
	const TYPE_INFO = 'info';
	const TYPE_DANGER = 'danger';
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_GROWL = 'growl';

	/**
	 * @var string the type of the alert to be displayed. One of the `TYPE_` constants.
	 * Defaults to `TYPE_INFO`
	 */
	public $type = self::TYPE_INFO;

	/**
	 * @var string the title for the alert
	 */
	public $title = '';

	/**
	 * @var string the class name for the icon
	 */
	public $icon = '';

	/**
	 * @var string the alert message body
	 */
	public $body = '';

	/**
	 * @var bool show title separator. Only applicable if `title` is set.
	 */
	public $showSeparator = false;

	/**
	 * @var integer the delay in microseconds after which the alert will be displayed.
	 * Will be useful when multiple alerts are to be shown.
	 */
	public $delay;

	/**
	 * @var array the options for rendering the close button tag. This will be overridden by the `closeButton` setting
	 * within the `alertSettings` configuration.
	 */
	public $closeButton = [];

	/**
	 * @var array the growl configuration options
	 * @see http://bootstrap-growl.remabledesigns.com/
	 */
	public $config = [];

	private $_settings;

	/**
	 * Initializes the widget
	 */
	public function init()
	{
		parent::init();
		$this->initOptions();
	}

	/**
	 * Initializes the widget options.
	 * This method sets the default values for various options.
	 */
	protected function initOptions()
	{
		if (empty($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		$this->_settings = [
			'message' => $this->body,
			'icon' => $this->icon,
			'title' => $this->title,
		];
		$this->config['type'] = $this->type;
		Html::addCssClass($this->options, 'col-xs-10 col-sm-10 col-md-3 alert kv-growl-animated');
		$this->config['template']['container'] = Html::beginTag('div', $this->options);
		if ($this->closeButton === null ) {
			$this->config['template']['dismiss'] = '';
		}
		elseif (!empty($this->closeButton)) {
			$this->config['template']['dismiss'] = $this->renderCloseButton();
		}
		if (!empty($this->showSeparator)) {
			$this->config['template']['title_divider'] = '<hr class="kv-alert-separator">';
		}
		$this->registerAssets();
	}

	/**
	 * Register client assets
	 */
	protected function registerAssets()
	{
		$view = $this->getView();
		GrowlAsset::register($view);
		$js = '$.growl(' . Json::encode($this->_settings) . ', ' . Json::encode($this->config) . ');';
		if (!empty($this->delay) && $this->delay > 0) {
			$js = 'setTimeout(function () {' . $js . '}, ' . $this->delay . ');';
		}
		$view->registerJs($js);
	}

	/**
	 * Renders the close button.
	 * @return string the rendering result
	 */
	protected function renderCloseButton()
	{
		if ($this->closeButton !== null) {
			$tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
			$label = ArrayHelper::remove($this->closeButton, 'label', '&times;');
			if ($tag === 'button' && !isset($this->closeButton['type'])) {
				$this->closeButton['type'] = 'button';
			}

			return Html::tag($tag, $label, $this->closeButton);
		} else {
			return null;
		}
	}

}
