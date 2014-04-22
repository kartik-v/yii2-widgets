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
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * Typeahead widget is a Yii2 wrapper for the Twitter typeahead.js plugin. This
 * input widget is a jQuery based replacement for text inputs providing search
 * and typeahead functionality. It is inspired by twitter.com's autocomplete search
 * functionality and based on Twitter's typeahead.js which Twitter mentions as
 * a fast and fully-featured autocomplete library.
 *
 * This is an advanced implementation of the typeahead.js plugin included with the
 * Bloodhound suggestion engine.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class Typeahead extends TypeaheadBasic
{

    /**
     * @var array dataset an object that defines a set of data that hydrates suggestions.
     * It consists of the following special variable settings:
     * - local: array configuration for the [[local]] list of datums. You must set one of
     *   [[local]], [[prefetch]], or [[remote]].
     * - displayKey: string the key used to access the value of the datum in the datum
     *   object. Defaults to 'value'.
     * - prefetch: array configuration for the [[prefetch]] options object.
     * - remote: array configuration for the [[remote]] options object.
     * - limit: integer the max number of suggestions from the dataset to display for
     *   a given query. Defaults to 8.
     * - dupDetector: JsExpression, a function with the signature (remoteMatch, localMatch) that returns
     *   true if the datums are duplicates or false otherwise. If not set, duplicate detection will not
     *   be performed.
     * - sorter – JsExpression, a compare function used to sort matched datums for a given query.
     * - templates: array the templates used to render suggestions.
     */
    public $dataset = [];

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * @var string the generated Bloodhound script
     */
    protected $_bloodhound;

    /**
     * @var string the generated Json encoded Dataset script
     */
    protected $_dataset;

    /**
     * Runs the widget
     *
     * @return string|void
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        if (empty($this->dataset) || !is_array($this->dataset)) {
            throw new InvalidConfigException("You must define the 'dataset' property for Typeahead which must be an array.");
        }
        if (!is_array(current($this->dataset))) {
            throw new InvalidConfigException("The 'dataset' array must contain an array of datums. Invalid data found.");
        }
        $this->validateConfig();
        $this->initDataset();
        $this->registerAssets();
        $this->initOptions();
        echo Html::tag('div', $this->getInput('textInput'), $this->container);
    }

    /**
     * @return void Validate if configuration is valid
     * @throws \yii\base\InvalidConfigException
     */
    protected function validateConfig()
    {
        foreach ($this->dataset as $datum) {
            if (empty($datum['local']) && empty($datum['prefetch']) && empty($datum['remote'])) {
                throw new InvalidConfigException("No data source found for the Typeahead. The 'dataset' array must have one of 'local', 'prefetch', or 'remote' settings enabled.");
            }
        }
    }

    /**
     * Initialize the data set
     */
    protected function initDataset()
    {
        $index = 1;
        $this->_bloodhound = '';
        $this->_dataset = '';
        $dataset = [];
        foreach ($this->dataset as $datum) {
            $dataVar = strtr(strtolower($this->options['id'] . '_data_' . $index), ['-' => '_']);
            $this->_bloodhound .= "var {$dataVar} = new Bloodhound(" .
                Json::encode($this->parseSource($datum)) . ");\n" .
                "{$dataVar}.initialize();\n";
            $d = ['name' => $dataVar, 'source' => new JsExpression($dataVar . '.ttAdapter()')];
            if (!empty($datum['displayKey'])) {
                $d += ['displayKey' => $datum['displayKey']];
            }
            if (!empty($datum['templates'])) {
                $d += ['templates' => $datum['templates']];
            }
            $dataset[] = $d;
            $index++;
        }
        $this->_dataset .= Json::encode($dataset);
    }

    /**
     * Parses the data source array and prepares the bloodhound configuration
     *
     * @param array $source the source data
     * @return array parsed formatted source
     */
    protected function parseSource($source = [])
    {
        $key = ArrayHelper::getValue($source, 'displayKey', 'value');
        $datumTokenizer = ArrayHelper::remove($source, 'datumTokenizer', new JsExpression("Bloodhound.tokenizers.obj.whitespace('{$key}')"));
        if (!$datumTokenizer instanceof JsExpression) {
            $datumTokenizer = new JsExpression($datumTokenizer);
        }
        $queryTokenizer = ArrayHelper::remove($source, 'queryTokenizer', new JsExpression('Bloodhound.tokenizers.whitespace'));
        if (!$queryTokenizer instanceof JsExpression) {
            $queryTokenizer = new JsExpression($queryTokenizer);
        }
        $limit = ArrayHelper::remove($source, 'limit', 8);
        if (!is_numeric($limit)) {
            $limit = 8;
        }
        if (!empty($source['dupDetector']) && !$source['dupDetector'] instanceof JsExpression) {
            $dupDetector = new JsExpression($source['dupDetector']);
        }
        if (!empty($source['sorter']) && !$source['sorter'] instanceof JsExpression) {
            $sorter = new JsExpression($source['sorter']);
        }
        if (!empty($source['local']) && is_array($source['local'])) {
            $local = new JsExpression('$.map(' . Json::encode(array_values($source['local'])) . ", function(v){ return{{$key}:v}; })");
        } elseif (!empty($source['local'])) {
            $local = ($source['local'] instanceof JsExpression) ? $source['local'] : new JsExpression($source['local']);
        }
        if (!empty($source['prefetch'])) {
            $prefetch = $source['prefetch'];
            if (!is_array($prefetch)) {
                $prefetch = ['url' => $prefetch];
            }
        }
        if (!empty($source['remote'])) {
            $remote = $source['remote'];
            /* Add a spinning indicator for remote calls */
            $r = is_array($remote) ? $remote : ['url' => $remote];
            $hint = '$("#' . $this->options['id'] . '")';
            if (empty($r['beforeSend'])) {
                $r['beforeSend'] = new JsExpression("function (xhr) { alert('before'); {$hint}.addClass('loading'); }");
            }
            if (empty($r['filter'])) {
                $r['filter'] = new JsExpression(
                    "function(list) {
                        alert('after');
                        {$hint}.removeClass('loading');
                    }"
                );
            }
            $d['remote'] = $r;
        }
        return compact('datumTokenizer', 'queryTokenizer', 'limit', 'dupDetector', 'sorter', 'local', 'prefetch', 'remote');
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        TypeaheadAsset::register($view);
        $this->registerPluginOptions('typeahead');
        $view->registerJs($this->_bloodhound);
        $view->registerJs('$("#' . $this->options['id'] . '").typeahead(' . $this->_hashVar . ',' . $this->_dataset . ');');
        $this->registerPluginEvents($view);
    }
}
