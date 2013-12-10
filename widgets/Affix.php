<?php
namespace kartik\widgets;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * A scrollspy and affixed enhanced navigation to highlight sections and secondary
 * sections in each page
 *
 * For example:
 *
 * ```php
 * echo Affix::widget([
 *     'items' => [
 *         [
 *             'url' => '#section-1',
 *             'label' => 'Section 1',
 *             'icon' => 'asterisk'
 *         ],
 *         [
 *             'url' => '#section-2',
 *             'label' => 'Section 2',
 *             'icon' => 'asterisk'
 *             'items' => [
 *                  ['url' => '#section-2-1', 'label' => 'Section 2.1'],
 *                  ['url' => '#section-2-2', 'label' => 'Section 2.2'],
 *             ],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Affix extends \yii\widgets\Menu
{
	/**
	 * @var string, the type of content to display. By default displays the navigation menu
	 * If set to 'body' it will display the body.
	 */
	public $type = 'menu';
	
	/**
	 * @var array list of affic menu items. Each menu item should be an array of the following structure:
	 *
	 * - label: string, mandatory, specifies the menu item label. When [[encodeLabels]] is true, the label 
	 *   will be HTML-encoded.
	 * - icon: string, optional, specifies the glyphicon name to be placed before label.
	 * - header: string, optional, the header for the body content to be rendered in the main page
	 *   using Affix::body. If not set, this will be defaulted to the label.
	 * - subheader: string, optional, the subheader that will be printed within the header.
	 * - content: string, the body content to be rendered in the main page using renderBody. 
	 * - url: string, mandatory, specifies the URL of the menu item. This will be a bookmark on the same page.
	 *   For example "#section-1" or "#section-1-1".
	 * - items: array, optional, specifies the sub-menu items. Its format is the same as the parent items.
	 * - options: array, optional, the HTML attributes for the menu container tag.
	 */	
	public $items;

	/* @var array options for the affix main container */
	public $container;
	
	/* @var string the body main section template */
	public $secTemplate = <<<EOT
	<div class="kv-section">
		<div class="page-header">
			<h1 id="{id}">{header}</h1>
		</div>
		{content}{subSection}
	</div>
EOT;

	/* @var string the body sub section template */
	public $subTemplate = <<<EOT
		<div class="kv-sub-section">
			<h3 id="{id}">{header}</h3>
			{content}
		</div>
EOT;
	
	public function init() {
		parent::init();
		AffixAsset::register($this->getView());
		$this->activateParents = true;
		$this->submenuTemplate = "\n<ul class='nav'>\n{items}\n</ul>\n";
		$this->linkTemplate = '<a href="{url}">{icon}{label}</a>';
		$this->labelTemplate = '{icon}{label}';
		Html::addCssClass($this->options, 'nav kv-nav');
		Html::addCssClass($this->container, 'kv-sidebar hidden-print-affix');
	}
	
	public function run()
	{
		if ($this->type == 'body') {
			echo $this->renderBody($this->items);
		}
		else {
			if ($this->route === null && Yii::$app->controller !== null) {
				$this->route = Yii::$app->controller->getRoute();
			}
			if ($this->params === null) {
				$this->params = $_GET;
			}
			$items = $this->normalizeItems($this->items, $hasActiveChild);
			$options = $this->options;
			$tag = ArrayHelper::remove($options, 'tag', 'ul');
			$menu = Html::tag($tag, $this->renderItems($items), $options);
			echo Html::tag('div', $menu, $this->container);
		}
	}
	
	/**
	 * Generates the affix body content
	 * @param array $items the items to be rendered as body content
	 * @return string the rendering result
	 */
	protected function renderBody($items) {
		$body = '';
		foreach ($items as $item) {
			$body .= $this->renderSection($item) . "\n";
		}
		echo $body;
	}
	
	/**
	 * Renders each body main section.
	 * @param array $item the section item to be rendered. Please refer to [[items]] 
	 * to see what data might be in the item.
	 * @return string the rendering result
	 * @throws InvalidConfigException
	 */
	protected function renderSection($item)
	{
		$this->validateItems($item);
		$id = str_replace('#', '', $item['url']);
		$header = ArrayHelper::getValue($item, 'header', $item['label']);
		if (isset($item['subheader'])) {
			$header .= ' <small>' . $item['subheader'] . '</small>';
		}
		$content = ArrayHelper::getValue($item, 'content', '');
		$subSection = '';
		if (isset($item['items'])) {
			foreach ($item['items'] as $subItem) {
				$subSection .= "\n" . $this->renderSubSection($subItem);
			}
		}
		return 	strtr($this->secTemplate, [
			'{id}' => $id,
			'{header}' => $header,
			'{content}' => $content,
			'{subSection}' => $subSection
		]);	
	}

	/**
	 * Renders each body sub section.
	 * @param array $item the sub-section item to be rendered. Please refer to [[items]] 
	 * to see what data might be in the item.
	 * @return string the rendering result
	 * @throws InvalidConfigException
	 */	
	protected function renderSubSection($item)
	{
		$this->validateItems($item);
		$id = str_replace('#', '', $item['url']);
		$header = ArrayHelper::getValue($item, 'header', $item['label']);
		if (isset($item['subheader'])) {
			$header .= ' <small>' . $item['subheader'] . '</small>';
		}		
		$content = ArrayHelper::getValue($item, 'content', '');
		return 	strtr($this->subTemplate, [
			'{id}' => $id,
			'{header}' => $header,
			'{content}' => $content,
		]);
	}
		
	/**
	 * Renders the content of a affix menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
	 * @return string the rendering result
	 * @throws InvalidConfigException
	 */
	protected function renderItem($item)
	{
		$this->validateItems($item);
		$template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
		$icon = empty($item['icon']) ? '' : '<i class="glyphicon glyphicon-' . $item['icon'] . '"></i> ';
		return strtr($template, [
			'{url}' => $item['url'],
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
		if (!isset($item['url']) || substr($item['url'], 0, 1) != '#') {
			throw new InvalidConfigException("The 'url' option is required and must point to a bookmarked content on the same page.");
		}	
	}
}
