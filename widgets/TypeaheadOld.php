<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace kartik\widgets;

use Yii;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * Typeahead widget is a Yii2 wrapper for the Twitter Typeahead.js plugin. This
 * input widget is a jQuery based replacement for text inputs providing search
 * and typeahead functionality. It is inspired by twitter.com's autocomplete search
 * functionality and based on Twitter's typeahead.js which Twitter mentions as
 * a fast and fully-featured autocomplete library.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class TypeaheadOld extends InputWidget
{

    /**
     * @var array dataset an object that defines a set of data that hydrates suggestions.
     * It consists of the following special variable settings:
     * - local: array configuration for the [[local]] list of datums. You must set one of
     *   [[local]], [[prefetch]], or [[remote]].
     * - prefetch: array configuration for the [[prefetch]] options object.
     * - remote: array configuration for the [[remote]] options object.
     * - limit: integer the max number of suggestions from the dataset to display for
     *   a given query. Defaults to 5.
     * - valueKey: string the key used to access the value of the datum in the datum
     *   object. Defaults to 'value'.
     * - template: string the template used to render suggestions. Can be a string or a
     *   pre-compiled template (i.e. a `JsExpression` function that takes a datum as input
     *   and returns html as output). If not provided, defaults to `<p>{{value}}</p>`
     * - engine: string the template engine used to compile/render template if it is a string.
     *   Any engine can be used as long as it adheres to the expected API. Required if
     *   template is a string.
     * - header: string the header rendered before suggestions in the dropdown menu. Can
     *   be either a DOM element or HTML
     * - footer: string the footer rendered after suggestions in the dropdown menu. Can
     *   be either a DOM element or HTML
     */
    public $dataset = [];

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->dataset) || !is_array($this->dataset)) {
            throw new InvalidConfigException("You must define the 'dataset' property for Typeahead which must be an array.");
        }
        if (!is_array(current($this->dataset))) {
            throw new InvalidConfigException("The 'dataset' array must contain an array of datums. Invalid data found.");
        }
        $this->registerAssets();
        $this->renderInput();
    }

    /**
     * Renders the source Input for the Typeahead plugin.
     * Graceful fallback to a normal HTML  text input - in
     * case JQuery is not supported by the browser
     */
    protected function renderInput()
    {
        Html::addCssClass($this->options, 'typeahead');
        echo $this->getInput('textInput');
    }

    /**
     * Validates and sets plugin options
     */
    protected function setPluginOptions()
    {
        $i = 1;
        $data = [];
        foreach ($this->dataset as $d) {
            /* Generate name */
            if (empty($d['name'])) {
                $d['name'] = $this->options['id'] . '-ta-' . $i;
            }
            /* Parse engine */
            if (!empty($d['engine']) && !$d['engine'] instanceof JsExpression) {
                $d['engine'] = new JsExpression($d['engine']);
            }
            /* Add a spinning indicator for remote calls */
            if (!empty($d['remote'])) {
                $r = is_array($d['remote']) ? $d['remote'] : ['url' => $d['remote']];
                $hint = '$("#' . $this->options['id'] . '").parent().children(".tt-hint")';
                if (empty($r['beforeSend'])) {
                    $r['beforeSend'] = new JsExpression("function (xhr) { {$hint}.addClass('loading'); }");
                }
                if (empty($r['filter'])) {
                    $r['filter'] = new JsExpression("function (parsedResponse) { {$hint}.removeClass('loading'); return parsedResponse; }");
                }
                $d['remote'] = $r;
            }
            $data[] = $d;
            $i++;
        }
        $this->pluginOptions = array_replace($data, $this->pluginOptions);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        TypeaheadAsset::register($view);
        $this->setPluginOptions();
        $this->registerPlugin('typeahead');
    }
}
