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
use yii\web\JsExpression;

/**
 * FileInput widget styled for Bootstrap 3.0 with ability to multiple file
 * selection and preview, format button styles and inputs. Runs on all modern
 * browsers supporting HTML5 File Inputs and File Processing API. For browser
 * versions IE9 and below, this widget will gracefully degrade to normal HTML
 * file input.
 *
 * Wrapper for the Bootstrap FileInput JQuery Plugin by Krajee
 *
 * @see http://plugins.krajee.com/bootstrap-fileinput
 * @see https://github.com/kartik-v/bootstrap-fileinput
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0: C
 *
 * @see http://twitter.github.com/typeahead.js/examples
 */
class FileInput extends InputWidget
{
    /**
     * @var bool whether to show 'plugin unsupported' message for IE browser versions 9 & below
     */
    public $showMessage = true;

    /*
     * @var array HTML attributes for the container for the warning
     * message for browsers running IE9 and below.
     */
    public $messageOptions = ['class' => 'alert alert-warning'];

    /**
     * @var array the internalization configuration for this widget
     */
    public $i18n = [];

    /**
     * @var array initialize the FileInput widget
     */
    public function init()
    {
        parent::init();
        Yii::setAlias('@fileinput', dirname(__FILE__));
        if (empty($this->i18n)) {
            $this->i18n = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@fileinput/messages'
            ];
        }
        Yii::$app->i18n->translations['fileinput'] = $this->i18n;
        $this->registerAssets();
        $input = $this->getInput('fileInput');
        if ($this->showMessage) {
            $validation = ArrayHelper::getValue($this->pluginOptions, 'showPreview', true) ? 'file preview and multiple file upload' : 'multiple file upload';
            $message = '<strong>' . Yii::t('fileinput', 'Note:') . '</strong> ' . Yii::t('fileinput', 'Your browser does not support {validation}. Try an alternative or more recent browser to access these features.', ['validation' => $validation]);
            $content = Html::tag('div', $message, $this->messageOptions);
            $input .= "\n<br>" . $this->validateIE($content);
        }
        echo $input;
    }

    /**
     * Validates and returns content based on IE browser version validation
     *
     * @param string $content
     * @param string $validation
     * @return string
     */
    protected function validateIE($content, $validation = 'lt IE 10')
    {
        return "<!--[if {$validation}]>{$content}<![endif]-->";
    }

    /**
     * Set the default plugin option
     *
     * @param string $key the array key in [[pluginOptions]]
     * @param string $value the value for the key in [[pluginOptions]]
     */
    private function setPluginDefault($key, $value)
    {
        if (empty($this->pluginOptions[$key])) {
            $this->pluginOptions[$key] = $value;
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        FileInputAsset::register($view);

        $this->setPluginDefault('browseLabel', Yii::t('fileinput', 'Browse') . '&hellip;');
        $this->setPluginDefault('uploadLabel', Yii::t('fileinput', 'Upload'));
        $this->setPluginDefault('removeLabel', Yii::t('fileinput', 'Remove'));

        foreach ($this->pluginOptions as $key => $value) {
            if (substr($key, 0, 2) === "el" && !($value instanceof JsExpression)) {
                $this->pluginOptions[$key] = new JsExpression($value);
            }
        }

        $this->registerPlugin('fileinput');
    }
}
