<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 3.4.1
 */

namespace kartik\widgets;

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
class Affix extends \kartik\affix\Affix
{
}
