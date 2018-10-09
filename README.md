yii2-widgets
============

[![Stable Version](https://poser.pugx.org/kartik-v/yii2-widgets/v/stable)](https://packagist.org/packages/kartik-v/yii2-widgets)
[![Unstable Version](https://poser.pugx.org/kartik-v/yii2-widgets/v/unstable)](https://packagist.org/packages/kartik-v/yii2-widgets)
[![License](https://poser.pugx.org/kartik-v/yii2-widgets/license)](https://packagist.org/packages/kartik-v/yii2-widgets)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-widgets/downloads)](https://packagist.org/packages/kartik-v/yii2-widgets)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-widgets/d/monthly)](https://packagist.org/packages/kartik-v/yii2-widgets)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-widgets/d/daily)](https://packagist.org/packages/kartik-v/yii2-widgets)

This extension enhances or adds functionality to existing Yii Framework 2 Widgets to make available other bundled features available in Bootstrap 3.0, new HTML 5 features and affiliated Bootstrap extras.

> NOTE: This extension has been revamped with release v3.4.1 on 05-Dec-2015. With release v3.4.0, each widget within this extension bundle has been logically regrouped and split into separate sub repositories. 
This change has been done to allow developers flexibility to install separately or specific widgets only (via composer) if needed. However, for new users installing this bundle 
should be the easiest way to give you access to all these important widget sub repositories in one shot. This change would not affect backward compatibility for any users already using the previous extension versions.

## Widgets available in this bundle

The **yii2-widgets** bundle automatically includes extensions or widgets from these sub repositories for accessing via `\kartik\widgets\` namespace.

- [yii2-krajee-base](https://github.com/kartik-v/yii2-krajee-base) 
- [yii2-widget-activeform](https://github.com/kartik-v/yii2-widget-activeform) 
- [yii2-widget-affix](https://github.com/kartik-v/yii2-widget-affix) 
- [yii2-widget-alert](https://github.com/kartik-v/yii2-widget-alert) 
- [yii2-widget-colorinput](https://github.com/kartik-v/yii2-widget-colorinput) 
- [yii2-widget-datepicker](https://github.com/kartik-v/yii2-widget-datepicker) 
- [yii2-widget-datetimepicker](https://github.com/kartik-v/yii2-widget-datetimepicker) 
- [yii2-widget-depdrop](https://github.com/kartik-v/yii2-widget-depdrop) 
- [yii2-widget-fileinput](https://github.com/kartik-v/yii2-widget-fileinput) 
- [yii2-widget-growl](https://github.com/kartik-v/yii2-widget-growl) 
- [yii2-widget-rangeinput](https://github.com/kartik-v/yii2-widget-rangeinput) 
- [yii2-widget-rating](https://github.com/kartik-v/yii2-widget-rating) 
- [yii2-widget-select2](https://github.com/kartik-v/yii2-widget-select2) 
- [yii2-widget-sidenav](https://github.com/kartik-v/yii2-widget-sidenav) 
- [yii2-widget-spinner](https://github.com/kartik-v/yii2-widget-spinner) 
- [yii2-widget-switchinput](https://github.com/kartik-v/yii2-widget-switchinput) 
- [yii2-widget-timepicker](https://github.com/kartik-v/yii2-widget-timepicker) 
- [yii2-widget-touchspin](https://github.com/kartik-v/yii2-widget-touchspin) 
- [yii2-widget-typeahead](https://github.com/kartik-v/yii2-widget-typeahead) 

## Additional related widgets

This extension has now matured to contain the most needed basic widgets for Yii 2 input and navigation controls. In order to support this extension better, any
 additional input and navigation widgets will be created separately. Listed below are the additional widgets that are related to similar functionality like the 
 `yii2-widgets`, but have been created as separate extensions (these widgets depend on `kartik-v/yii2-widgets`).

- [yii2-dropdown-x](http://demos.krajee.com/dropdown-x): Extended Bootstrap 3 dropdown menu for Yii 2.0
- [yii2-nav-x](http://demos.krajee.com/nav-x): Extended Bootstrap 3 navigation menu for Yii 2.0
- [yii2-context-menu](http://demos.krajee.com/context-menu): Bootstrap 3 context menu for Yii 2.0
- [yii2-slider](http://demos.krajee.com/slider): Bootstrap 3 Slider control for Yii 2.0
- [yii2-sortable](http://demos.krajee.com/sortable): Create sortable lists and grids using simple drag and drop.
- [yii2-sortable-input](http://demos.krajee.com/sortable-input): Input widget for **yii2-sortable** allowing you to store the sort order.
- [yii2-money](http://demos.krajee.com/money): Masked money input widget for Yii 2.0.
- [yii2-checkbox-x](http://demos.krajee.com/checkbox-x): Bootstrap 3 extended checkbox widget with 3 states and more styles for Yii 2.0.
- [yii2-date-range](http://demos.krajee.com/date-range): An extended bootstrap 3 date range picker widget for Yii 2.0.
- [yii2-editable](http://demos.krajee.com/editable): Convert any displayed content to editable using inputs, widgets, and more features for Yii 2.0.
- [yii2-label-inplace](http://demos.krajee.com/label-inplace): A form enhancement widget for Yii framework 2.0 allowing in-field label support.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Remember to refer to the [composer.json](https://github.com/kartik-v/yii2-widgets/blob/master/composer.json) for 
this extension's requirements and dependencies. 


### Pre-requisites

> Note: Check the [composer.json](https://github.com/kartik-v/yii2-widgets/blob/master/composer.json) for this extension's requirements and dependencies. 
Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

### Install

Either run

```
$ php composer.phar require kartik-v/yii2-widgets "*"
```

or add

```
"kartik-v/yii2-widgets": "*"
```

to the ```require``` section of your `composer.json` file.

## Release Updates

> Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-widgets/blob/master/CHANGE.md) for details on changes to various releases.

The widgets currently available in **yii2-widgets** are grouped by the type of usage.

### Forms/Inputs

#### ActiveForm
[```VIEW DEMO```](http://demos.krajee.com/widget-details/active-form)  

Extends [Yii ActiveForm widget](https://github.com/yiisoft/yii2/blob/master/framework/widgets/ActiveForm.php). Facilitates all [three form layouts](http://getbootstrap.com/css/#forms-example) available in Bootstrap i.e. __vertical__, __horizontal__, and __inline__. Allows options for offsetting labels and inputs for horizontal form layout. Works closely with the extended ActiveField widget.
	
#### ActiveField
[```VIEW DEMO```](http://demos.krajee.com/widget-details/active-field)

Extends [Yii ActiveField widget](https://github.com/yiisoft/yii2/blob/master/framework/widgets/ActiveField.php). Allows Bootstrap styled [input group addons](http://getbootstrap.com/components/#input-groups-basic) to be prepended or appended to textInputs. Automatically adjusts checkboxes and radio input offsets for horizontal forms. Allows, flexibility to control the labels and placeholders based on form layout style (e.g. hide labels and show them as placeholder for inline forms). The extended ActiveField functionalities available are:

- Addons
	* Prepend Addon
	* Append Addon
	* Icon Addon
	* Input Addon
	* Button Addon
	* Button Dropdown Addon
	* Segmented Button Addon
	* Prepend & Append
	* Input Group Settings
- Inputs
	* Checkbox
	* Radio
	* Checkbox List
	* Radio List
	* Static Input
	* HTML 5 Input
- Multi Select
	* Vertical Form
	* Horizontal Form
	* Radio List
	* Display Options

#### DepDrop
[```VIEW DEMO```](http://demos.krajee.com/widget-details/depdrop)

The DepDrop widget is a Yii 2 wrapper for the [dependent-dropdown jQuery plugin by Krajee](http://plugins.krajee.com/dependent-dropdown).
This plugin allows multi level dependent dropdown with nested dependencies. The plugin thus enables to convert normal
select inputs to a dependent input field, whose options are derived based on value selected in another input/or a
group of inputs. It works both with normal select options and select with optgroups as well.


#### Select2
[```VIEW DEMO```](http://demos.krajee.com/widget-details/select2)  

The Select2 widget is a Yii 2 wrapper for the [Select2 jQuery plugin](http://ivaynberg.github.io/select2). 
This input widget is a jQuery based replacement for select boxes. It supports searching, remote data sets, 
and infinite scrolling of results. The widget is specially styled for Bootstrap 3. The widget allows
graceful degradation to a normal HTML select or text input, if the browser does not support JQuery.

#### Typeahead
[```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead)

The Typeahead widget is a Yii 2 wrapper for for the [Twitter Typeahead.js](http://twitter.github.com/typeahead.js/examples) 
plugin with certain custom enhancements. This input widget is a jQuery based replacement for text inputs providing search and 
typeahead functionality. It is inspired by twitter.com's autocomplete search functionality and based on Twitter's `typeahead.js` 
which is described as as a fast and fully-featured autocomplete library. The widget is specially styled for Bootstrap 3. 
The widget allows graceful degradation to a normal HTML text input, if the browser does not support JQuery. You can setup model 
validation rules for a model attribute that uses Typeahead widget for input like any other field. The widget comes in two 
variants:

- `TypeaheadBasic`: This widget is a basic implementation of the *typeahead.js* plugin without any suggestion engine. 
  It uses a javascript substring matcher and Regular Expression matching to query and display suggestions. 
  [```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead-basic)
  
- `Typeahead`: This widget is an advanced implementation of the *typeahead.js* plugin with the *BloodHound* suggestion
   engine and the *Handlebars* template compiler.
  [```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead)
  

#### DatePicker
[```VIEW DEMO```](http://demos.krajee.com/widget-details/datepicker)  

The DatePicker widget is a Yii 2 wrapper for the [Bootstrap DatePicker plugin](http://eternicode.github.io/bootstrap-datepicker). 
The plugin is a fork of Stefan Petre's DatePicker (of eyecon.ro), with improvements by @eternicode. The widget is specially 
styled for Yii framework 2.0 and Bootstrap 3 and allows graceful degradation to a normal HTML text input, if 
the browser does not support JQuery. The widget supports these markups:

* Simple Input Markup
* Component Markup - Addon Prepended
* Component Markup - Addon Appended
* Inline / Embedded Markup
* Date Range Markup (from and to dates)

#### TimePicker
[```VIEW DEMO```](http://demos.krajee.com/widget-details/timepicker)  

The TimePicker widget  allows you to easily select a time for a text input using your mouse or keyboards arrow keys. The widget is a
wrapper enhancement of the <a href='https://github.com/rendom/bootstrap-3-timepicker' target='_blank'>TimePicker plugin</a> by rendom 
forked from  <a href='https://github.com/jdewit/bootstrap-timepicker' target='_blank'>jdewit's TimePicker</a>. This widget as used 
here has been specially enhanced for Yii framework 2.0 and Bootstrap 3.

#### DateTimePicker
[```VIEW DEMO```](http://demos.krajee.com/widget-details/datetimepicker)  

The DateTimePicker widget is a Yii 2 wrapper for the [Bootstrap DateTimePicker plugin](http://www.malot.fr/bootstrap-datetimepicker). 
The plugin is a fork of the DateTimePicker plugin by @eternicode and adds the time functionality. The widget is similar to the DatePicker
widget in most aspects, except that it adds the time functionality and does not support ranges. The widget is specially styled for Yii 
framework 2.0 and Bootstrap 3 and allows graceful degradation to a normal HTML text input, if the browser does not support JQuery. 
The widget supports these markups:

* Simple Input Markup
* Component Markup - Addon Prepended
* Component Markup - Addon Appended
* Inline / Embedded Markup

#### TouchSpin
[```VIEW DEMO```](http://demos.krajee.com/widget-details/touchspin)  

The TouchSpin widget is a Yii 2 wrapper for for the [bootstrap-touchspin](http://www.virtuosoft.eu/code/bootstrap-touchspin) plugin by István Ujj-Mészáros, with certain additional enhancements. This input widget is a mobile and touch friendly input spinner component for Bootstrap 3. You can use the widget buttons to rapidly increase and decrease numeric and/or decimal values in your input field. The widget can be setup to include model validation rules for the related model attribute. 

#### FileInput
[```VIEW DEMO```](http://demos.krajee.com/widget-details/fileinput)  

The FileInput widget is a customized file input widget based on Krajee's [Bootstrap FileInput JQuery Plugin](http://plugins.krajee.com/file-input). The widget enhances the default HTML file input with various features including the following:

* Specially styled for Bootstrap 3.0 with customizable buttons, caption, and preview
* Ability to select and preview multiple files
* Includes file browse and optional remove and upload buttons.
* Ability to format your file picker button styles
* Ability to preview files before upload - images and/or text (uses HTML5 FileReader API)
* Ability to preview multiple files of different types (both images and text)
* Set your upload action/route (defaults to form submit). Customize the Upload and Remove buttons.
* Internationalization enabled for easy translation to various languages

##### Future planned enhancements:

* Drag and drop functionality
* Realign/Rearrange the items in preview window
* Better captioning for each file in the preview window
* Support for previewing content other than image and text (e.g. HTML)

The widget runs on all modern browsers supporting HTML5 File Inputs and File Processing API. For browser versions IE9 and below, this widget will gracefully degrade to normal HTML file input. The widget is vastly inspired by this [blog article](http://www.abeautifulsite.net/blog/2013/08/whipping-file-inputs-into-shape-with-bootstrap-3) and [Jasny's File Input plugin](http://jasny.github.io/bootstrap/javascript/#fileinput).

#### ColorInput
[```VIEW DEMO```](http://demos.krajee.com/widget-details/colorinput)  

The ColorInput widget is an advanced ColorPicker input styled for Bootstrap. It uses a combination of the HTML5 color input and/or the [JQuery Spectrum Plugin](http://bgrins.github.io/spectrum) for rendering the color picker. You can use the Native HTML5 color input by setting the `useNative` option to `true`. Else, the Spectrum plugin polyfills for unsupported browser versions.

* Specially styled for Bootstrap 3.0 with customizable caption showing the output of the control.
* Ability to prepend and append addons.
* Allow the input to be changed both via the control or the text box.
* The Spectrum plugin automatically polyfills the `HTML5 color input` for unsupported browser versions.

#### RangeInput
[```VIEW DEMO```](http://demos.krajee.com/widget-details/rangeinput)  

The RangeInput widget is a customized range slider control widget based on HTML5 range input. The widget enhances the default HTML range input with various features including the following:

* Specially styled for Bootstrap 3.0 with customizable caption showing the output of the control.
* Ability to prepend and append addons (very useful to show the min and max ranges, and the slider measurement unit).
* Allow the input to be changed both via the control or the text box.
* Automatically degrade to normal text input for unsupported Internet Explorer versions.

#### SwitchInput
[```VIEW DEMO```](http://demos.krajee.com/widget-details/switchinput)  

The SwitchInput widget turns checkboxes and radio buttons into toggle switches. The plugin is a wrapper for the [Bootstrap Switch Plugin](http://www.bootstrap-switch.org) and is specially styled for Bootstrap 3.

#### StarRating
[```VIEW DEMO```](http://demos.krajee.com/widget-details/star-rating)  

The StarRating widget is a wrapper for the [Bootstrap Star Rating Plugin](http://plugins.krajee.com/star-rating) JQuery Plugin designed by Krajee. This plugin is a simple yet powerful JQuery star rating plugin for Bootstrap. Developed with a focus on utlizing pure CSS-3 styling to render the control.

### Progress

#### Spinner
[```VIEW DEMO```](http://demos.krajee.com/widget-details/spinner)  

The Spinner widget is a wrapper for the [spin.js](http://fgnass.github.io/spin.js). It enables you to add an animated CSS3 loading spinner which allows VML fallback for IE.
Since, its not image based, it allows you to configure the spinner style, size, color, and other CSS attributes. The major advantage of using the CSS3 based spinner, is
that the animation can be made visible to user for non-ajax based scenarios. For example on  events like window.load or window.unload (thereby enabling you to show a 
page loading progress without using ajax).

### Navigation

#### Affix
[```VIEW DEMO```](http://demos.krajee.com/affix-demo)  

Extends [Yii Menu widget](https://github.com/yiisoft/yii2/blob/master/framework/widgets/Menu.php). This widget offers a [scrollspy](http://getbootstrap.com/javascript/#scrollspy) and [affixed](http://getbootstrap.com/javascript/#affix) enhanced navigation (upto 2-levels) to highlight sections and secondary sections in each page. The affix widget can be used to generate both the:

- **Sidebar Menu:** Displays the scrollspy/affix navigation menu as a sidebar, and/or
- **Main Body:** Displays the main body sections based on the section & subsection headings and content passed.

The parameters to pass are:

- `type` The affix content type. Must be either `menu` or `body`. Defaults to `menu`
- `items`: The affix content items as an array. Check the [affix combined usage](http://demos.krajee.com/widget-details/affix#affix-menu-body) for a detailed example.

> **Note:**
> If you have the `header` section fixed to the top, you must add a CSS class `kv-header` to the header container. Similarly, for a fixed footer you must add the class `kv-footer` to your footer container. This will ensure a correct positioning of the affix widget on the page.


#### SideNav
[```VIEW DEMO```](http://demos.krajee.com/sidenav-demo/profile/default)  

This widget is a collapsible side navigation menu built to seamlessly work with Bootstrap framework. It is built over Bootstrap [stacked nav](http://getbootstrap.com/components/#nav-pills) component. This widget class extends the [Yii Menu widget](https://github.com/yiisoft/yii2/blob/master/framework/widgets/Menu.php). Upto 3 levels of submenus are by default supported by the CSS styles to balance performance and useability. You can choose to extend it to more or less levels by customizing the [CSS](https://github.com/kartik-v/yii2-widgets/blob/master/assets/css/sidenav.css).

### Notification

#### Alert
[```VIEW DEMO```](http://demos.krajee.com/widget-details/alert)  

Extends the \yii\bootstrap\Alert widget with more easy styling and auto fade out options.

#### Growl
[```VIEW DEMO```](http://demos.krajee.com/widget-details/growl)  

A widget that turns standard Bootstrap alerts into "Growl-like" notifications. This widget is a wrapper for the Bootstrap Growl [plugin by remabledesigns](http://bootstrap-growl.remabledesigns.com).
 
#### AlertBlock
[```VIEW DEMO```](http://demos.krajee.com/widget-details/alert-block)  

Alert block widget that groups multiple `\kartik\widget\Alert` or `kartik\widget\Growl` widgets in one single block and renders them stacked vertically on the current page. 
You can choose the `TYPE_ALERT` style or the `TYPE_GROWL` style for your notifications. You can also set the widget to automatically read and display session flash 
messages (which is the default setting). Alternatively, you can setup and configure your own block of custom alerts.
 
### Demo
You can see a [demonstration here](http://demos.krajee.com/widgets) on usage of these widgets with documentation and examples.

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
   	echo $form->field($model, 'email', ['addon' => ['prepend' => ['content'=>'@']]]);
   	
   	// Append an addon text
	echo $form->field($model, 'amount_paid', [
  		'addon' => ['append' => ['content'=>'.00']]
	]);
	
	// Formatted addons (like icons)
	echo $form->field($model, 'phone', [
		'addon' => [
			'prepend' => [
				'content' => '<i class="glyphicon glyphicon-phone"></i>'
			]
		]
	]);
	
	// Formatted addons (inputs)
	echo $form->field($model, 'phone', [
		'addon' => [
			'prepend' => [
				'content' => '<input type="radio">'
			]
		]
	]);
	
	// Formatted addons (buttons)
	echo $form->field($model, 'phone', [
		'addon' => [
			'prepend' => [
				'content' => Html::button('Go', ['class'=>'btn btn-primary'])
			]
			'asButton' => true
		]
	]);
```

### DepDrop
```php
	// Normal parent select
	echo $form->field($model, 'cat')->dropDownList($catList, ['id'=>'cat-id']);

	// Dependent Dropdown
    echo $form->field($model, 'subcat')->widget(DepDrop::classname(), [
         'options' => ['id'=>'subcat-id'],
         'pluginOptions'=>[
             'depends'=>['cat-id'],
             'placeholder' => 'Select...',
             'url' => Url::to(['/site/subcat'])
         ]
     ]);
```

### Select2
```php
	// Normal select with ActiveForm & model
	echo $form->field($model, 'state_1')->widget(Select2::classname(), [
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

### Typeahead
```php
use kartik\widgets\TypeaheadBasic;

// TypeaheadBasic usage with ActiveForm and model
echo $form->field($model, 'state_3')->widget(Typeahead::classname(), [
	'data' => $data,
    'pluginOptions' => ['highlight' => true],
	'options' => ['placeholder' => 'Filter as you type ...'],
]);

// Typeahead usage with ActiveForm and model
echo $form->field($model, 'state_4')->widget(Typeahead::classname(), [
	'dataset' => [
		[
			'local' => $data,
			'limit' => 10
		]
	],
    'pluginOptions' => ['highlight' => true],
	'options' => ['placeholder' => 'Filter as you type ...'],
]);
```

### DatePicker
```php
use kartik\widgets\DatePicker;

// usage without model
echo '<label>Check Issue Date</label>';
echo DatePicker::widget([
	'name' => 'check_issue_date', 
	'value' => date('d-M-Y', strtotime('+2 days')),
	'options' => ['placeholder' => 'Select issue date ...'],
	'pluginOptions' => [
		'format' => 'dd-M-yyyy',
		'todayHighlight' => true
	]
]);
```

### TimePicker
```php
use kartik\widgets\TimePicker;

// usage without model
echo '<label>Start Time</label>';
echo TimePicker::widget([
	'name' => 'start_time', 
	'value' => '11:24 AM',
	'pluginOptions' => [
		'showSeconds' => true
	]
]);
```

### DateTimePicker
```php
use kartik\widgets\DateTimePicker;

// usage without model
echo '<label>Start Date/Time</label>';
echo DateTimePicker::widget([
    'name' => 'datetime_10',
    'options' => ['placeholder' => 'Select operating time ...'],
    'convertFormat' => true,
    'pluginOptions' => [
        'format' => 'd-M-Y g:i A',
        'startDate' => '01-Mar-2014 12:00 AM',
        'todayHighlight' => true
    ]
]);
```

### TouchSpin
```php
use kartik\widgets\TouchSpin;

echo TouchSpin::widget([
    'name' => 'volume',
    'options' => ['placeholder' => 'Adjust...'],
    'pluginOptions' => ['step' => 1]
]);
```

### FileInput
```php
use kartik\widgets\FileInput;

// Usage with ActiveForm and model
echo $form->field($model, 'avatar')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
]);

// With model & without ActiveForm
echo '<label class="control-label">Add Attachments</label>';
echo FileInput::widget([
    'model' => $model,
    'attribute' => 'attachment_1',
    'options' => ['multiple' => true]
]);
```

### ColorInput
```php
use kartik\widgets\ColorInput;

// Usage with ActiveForm and model
echo $form->field($model, 'color')->widget(ColorInput::classname(), [
    'options' => ['placeholder' => 'Select color ...'],
]);

// With model & without ActiveForm
echo '<label class="control-label">Select Color</label>';
echo ColorInput::widget([
    'model' => $model,
    'attribute' => 'saturation',
]);
```

### RangeInput
```php
use kartik\widgets\RangeInput;

// Usage with ActiveForm and model
echo $form->field($model, 'rating')->widget(RangeInput::classname(), [
    'options' => ['placeholder' => 'Select color ...'],
    'html5Options' => ['min'=>0, 'max'=>1, 'step'=>1],
    'addon' => ['append'=>['content'=>'star']]
]);

// With model & without ActiveForm
echo '<label class="control-label">Adjust Contrast</label>';
echo RangeInput::widget([
    'model' => $model,
    'attribute' => 'contrast',
    'addon' => ['append'=>['content'=>'%']]
]);
```

### SwitchInput
```php
use kartik\widgets\SwitchInput;

// Usage with ActiveForm and model
echo $form->field($model, 'status')->widget(SwitchInput::classname(), [
    'type' => SwitchInput::CHECKBOX
]);


// With model & without ActiveForm
echo SwitchInput::widget([
    'name' => 'status_1',
    'type' => SwitchInput::RADIO
]);
```

### StarRating
```php
use kartik\widgets\StarRating;

// Usage with ActiveForm and model
echo $form->field($model, 'rating')->widget(StarRating::classname(), [
    'pluginOptions' => ['size'=>'lg']
]);


// With model & without ActiveForm
echo StarRating::widget([
    'name' => 'rating_1',
    'pluginOptions' => ['disabled'=>true, 'showClear'=>false]
]);
```

### Spinner
```php
use kartik\widgets\Spinner;
<div class="well">
<?= Spinner::widget([
    'preset' => Spinner::LARGE,
    'color' => 'blue',
    'align' => 'left'
])?>
</div>
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

#### Alert
```php
use kartik\widgets\Alert;

echo Alert::widget([
	'type' => Alert::TYPE_INFO,
	'title' => 'Note',
	'titleOptions' => ['icon' => 'info-sign'],
	'body' => 'This is an informative alert'
]);
```

#### Growl
```php
use kartik\widgets\Growl;

echo Growl::widget([
	'type' => Growl::TYPE_SUCCESS,
	'icon' => 'glyphicon glyphicon-ok-sign',
	'title' => 'Note',
	'showSeparator' => true,
	'body' => 'This is a successful growling alert.'
]);
```

#### AlertBlock
```php
use kartik\widgets\AlertBlock;

echo AlertBlock::widget([
	'type' => AlertBlock::TYPE_ALERT,
	'useSessionFlash' => true
]);
```

## License

**yii2-widgets** is released under the BSD-3-Clause License. See the bundled `LICENSE.md` for details.
