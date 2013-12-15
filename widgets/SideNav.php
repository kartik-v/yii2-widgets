<?php
namespace kartik\widgets;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * A custom extended side navigation menu extending Yii Menu 
 *
 * For example:
 *
 * ```php
 * echo SideNav::widget([
 *     'items' => [
 *         [
 *             'url' => ['/site/index'],
 *             'label' => 'Home',
 *             'icon' => 'home'
 *         ],
 *         [
 *             'url' => ['/site/about'],
 *             'label' => 'About',
 *             'icon' => 'info-sign'
 *             'items' => [
 *                  ['url' => '#', 'label' => 'Item 1'],
 *                  ['url' => '#', 'label' => 'Item 2'],
 *             ],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class SideNav extends \yii\widgets\Menu
{
	/* Panel contextual states */
	const TYPE_DEFAULT = 'default';
	const TYPE_PRIMARY = 'primary';
	const TYPE_INFO = 'info';
	const TYPE_SUCCESS = 'success';
	const TYPE_DANGER = 'danger';
	const TYPE_WARNING = 'warning';
	
	/**
	 * @var string the menu container style. This is one of the bootstrap panel 
	 * contextual state classes. Defaults to `default`.
	 * @see http://getbootstrap.com/components/#panels
	 */ 
	public $type = self::TYPE_DEFAULT;
	
	/**
	 * @var array string/boolean the sidenav heading. This is not HTML encoded
	 * When set to false or null, no heading container will be displayed.
	 */
	public $heading = false;

	/* @var array options for the sidenav heading */
	public $headingOptions = [];

	/* @var array options for the sidenav container */
	public $containerOptions = [];
	
	/* @var string indicator for a menu sub-item */
	public $indItem = '&raquo; ';

	/* @var string indicator for a opened sub-menu */
	public $indMenuOpen = '<i class="indicator glyphicon glyphicon-chevron-down"></i>';

	/* @var string indicator for a closed sub-menu */
	public $indMenuClose = '<i class="indicator glyphicon glyphicon-chevron-right"></i>';

	/**
	 * @var array list of sidenav menu items. Each menu item should be an array of the following structure:
	 *
	 * - label: string, optional, specifies the menu item label. When [[encodeLabels]] is true, the label
	 *   will be HTML-encoded. If the label is not specified, an empty string will be used.
	 * - icon: string, optional, specifies the glyphicon name to be placed before label.
	 * - url: string or array, optional, specifies the URL of the menu item. It will be processed by [[Html::url]].
	 *   When this is set, the actual menu item content will be generated using [[linkTemplate]];
	 *   otherwise, [[labelTemplate]] will be used.
	 * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
	 * - items: array, optional, specifies the sub-menu items. Its format is the same as the parent items.
	 * - active: boolean, optional, whether this menu item is in active state (currently selected).
	 *   If a menu item is active, its CSS class will be appended with [[activeCssClass]].
	 *   If this option is not set, the menu item will be set active automatically when the current request
	 *   is triggered by [[url]]. For more details, please refer to [[isItemActive()]].
	 * - template: string, optional, the template used to render the content of this menu item.
	 *   The token `{url}` will be replaced by the URL associated with this menu item,
	 *   and the token `{label}` will be replaced by the label of the menu item.
	 *   If this option is not set, [[linkTemplate]] or [[labelTemplate]] will be used instead.
	 * - options: array, optional, the HTML attributes for the menu item tag.
	 *
	 */	
	public $items;

	/**
	 * Allowed panel stypes
	 */
	private static $_validTypes = [
		self::TYPE_DEFAULT,
		self::TYPE_PRIMARY,
		self::TYPE_INFO,
		self::TYPE_SUCCESS,
		self::TYPE_DANGER,
		self::TYPE_WARNING,
	];
		
	public function init() {
		parent::init();
		SideNavAsset::register($this->getView());
		$this->activateParents = true;
		$this->submenuTemplate = "\n<ul class='nav nav-pills nav-stacked'>\n{items}\n</ul>\n";
		$this->linkTemplate = '<a href="{url}">{icon}{label}</a>';
		$this->labelTemplate = '{icon}{label}';
		$this->markTopItems();
		Html::addCssClass($this->options, 'nav nav-pills nav-stacked kv-sidenav');
	}
	
	/**
	 * Renders the side navigation menu.
	 * with the heading and panel containers
	 */
	public function run()
	{
		$heading = '';
		if (isset($this->heading) && $this->heading != '') {
			Html::addCssClass($this->headingOptions, 'panel-heading');
			$heading = Html::tag('div', '<h3 class="panel-title">' . $this->heading . '</h3>', $this->headingOptions);
		}
		$body = Html::tag('div', $this->renderMenu(), ['class'=>'table']);
		$type = in_array($this->type, self::$_validTypes) ? $this->type : self::TYPE_DEFAULT;		
		Html::addCssClass($this->containerOptions, "panel panel-{$type}");
		echo Html::tag('div', $heading . $body, $this->containerOptions);
	}

	/**
	 * Renders the main menu 
	 */
	protected function renderMenu() {
		if ($this->route === null && Yii::$app->controller !== null) {
			$this->route = Yii::$app->controller->getRoute();
		}
		if ($this->params === null) {
			$this->params = $_GET;
		}
		$items = $this->normalizeItems($this->items, $hasActiveChild);
		$options = $this->options;
		$tag = ArrayHelper::remove($options, 'tag', 'ul');
		
		return Html::tag($tag, $this->renderItems($items), $options);	
	}
	
	/**
	 * Marks each topmost level item which is not a submenu
	 */	
	protected function markTopItems() {
		$items = [];
		foreach ($this->items as $item) {
			if (empty($item['items'])) {
				$item['top'] = true;
			}
			$items[] = $item;
		}
		$this->items = $items;
	}
	
	/**
	 * Renders the content of a side navigation menu item.
	 * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
	 * @return string the rendering result
	 * @throws InvalidConfigException
	 */
	protected function renderItem($item)
	{
		$this->validateItems($item);
		$url = Html::url(ArrayHelper::getValue($item, 'url', '#'));
		$template = $this->linkTemplate;
		if (empty($item['top'])) {
			if (empty($item['items'])) {
				$template = str_replace('{icon}', $this->indItem . '{icon}', $template);
			}
			else {
				$template = '<a href="{url}" class="kv-toggle">{icon}{label}</a>';
				$openOptions = ($item['active']) ? ['class'=>'opened'] : ['class'=>'opened', 'style' => 'display:none'] ;
				$closeOptions = ($item['active']) ? ['class'=>'closed', 'style' => 'display:none'] : ['class'=>'closed'];
				$indicator = Html::tag('span', $this->indMenuOpen, $openOptions) . Html::tag('span', $this->indMenuClose, $closeOptions);
				$template = str_replace('{icon}', $indicator . '{icon}', $template);
			}
		}
		$icon = empty($item['icon']) ? '' : '<i class="glyphicon glyphicon-' . $item['icon'] . '"></i> &nbsp;';
		unset($item['icon'], $item['top']);
		return strtr($template, [
			'{url}' => $url,
			'{label}' => $item['label'],
			'{icon}' => $icon
		]);
	}
	
	/**
	 * Validates each item for a valid label and url.
	 * @throws InvalidConfigException
	 */
	protected function validateItems($item) {
		if (!isset($item['label'])) {
			throw new InvalidConfigException("The 'label' option is required.");
		}
	}
}
