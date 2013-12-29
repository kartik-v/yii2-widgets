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


#### Select2
[```VIEW DEMO```](http://demos.krajee.com/widget-details/select2)  

The Select2 widget is a Yii 2 wrapper for the [Select2 jQuery plugin](http://ivaynberg.github.io/select2/). 
This input widget is a jQuery based replacement for select boxes. It supports searching, remote data sets, 
and infinite scrolling of results. The widget is specially styled for Twitter Bootstrap 3. The widget allows
graceful degradation to a normal HTML select or text input, if the browser does not support JQuery.

### Navigation

#### Affix
[```VIEW DEMO```](http://demos.krajee.com/affix-demo)  

Extends [Yii Menu widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/Menu.php). This widget offers a [scrollspy](http://getbootstrap.com/javascript/#scrollspy) and [affixed](http://getbootstrap.com/javascript/#affix) enhanced navigation (upto 2-levels) to highlight sections and secondary sections in each page. The affix widget can be used to generate both the:

- **Sidebar Menu:** Displays the scrollspy/affix navigation menu as a sidebar, and/or
- **Main Body:** Displays the main body sections based on the section & subsection headings and content passed.

The parameters to pass are:

- `type` The affix content type. Must be either `menu` or `body`. Defaults to `menu`
- `items`: The affix content items as an array. Check the [affix combined usage](http://demos.krajee.com/widget-details/affix#affix-menu-body) for a detailed example.

> **Note:**
> If you have the `header` section fixed to the top, you must add a CSS class `kv-header` to the header container. Similarly, for a fixed footer you must add the class `kv-footer` to your footer container. This will ensure a correct positioning of the affix widget on the page.


#### SideNav
[```VIEW DEMO```](http://demos.krajee.com/sidenav-demo/profile/default)  

This widget is a collapsible side navigation menu built to seamlessly work with Twitter Bootstrap framework. It is built over Twitter Bootstrap [stacked nav](http://getbootstrap.com/components/#nav-pills) component. This widget class extends the [Yii Menu widget](https://github.com/yiisoft/yii2/blob/master/framework/yii/widgets/Menu.php). Upto 3 levels of submenus are by default supported by the CSS styles to balance performance and useability. You can choose to extend it to more or less levels by customizing the [CSS](https://github.com/kartik-v/yii2-widgets/blob/master/assets/css/sidenav.css).

### Demo
You can see a [demonstration here](http://demos.krajee.com/widgets) on usage of these widgets with documentation and examples.

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

### Select2
```php
	// Normal select with ActiveForm & model
	echo Select2::widget([
		'model' => $model, 
		'attribute' => 'state_1',
		'form' => $form,
		'data' => array_merge(["" => ""], $data),
		'language' => 'de',
		'options' => ['placeholder' => 'Select a state ...'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);

	// Multiple select without model
	echo Select2::widget([
		'name' => 'state_2',
		'value' => '',
		'data' => $data,
		'options' => ['multiple' => true, 'placeholder' => 'Select states ...']
	]);
```

### Affix
```php
$content = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.';
$items = [[
	'url' => '#sec-1',
	'label' => 'Section 1',
	'icon' => 'play-circle',
	'content' => $content,
	'items' => [
		 ['url' => '#sec-1-1', 'label' => 'Section 1.1', 'content' => $content],
		 ['url' => '#sec-1-2', 'label' => 'Section 1.2', 'content' => $content],
		 ['url' => '#sec-1-3', 'label' => 'Section 1.3', 'content' => $content],
		 ['url' => '#sec-1-4', 'label' => 'Section 1.4', 'content' => $content],
		 ['url' => '#sec-1-5', 'label' => 'Section 1.5', 'content' => $content],
	],
]];

// Displays sidebar menu
echo Affix::widget([
	'items' => $items, 
	'type' => 'menu'
]);

// Displays body sections
echo Affix::widget([
	'items' => $items, 
	'type' => 'body'
]);
```

### SideNav
```php
use kartik\widgets\SideNav;
     
echo SideNav::widget([
	'type' => SideNav::TYPE_DEFAULT,
	'heading' => 'Options',
	'items' => [
		[
			'url' => '#',
			'label' => 'Home',
			'icon' => 'home'
		],
		[
			'label' => 'Help',
			'icon' => 'question-sign',
			'items' => [
				['label' => 'About', 'icon'=>'info-sign', 'url'=>'#'],
				['label' => 'Contact', 'icon'=>'phone', 'url'=>'#'],
			],
		],
	],
]);
```

## License

**yii2-widgets** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
