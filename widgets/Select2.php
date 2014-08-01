<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Select2 widget is a Yii2 wrapper for the Select2 jQuery plugin. This
 * input widget is a jQuery based replacement for select boxes. It supports
 * searching, remote data sets, and infinite scrolling of results. The widget
 * is specially styled for Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://ivaynberg.github.com/select2/
 */
class Select2 extends InputWidget
{

    const LARGE = 'lg';
    const MEDIUM = 'md';
    const SMALL = 'sm';

    /**
     * @var string the locale ID (e.g. 'fr', 'de') for the language to be used by the Select2 Widget.
     * If this property not set, then the current application language will be used.
     */
    public $language;

    /**
     * @var array addon to prepend or append to the Select2 widget
     * - prepend: array the prepend addon configuration
     *     - content: string the prepend addon content
     *     - asButton: boolean whether the addon is a button or button group. Defaults to false.
     * - append: array the append addon configuration
     *     - content: string the append addon content
     *     - asButton: boolean whether the addon is a button or button group. Defaults to false.
     * - groupOptions: array HTML options for the input group
     * - contentBefore: string content placed before addon
     * - contentAfter: string content placed after addon
     */
    public $addon = [];

    /**
     * @var string Size of the Select2 input, must be one of the
     * [[LARGE]], [[MEDIUM]] or [[SMALL]]. Defaults to [[MEDIUM]]
     */
    public $size = self::MEDIUM;

    /**
     * @var array $data the option data items. The array keys are option values, and the array values
     * are the corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * [[\yii\helpers\ArrayHelper::map()]].
     */
    public $data;

    /**
     * @var array the HTML attributes for the input tag. The following options are important:
     * - multiple: boolean whether multiple or single item should be selected. Defaults to false.
     * - placeholder: string placeholder for the select item.
     */
    public $options = [];

    /**
     * @var boolean indicator for displaying text inputs
     * instead of select fields
     */
    private $_hidden = false;

    /**
     *
     * @var string the option to bind select2 to existing HTML element. No new input will be rendered.
     */
    public $selector = null;

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        if($this->selector){
            // we do not want forcing to enter useless data
            $this->name = substr($this->selector, 1);
            parent::init();
            $this->registerAssets();
            return;
        }
        
        parent::init();
        $this->_hidden = !empty($this->pluginOptions['data']) ||
            !empty($this->pluginOptions['query']) ||
            !empty($this->pluginOptions['ajax']) ||
            isset($this->pluginOptions['tags']);
        if (!isset($this->data) && !$this->_hidden) {
            throw new InvalidConfigException("No 'data' source found for Select2. Either the 'data' property must be set OR one of 'data', 'query', 'ajax', or 'tags' must be set within 'pluginOptions'.");
        }
        if (!empty($this->options['placeholder']) && !$this->_hidden &&
            (empty($this->options['multiple']) || $this->options['multiple'] == false)
        ) {
            $this->data = ["" => ""] + $this->data;
        }
        if (!isset($this->options['style'])) {
            $this->options['style'] = 'width: 100%';
        }

        $this->registerAssets();
        $this->renderInput();
    }

    /**
     * Embeds the input group addon
     */
    protected function embedAddon($input)
    {
        if (!empty($this->addon)) {
            $addon = $this->addon;
            $prepend = ArrayHelper::getValue($addon, 'prepend', '');
            $append = ArrayHelper::getValue($addon, 'append', '');
            $group = ArrayHelper::getValue($addon, 'groupOptions', []);
            $size = isset($this->size) ? ' input-group-' . $this->size : '';
            if ($this->pluginLoading) {
                Html::addCssClass($group, 'kv-hide group-' . $this->options['id']);
            }
            if (is_array($prepend)) {
                $content = ArrayHelper::getValue($prepend, 'content', '');
                if (isset($prepend['asButton']) && $prepend['asButton'] == true) {
                    $prepend = Html::tag('div', $content, ['class' => 'input-group-btn']);
                } else {
                    $prepend = Html::tag('span', $content, ['class' => 'input-group-addon']);
                }
                Html::addCssClass($group, 'input-group' . $size . ' select2-bootstrap-prepend');
            }
            if (is_array($append)) {
                $content = ArrayHelper::getValue($append, 'content', '');
                if (isset($append['asButton']) && $append['asButton'] == true) {
                    $append = Html::tag('div', $content, ['class' => 'input-group-btn']);
                } else {
                    $append = Html::tag('span', $content, ['class' => 'input-group-addon']);
                }
                Html::addCssClass($group, 'input-group' . $size . ' select2-bootstrap-append');
            }
            $addonText = $prepend . $input . $append;
            $contentBefore = ArrayHelper::getValue($addon, 'contentBefore', '');
            $contentAfter = ArrayHelper::getValue($addon, 'contentAfter', '');
            return Html::tag('div', $contentBefore . $addonText . $contentAfter, $group);
        }
        return $input;
    }

    /**
     * Renders the source Input for the Select2 plugin.
     * Graceful fallback to a normal HTML select dropdown
     * or text input - in case JQuery is not supported by
     * the browser
     */
    protected function renderInput()
    {
        $class = $this->pluginLoading ? 'kv-hide ' : '';
        if (empty($this->addon) && isset($this->size)) {
            $class .= 'input-' . $this->size;
        }
        if ($this->pluginLoading) {
            $this->_loadIndicator = '<div class="kv-plugin-loading loading-' . $this->options['id'] . '">&nbsp;</div>';
        }
        Html::addCssClass($this->options, $class);
        if ($this->_hidden) {
            $input = $this->getInput('textInput');
        } else {
            $input = $this->getInput('dropDownList', true);
        }
        echo $this->_loadIndicator . $this->embedAddon($input);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        if (!empty($this->language) && substr($this->language, 0, 2) != 'en') {
            Select2Asset::register($view)->js[] = 'select2_locale_' . $this->language . '.js';
        } else {
            Select2Asset::register($view);
        }
        $this->pluginOptions['width'] = 'resolve';
        if ($this->pluginLoading) {
            $id = $this->options['id'];
            $loading = "\$('.kv-plugin-loading.loading-{$id}')";
            $groupCss = "group-{$id}";
            $group = "\$('.kv-hide.{$groupCss}')";
            $el = $this->selector ? "\$('{$this->selector}')" : "\$('#{$id}')";
            $callback = <<< JS
function(){
    var \$container = {$el}.select2('container');
    {$el}.removeClass('kv-hide');
    \$container.removeClass('kv-hide');
    {$loading}.remove();
    if (Object.keys({$group}).length > 0) {
        {$group}.removeClass('kv-hide').removeClass('{$groupCss}');
    }
}
JS;
            $this->registerPlugin('select2', $el, $callback);
        } else {
            $this->registerPlugin('select2');
        }
    }
}
