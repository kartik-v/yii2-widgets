<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * A widget that wraps the spin.js - an animated CSS3 loading spinner
 * with VML fallback for IE.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Spinner extends \yii\base\Widget
{

	const TINY = 'tiny';
	const SMALL = 'small';
	const MEDIUM = 'medium';
	const LARGE = 'large';

	/**
	 * @var string the spinner preset to apply.
	 * - if this is set to one of 'tiny', 'small', or 'large', it will override any
	 *   other settings in `pluginOptions`
	 * - if this is set to a string other than the defined presets
	 *     - if `pluginOptions` is also set, then it will create a preset with this name
	 *       for the client session and apply the settings
	 *     - if `pluginOptions` is not set, an InvalidConfigException will be raised
	 * - if this is set to `false`, the spinner will be stopped and removed.
	 * - if this is not set or is null, the settings in pluginOptions will be used.
	 */
	public $preset;

	/**
	 * @var string the color (hex/name) to apply to the spinner. If not specified
	 * it will inherit the spinner container color
	 */
	public $color;

	/**
	 * @var boolean is the spinner hidden by default. Defaults to `false`.
	 */
	public $hidden = false;

	/**
	 * @var string alignment of the spinner with respect to the parent, defaults
	 * to center. If set to `left` or `right`, this will wrap it in a container
	 * with the respective floats. By default, the spinner will be aligned 'center'
	 * and `top` of the parent element.
	 */
	public $align = 'center';

	/**
	 * @var string caption embedded inside the spinner. This is not HTML encoded.
	 * If you set it to a null string, this will not be displayed.
	 */
	public $caption = '';

	/**
	 * @var array HTML options for the caption container. The following additional
	 * attributes can be set:
	 * - `tag`: string the `tag` for rendering the container. Defaults to `span`,
	 */
	public $captionOptions = [];

	/**
	 * @var options the HTML attributes for the spinner container. The following
	 * additional attributes can be set:
	 * - `tag`: string the `tag` for rendering the container. Defaults to `div`,
	 */
	public $options = [];

	/**
	 * @var array the widths for each preset.
	 */
	private $_presets = [
		self::TINY,
		self::SMALL,
		self::MEDIUM,
		self::LARGE,
	];

	/**
	 * @var boolean is the preset valid
	 */
	private $_validPreset = false;

	/**
	 * @var array widget plugin options
	 */
	public $pluginOptions = [];

	public function init()
	{
		parent::init();
		$this->_validPreset = (!empty($this->preset) && in_array($this->preset, $this->_presets));
		Html::addCssClass($this->options, 'kv-spin kv-spin-' . $this->align);
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		$tag = ArrayHelper::remove($this->options, 'tag', 'div');
		$spinner = Html::tag($tag, '&nbsp;', $this->options);
		$tag = ArrayHelper::remove($this->captionOptions, 'tag', ($this->align == 'left' || $this->align == 'right') ? 'span' : 'div');
		Html::addCssClass($this->captionOptions, (($this->_validPreset) ? "kv-spin-{$this->preset}-{$this->align}" : ''));
		$caption = (trim($this->caption) == '') ? '' : Html::tag($tag, $this->caption, $this->captionOptions);
		echo '<div class="kv-spin-' . $this->align . '">' . $spinner . "\n" . $caption . '</div>';
		$this->registerAssets();
	}

	/**
	 * Registers the needed assets
	 */
	public function registerAssets()
	{
		$view = $this->getView();
		SpinnerAsset::register($view);
		$id = '$("#' . $this->options['id'] . '")';

		if ($this->_validPreset) {
			$js = (isset($this->color)) ? "{$id}.spin('{$this->preset}', '{$this->color}');" : "{$id}.spin('{$this->preset}');";
		} elseif ($this->preset === false) {
			$js = "{$id}.spin(false);";
		} else {
			$options = Json::encode($this->pluginOptions);
			$js = $id . '.spin(' . $options . ');';
			if (!empty($this->preset) && is_string($this->preset)) {
				$js = "$.fn.spin.presets.{$this->preset} = {$options};\n{$id}.spin('{$this->preset}');";
			}
		}
		$view->registerJs($js);
	}

}