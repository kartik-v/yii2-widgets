<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 3.1.0
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
    const TYPE_CUSTOM = 'alert-custom';

    /**
     * @var string the type of the alert to be displayed. One of the `TYPE_` constants.
     * Defaults to `TYPE_INFO`
     */
    public $type = self::TYPE_INFO;

    /**
     * @var string the icon type. Can be either 'class' or 'image'. Defaults to 'class'.
     */
    public $iconType = 'class';

    /**
     * @var string the class name for the icon to be displayed. If set to empty or null, will not be
     * displayed.
     */
    public $icon = '';

    /**
     * @var array the HTML attributes for the icon.
     */
    public $iconOptions = [];

    /**
     * @var string the title for the alert. If set to empty or null, will not be
     * displayed.
     */
    public $title = '';

    /**
     * @var array the HTML attributes for the title. The following options are additionally recognized:
     * - tag: the tag to display the title. Defaults to 'span'.
     */
    public $titleOptions = ['class' => 'kv-alert-title'];

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
     * Runs the widget
     */
    public function run()
    {
        echo $this->getTitle();
        parent::run();
    }

    /**
     * Gets the title section
     *
     * @return string
     */
    protected function getTitle()
    {
        $icon = '';
        $title = '';
        $separator = '';
        if (!empty($this->icon) && $this->iconType == 'image') {
            $icon = Html::img($this->icon, $this->iconOptions);
        } elseif (!empty($this->icon)) {
            $this->iconOptions['class'] = $this->icon . ' ' . (empty($this->iconOptions['class']) ? 'kv-alert-title' : $this->iconOptions['class']);
            $icon = Html::tag('span', '', $this->iconOptions) . ' ';
        }
        if (!empty($this->title)) {
            $tag = ArrayHelper::remove($this->titleOptions, 'tag', 'span');
            $title = Html::tag($tag, $this->title, $this->titleOptions);
            if ($this->showSeparator) {
                $separator = '<hr class="kv-alert-separator">' . "\n";
            }
        }
        return $icon . $title . $separator;
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

        if ($this->delay > 0) {
            $js = 'jQuery("#' . $this->options['id'] . '").fadeTo(' . $this->delay . ', 0.00, function() {
				$(this).slideUp("slow", function() {
					$(this).remove();
				});
			});';
            $view->registerJs($js);
        }
    }
}
