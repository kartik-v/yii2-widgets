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
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\View;
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
class TypeaheadNew extends InputWidget
{

    /**
     * @var array dataset an object that defines a set of data that hydrates suggestions.
     * - name: string the name of the dataset. This will be appended to tt-dataset- to form 
     *   the class name of the containing DOM element. Defaults to a random number.
     * - displayKey: string The key used to access a suggestion object's string representation. If
     *   a suggestion is selected, its string representation is what the typeahead's value 
     *   is set to. Defaults to value.
     * - templates: array A hash of templates to be used when rendering the dataset. Note a precompiled 
     *   template is a function that takes a JavaScript object as its first argument and returns 
     *   a HTML string.
     *   - empty: string/template object. Rendered when 0 suggestions are available for the given query. 
     *     Can be either a HTML string or a precompiled template.
     *   - header: string the header rendered at the top of the dataset. Can be either a HTML string or 
     *     a precompiled template.
     *   - footer: string the footer rendered at the bottom of the dataset. Can be either a HTML string or 
     *     a precompiled template.
     *   - suggestion: string used to render a single suggestion. If set, this has to be a precompiled template. 
     *     The associated suggestion object will serve as the context. Defaults to the value of displayKey wrapped 
     *     in a p tag i.e. `<p>{{value}}</p>`.
     * - source: Bloodhound suggestion engine source
     *   - datumTokenizer: A JS function with the signature (datum) that transforms a datum 
     *     into an array of string tokens.
     *   - queryTokenizer: A JS function with the signature (query) that transforms a query 
     *     into an array of string tokens.
     *   - local: array configuration for the [[local]] list of datums. You must set one of
     *     [[local]], [[prefetch]], or [[remote]].	 
     *   - prefetch: array configuration for the [[prefetch]] options object.
     *   - remote: array configuration for the [[remote]] options object.
     *   - limit: integer the max number of suggestions from the dataset to display for 
     *     a given query. Defaults to 5.
     *   - dupDetector:  If set, this is expected to be a JS function with the signature 
     *     (datum1, datum2) that returns true if the datums are duplicates or false otherwise. 
     *     If not set, duplicate detection will not be performed.
     *   - valueKey: string the key used to access the value of the datum in the datum 
     *     object. Defaults to 'value'.
     *   - template: string the template used to render suggestions. Can be a string or a 
     *     pre-compiled template (i.e. a `JsExpression` function that takes a datum as input
     *     and returns html as output). If not provided, defaults to `<p>{{value}}</p>`
     *   - engine: string the template engine used to compile/render template if it is a string. 
     *     Any engine can be used as long as it adheres to the expected API. Required if 
     *     template is a string.	 

     */
    public $dataset = [];

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];
    private $_bloodhound = [];
    private $_datasets = [];

    /**
     * Initializes the widget
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
        if (isset($this->form)) {
            echo $this->form->field($this->model, $this->attribute, $this->fieldConfig)->textInput($this->options);
        }
        elseif ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        }
        else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    /**
     * Parse the data source array
     * @param array $source the source data
     * @return array parsed formatted source
     */
    protected function parseSource($source = [], $key)
    {
        $datumTokenizer = ArrayHelper::remove($source, 'datumTokenizer', new JsExpression('function(d) { return d.' . $key . '}'));
        if (!$datumTokenizer instanceof JsExpression) {
            $datumTokenizer = new JsExpression($datumTokenizer);
        }
        $queryTokenizer = ArrayHelper::remove($source, 'queryTokenizer', new JsExpression('Bloodhound.tokenizers.whitespace'));
        if (!$queryTokenizer instanceof JsExpression) {
            $queryTokenizer = new JsExpression($queryTokenizer);
        }
        $limit = ArrayHelper::remove($source, 'limit', 5);
        if (!is_numeric($limit)) {
            $limit = 5;
        }
        if (!empty($source['dupDetector']) && !$source['dupDetector'] instanceof JsExpression) {
            $dupDetector = new JsExpression($source['dupDetector']);
        }
        if (!empty($source['sorter']) && !$source['sorter'] instanceof JsExpression) {
            $sorter = new JsExpression($source['sorter']);
        }
        if (!empty($source['local'])) {
            $local = $source['local'];
        }
        if (!empty($source['prefetch'])) {
            $prefetch = $source['prefetch'];
        }
        if (!empty($source['remote'])) {
            $remote = $source['remote'];
            /* Add a spinning indicator for remote calls */
            $r = is_array($remote) ? $remote : ['url' => $remote];
            $hint = '$("#' . $this->options['id'] . '").parent().children(".tt-hint")';
            if (empty($r['beforeSend'])) {
                $r['beforeSend'] = new JsExpression("function (xhr) { {$hint}.addClass('loading'); }");
            }
            if (empty($r['filter'])) {
                $r['filter'] = new JsExpression("function (parsedResponse) { {$hint}.removeClass('loading'); return parsedResponse; }");
            }
            $d['remote'] = $r;
        }
        return compact('datumTokenizer', 'queryTokenizer', 'limit', 'dupDetector', 'sorter', 'local', 'prefetch', 'remote');
    }

    /**
     * Validates and sets plugin options
     */
    protected function setPluginOptions()
    {
        $i = 1;

        foreach ($this->dataset as $d) {
            /* Generate name */
            if (empty($d['name'])) {
                $d['name'] = str_replace('-', '_', $this->options['id'] . '_ta_' . $i);
            }
            if (empty($d['displayKey'])) {
                $d['displayKey'] = 'name';
            }
            $source = $d['name']; //str_replace('-', '_', $this->options['id'] . '_src_' . $i);
            $config = Json::encode($this->parseSource($d['source'], $d['displayKey']));
            $this->_bloodhound[] = "var {$source} = new Bloodhound({$config});\n{$source}.initialize();\n";
            $d['source'] = new JsExpression("{$source}.ttAdapter()");
            $this->_datasets[] = $d;
            $i++;
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        TypeaheadNewAsset::register($view);
        $this->setPluginOptions();
        $js = implode("\n", $this->_bloodhound);
        $js .= "\n" . '$("#' . $this->options['id'] . '").typeahead(' . Json::encode($this->pluginOptions) . ',' . Json::encode($this->_datasets) . ');';
        $view->registerJs($js);
        //$this->registerPlugin('typeahead');
    }

}