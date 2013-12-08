yii2-widgets
============

This extension enhances or adds functionality to existing Yii Framework 2 Widgets to make available other bundled features available in Twitter Bootstrap 3.0, new HTML 5 features and affiliated Bootstrap extras. The widgets currently available are:

### Forms/Inputs

#### ActiveForm
[```VIEW DEMO```](http://demos.krajee.com/widget-details/active-form)  

Extends [Yii ActiveForm widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/ActiveForm.php). Facilitates all [three form layouts](http://getbootstrap.com/css/#forms-example) available in Bootstrap i.e. __vertical__, __horizontal__, and __inline__. Allows options for offsetting labels and inputs for horizontal form layout. Works closely with the extended ActiveField widget.
	
#### ActiveField
[```VIEW DEMO```](http://demos.krajee.com/widget-details/active-field)

Extends [Yii ActiveField widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/ActiveField.php). Allows Bootstrap styled [input group addons](http://getbootstrap.com/components/#input-groups-basic) to be prepended or appended to textInputs. Automatically adjusts checkboxes and radio input offsets for horizontal forms. Allows, flexibility to control the labels and placeholders based on form layout style (e.g. hide labels and show them as placeholder for inline forms). The extended ActiveField functionalities available are:

- Addons
	* Prepend Addon
	* Append Addon
	* Icon Addon
	* Input Addon
	* Button Addon
	* Button Dropdown Addon
	* Segmented Button Addon
- Inputs
	* Checkbox
	* Radio
	* Checkbox List
	* Radio List
	* Static Input
	* Range Input
	* HTML 5 Input
- Multi Select
	* Vertical Form
	* Horizontal Form
	* Radio List
	* Display Options

### Navigation

#### Affix
[```VIEW DEMO```](http://demos.krajee.com/widget-details/affix)  

Extends [Yii Menu widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/Menu.php). This widget offers a [scrollspy](http://getbootstrap.com/javascript/#scrollspy) and [affixed](http://getbootstrap.com/javascript/#affix) enhanced navigation (upto 2-levels) to highlight sections and secondary sections in each page. The affix widget can be used to generate both the:

- **Sidebar Menu:** Displays the scrollspy/affix navigation menu as a sidebar, and/or
- **Main Body:** Displays the main body sections based on the section & subsection headings and content passed.

The parameters to pass are:

- `type` The affix content type. Must be either `menu` or `body`. Defaults to `menu`
- `items`: The affix content items as an array. Check the [affix combined usage](http://demos.krajee.com/widget-details/affix#affix-menu-body) for a detailed example.

> **Note:**
> If you have a bootstrap Navbar component fixed on the top, you must add a CSS class `kv-nav` to the navbar. Similarly, for a fixed footer you must add the class `kv-footer` to your footer container. This will ensure the correct positioning of the affix widget.

### Demo
You can see a [demonstration here](http://demos.krajee.com/widgets) on usage of these widgets with documentation and examples.

### Upcoming
* Nav
* Sidenav
* Gridview
* Panel
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
	// Vertical Form
	$form = ActiveForm::begin([
		'id' => 'form-signup',
		'type' => ActiveForm::TYPE_VERTICAL
	]);
  
	// Inline Form
	$form = ActiveForm::begin([
		'id' => 'form-login', 
		'type' => ActiveForm::TYPE_INLINE,
		'fieldConfig' => ['autoPlaceholder'=>true]
	]);

  	// Horizontal Form Configuration
  	$form = ActiveForm::begin([
  		'id' => 'form-signup', 
  		'type' => ActiveForm::TYPE_HORIZONTAL,
		'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
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
