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
 * Extends the \yii\bootstrap\Alert widget with additional styling and auto fade out options.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Alert extends \yii\bootstrap\Alert
{
	const TYPE_INFO = 'alert-info';
	const TYPE_DANGER = 'alert-danger';
	const TYPE_SUCCESS = 'alert-success';
	const TYPE_WARNING = 'alert-warning';
	const TYPE_PRIMARY = 'bg-primary';
	const TYPE_DEFAULT = 'well';

	/**
	 * @var string the type of the alert to be displayed. One of the `TYPE_` constants.
	 * Defaults to `TYPE_INFO`
	 */
	public $type = self::TYPE_INFO;

	/**
	 * @var string whether to display a title for the alert. This will help display a title with a message separator
	 * and an optional bootstrap icon. If this is null or not set, it will not be displayed.
	 */
	public $title;

	/**
	 * @var array the HTML attributes for the title. The following options are additionally recognized:
	 * - tag: the tag to display the title. Defaults to 'div'.
	 * - icon: the bootstrap icon name suffix.
	 */
	public $titleOptions = [];

	/**
	 * @var integer|bool time in milliseconds after which alert fades out. If set to `0` or `false`, alerts will
	 * never fade out and will be displayed forever. Defaults to `false`.
	 */
	public $fade = false;

	/**
	 * Runs the widget
	 */
	public function run()
	{
		if (!empty($this->title)) {
			$tag = ArrayHelper::remove($this->titleOptions, 'tag', 'div');
			$icon = ArrayHelper::remove($this->titleOptions, 'icon', '');
			Html::addCssClass($this->titleOptions, 'kv-alert-title');
			if ($icon != '') {
				$icon = '<span class="glyphicon glyphicon-' . $icon . '"></span> ';
			}
			echo Html::tag($tag, $icon . $this->title, $this->titleOptions) . "\n<hr class='kv-alert-separator'>\n";
		}
		parent::run();
	}

	/**
	 * Initializes the widget options.
	 * This method sets the default values for various options.
	 */
	protected function initOptions()
	{
		parent::initOptions();
		if (empty($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		$this->registerAssets();
		Html::addCssClass($this->options, 'kv-alert ' . $this->type);
	}

	/**
	 * Register client assets
	 */
	protected function registerAssets()
	{
		$view = $this->getView();
		AlertAsset::register($view);

		if ($this->fade > 0) {
			$js = '$("#' . $this->options['id'] . '").fadeTo(' . $this->fade . ', 0.00, function() {
				$(this).slideUp("slow", function() {
					$(this).remove();
				});
			});';
			$view->registerJs($js);
		}
	}
}
