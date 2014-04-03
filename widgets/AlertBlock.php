<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Alert block widget that groups multiple `\kartik\widget\Alert` or `kartik\widget\Growl` widgets inside a block.
 * You can choose to automatically read and display session flash messages (which is the default setting) or setup
 * your own block of custom alerts.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class AlertBlock extends \yii\bootstrap\Widget
{
	const TYPE_ALERT = 'alert';
	const TYPE_GROWL = 'growl';

	/**
	 * @var string the type of alert to use. Can be one of `TYPE_ALERT` or `TYPE_GROWL'.
	 * Defaults to `TYPE_ALERT`.
	 */
	public $type = self::TYPE_ALERT;

	/**
	 * @var integer|bool time in milliseconds after which each alert in the block fades out. If set to false, alerts will
	 * never fade out and will be displayed forever. This will be overridden by the `fade` setting within the `alertSettings`
	 * configuration. This property is only validated if `type` is `TYPE_ALERT`.
	 */
	public $fade = 600;

	/**
	 * @var integer time in milliseconds to delay the fade out of each alert, useful when multiple
	 * alerts are shown on the page.
	 */
	public $delay;

	/**
	 * @var bool whether to automatically use messages set via `Yii::$app->session->setFlash()`. Defaults to `true`.
	 * If set to `false`, you would need to pass the `body` setting within `alertSetting` array.
	 */
	public $useSessionFlash = true;

	/**
	 * @var array the alert types configuration for the alert messages. This array is setup as $alert => $settings, where:
	 * - $alert: string is the name of the session flash variable (e.g. error, success, info, warning)
	 * - $settings: array, the `\kartik\widgets\Alert` or `\kartik\widgets\Growl` widget settings
	 * @see \kartik\widgets\Alert
	 * @see \kartik\widgets\Growl
	 */
	public $alertSettings = [];

	/**
	 * @var array the options for rendering the close button tag. This will be overridden by the `closeButton` setting
	 * within the `alertSettings` configuration.
	 */
	public $closeButton = [];

	/**
	 * Initialize the alert block widget
	 */
	public function init()
	{
		parent::init();
		$this->initOptions();
		$this->registerAssets();
		echo Html::beginTag('div', $this->options) . "\n";
	}

	/**
	 * Runs the widget
	 */
	public function run() {
		parent::run();
		if ($this->useSessionFlash) {
			$this->renderFlashAlerts();
		}
		else {
			$this->renderAlerts();
		}
		echo "\n" . Html::endTag('div');
	}

	/**
	 * Initializes options and settings
	 */
	protected function initOptions() {
		if (empty($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		if (!isset($this->delay)) {
			$this->delay = ($this->type == self::TYPE_ALERT) ? 2000 : 1200;
		}
		if (empty($this->alertSettings) && $this->type == self::TYPE_GROWL) {
			$this->alertSettings = [
				'error' => ['type' => Growl::TYPE_DANGER],
				'success' => ['type' => Growl::TYPE_SUCCESS],
				'info' => ['type' => Growl::TYPE_INFO],
				'warning' => ['type' => Growl::TYPE_WARNING],
				'growl' => ['type' => Growl::TYPE_GROWL]
			];
		}
		elseif (empty($this->alertSettings)) {
			$this->alertSettings = [
				'error' => ['type' => Alert::TYPE_DANGER],
				'success' => ['type' => Alert::TYPE_SUCCESS],
				'info' => ['type' => Alert::TYPE_INFO],
				'warning' => ['type' => Alert::TYPE_WARNING],
				'primary' => ['type' => Alert::TYPE_PRIMARY],
				'default' => ['type' => Alert::TYPE_DEFAULT]
			];
		}
	}

	/**
	 * Renders alerts from session flash
	 */
	public function renderFlashAlerts() {
		$type = ($this->type == self::TYPE_GROWL) ? self::TYPE_GROWL : self::TYPE_ALERT;
		$session = Yii::$app->getSession();
		$flashes = $session->getAllFlashes();
		$delay = $this->delay;
		foreach ($flashes as $alert => $message) {
			if (!empty($this->alertSettings[$alert])) {
				$settings = $this->alertSettings[$alert];
				$settings['body'] = $message;
				if (empty($settings['closeButton'])) {
					$settings['closeButton'] = $this->closeButton;
				}
				if ($type == self::TYPE_ALERT && empty($settings['fade'])) {
					$settings['fade'] = $this->fade;
				}
				if ($type == self::TYPE_GROWL) {
					$settings['delay'] = $delay;
					$delay += $this->delay;
				}
				echo ($type == self::TYPE_GROWL) ? Growl::widget($settings) : Alert::widget($settings);
				$session->removeFlash($alert);
			}
		}
	}

	/**
	 * Renders manually set alerts
	 */
	public function renderAlerts() {
		$type = ($this->type == self::TYPE_GROWL) ? self::TYPE_GROWL : self::TYPE_ALERT;
		foreach ($this->alertSettings as $alert => $settings) {
			if (!empty($settings['body'])) {
				echo ($type == self::TYPE_GROWL) ? Growl::widget($settings) : Alert::widget($settings);
			}
		}
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

	/**
	 * Register client assets
	 */
	protected function registerAssets() {
		$view = $this->getView();
		if ($this->fade > 0 && $this->type == self::TYPE_ALERT) {
			$js = '$("#' . $this->options['id'] . ' .kv-alert").each(function(index) {
				$(this).delay(' . $this->delay . ' * (index + 0.7)).fadeTo(' . $this->fade . ', 0.00, function() {
					$(this).slideUp("slow", function() {
						$(this).remove();
					});
				});
			});';
			$view->registerJs($js);
		}
	}
}
