<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 3.4.1
 */

namespace kartik\widgets;

/**
 * Extends the ActiveField component to handle various bootstrap form types and handle input groups.
 *
 * Example(s):
 * ```php
 *    echo $this->form->field($model, 'email', ['addon' => ['type'=>'prepend', 'content'=>'@']]);
 *    echo $this->form->field($model, 'amount_paid', ['addon' => ['type'=>'append', 'content'=>'.00']]);
 *    echo $this->form->field($model, 'phone', ['addon' => ['type'=>'prepend', 'content'=>'<i class="glyphicon
 *     glyphicon-phone']]);
 * ```
 *
 * @property ActiveForm $form
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class ActiveField extends \kartik\form\ActiveField
{
}