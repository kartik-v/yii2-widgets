yii2-widgets
============

This extension enhances or adds functionality to existing Yii Framework 2 Widgets to make available other bundled features available in Twitter Bootstrap or other Bootstrap extras. The widgets currently available are:

### Forms/Inputs
* **ActiveForm:** Extends [Yii ActiveForm widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/ActiveForm.php). Facilitates all [three form layouts](http://getbootstrap.com/css/#forms-example) available in Bootstrap i.e. __vertical__, __horizontal__, and __inline__. Allows options for offsetting labels and inputs for horizontal form layout. Works closely with the extended ActiveField widget.
	
* **ActiveField:** Extends [Yii ActiveField widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/ActiveField.php). Allows Bootstrap styled [input group addons](http://getbootstrap.com/components/#input-groups-basic) to be prepended or appended to textInputs. Automatically adjusts checkboxes and radio input offsets for horizontal forms. Allows, flexibility to control the labels and placeholders based on form layout style (e.g. hide labels and show them as placeholder for inline forms).

### Upcoming
* Nav
* Sidenav
* Gridview
* Panel
* Affix
* and more...

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

to the ```require``` section of your `composer.json` file.

## Usage

### How to call?

```php
	// add this in your view
	use kartik\widgets\ActiveForm;
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
	// Prepend an addon text
   	echo $form->field($model, 'email', ['addon' => ['type'=>'prepend', 'content'=>'@']]);
   	
   	// Append an addon text
	echo $form->field($model, 'amount_paid', [
  		'addon' => ['type' => 'append', 'content'=>'.00']
	]);
	
	// Formatted addons (like icons)
	echo $form->field($model, 'phone', [
		'addon' => [
			'type' => 'prepend', 
			'content' => '<i class="glyphicon glyphicon-phone"></i>'
		]
	]);
	
	// Formatted addons (inputs)
	echo $form->field($model, 'phone', [
		'addon' => [
			'type' => 'prepend', 
			'content' => '<input type="radio">'
		]
	]);
	
	// Formatted addons (buttons)
	echo $form->field($model, 'phone', [
		'addon' => [
			'type' => 'prepend', 
			'content' => Html::button('Go', ['class'=>'btn btn-primary']),
			'asButton' => true
		]
	]);
	
```

## License

**yii2-widgets** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
