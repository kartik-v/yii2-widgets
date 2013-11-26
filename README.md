yii2-widgets
============

Collection of useful widgets for Yii Framework 2 and typically themed for Twitter Bootstrap. The widgets currently available are:

### Forms/Inputs
* **ActiveForm:** Facilitates all [three form layouts] (http://getbootstrap.com/css/#forms-example) available in Bootstrap i.e.
  vertical, horizontal, and inline. Allows options for offsetting labels and inputs for horizontal form layout. Works closely
  with the extended ActiveField widget.
	
* **ActiveField:** Allows Bootstrap styled [input group addons] (http://getbootstrap.com/components/#input-groups-basic) to 
  be prepended or appended to textInputs. Automatically adjusts checkboxes and radio input offsets for horizontal forms. Allows, 
  flexibility to control the labels and placeholders based on form layout style (e.g. hide labels and show them as placeholder for inline forms).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require kartik-v/yii2-widgets "dev-master"
```

or add

```
"kartik-v/yii2-widgets": "dev-master"
```

to the require section of your `composer.json` file.

## Usage

### How to call?

```php
  use kartik\widgets;
  $form = ActiveForm::begin();
```

### ActiveForm

```php
  // Horizontal Form
  $form = ActiveForm::begin([
    'id' => 'form-signup',
    'type' => ActiveForm::TYPE_HORIZONTAL
  ]);
  
  // Inline Form
  $form = ActiveForm::begin([
  		'id' => 'form-login', 
  		'type' => ActiveForm::TYPE_INLINE
  		'fieldConfig' => ['labelAsPlaceholder'=>true]
  ]);

  // Horizontal Form Configuration
  $form = ActiveForm::begin([
  		'id' => 'form-signup', 
  		'type' => ActiveForm::TYPE_HORIZONTAL
  		'formConfig' => ['labelSpan' => 2, 'spanSize' => ActiveForm::SIZE_SMALL]
  ]);
```

### ActiveField

```php
	echo $form->field($model, 'email', ['addon' => ['type'=>'prepend', 'content'=>'@']]);
	echo $form->field($model, 'amount_paid', [
	  'addon' => ['type'=>'append', 'content'=>'.00']
	]);
	echo $form->field($model, 'phone', [
	  'addon' => [
	    'type'=>'prepend', 
	    'content'=>'<i class="glyphicon glyphicon-phone'
	   ]
	]);
```

## License

**yii2-widgets** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
