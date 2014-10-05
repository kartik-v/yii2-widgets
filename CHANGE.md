version 2.9.0
=============
**Date:** 14-Aug-2014

1. bug #132: Enhance growl widget for major changes to core plugin.
2. Separate animation enhancements added to growl.
3. enh # 150: Enhance `ColorInput` widget to allow controlling display of default palette of colors.
4. bug # 151: Remove duplicate encoding for placeholder.
5. enh # 153: Various enhancements to `ColorInput` widget to read colors correctly based on plugin `preferredFormat`.
6. bug # 157: Correct duplicate `label` displayed after SwitchInput.
7. PSR4 alias change


version 2.8.0
=============
**Date:** 31-Jul-2014

1. enh #119, #121: Various styling enhancements to Select2.
2. enh #122: Upgrade bootstrap growl to latest plugin version with various related enhancements
3. enh #71: Created separate [yii2-editable](https://github.com/kartik-v/yii2-editable) extension

version 2.7.0
=============
**Date:** 18-Jul-2014

1. enh #96: Enhanced DatePicker, DateTimePicker, and TimePicker to work along with the new `autoWidgetSettings` for DateControl module .
2. enh #98: Added `language` configuration property for  DatePicker, DateTimePicker, and TimePicker.
3. bug #99: Fix DateControl to work for date time formatting with DateTimePicker. 
4. enh #104: Add more information to documentation for Select2 widget and explain placeholder setting when `allowClear` is `true`. 
5. enh #106: Added Turkish translations for FileInput widget.
6. bug #110: Allow use of Select2 with tags, when tags are empty.
7. enh #111: Allow configuring of template for each item in SideNav.
8. Added `iconPrefix` property in SideNav to easily configure with more icon frameworks (other than glyphicon).

version 2.6.0
=============
**Date:** 01-Jul-2014

1. Issue Fixes from #73 to #95.
2. Added `language` property to `InputWidget` along with `initLanguage` method for automatic language setting in `pluginOptions`.
   The `language` property will be auto defaulted to `Yii::$app->language` if not set.

version 2.5.1
=============
1. Updated DepDrop widget to support rendering of \kartik\widgets\Select2 widget.

version 2.5.0
=============
1. New DepDrop widget based on [dependent-dropdown plugin](http://plugins.krajee.com/dependent-dropdown).
2. Upgrade Select2 Widget to v3.4.8 of the `select2` plugin.

version 2.4.0
=============
1. Star Rating Widget upgraded as a result of the base Krajee StarRating JQuery plugin upgrade.
2. Upgrade Select2 Widget to v3.4.6 of the `select2` plugin.

version 2.3.0
=============

1. Typeahead widget upgraded to use version 0.10 of the `typeahead.js` plugin.
2. The widget has been released as 2 variants:

- `TypeaheadBasic`: This widget is a basic implementation of the *typeahead.js* plugin without any suggestion engine. 
  It uses a javascript substring matcher and Regular Expression matching to query and display suggestions. 
  [```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead-basic)
  
- `Typeahead`: This widget is an advanced implementation of the *typeahead.js* plugin with the *BloodHound* suggestion
   engine and the *Handlebars* template compiler.
  [```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead)

version 2.2.0
=============

1. New category of widgets added - 'Notification'. Widgets now categorized as
   - Input Widgets
   - Progress Widgets
   - Navigation Widgets
   - Notification Widgets
2. Added `Alert` widget extending the default \yii\bootstrap\Alert widget with more styling and auto fade out options.
3. Added `Growl` widget wrapping the Bootstrap Growl JQuery plugin.
4. Added `AlertBlock` widget allowing a block of alerts to be displayed and faded out. Uses and processes session flash messages if needed.

version 2.1.0
=============

1. Widgets categorized as
   - Input Widgets
   - Progress Widgets
   - Navigation Widgets
2. Added DateTimePicker widget enhanced for Bootstrap 3.x based on the [Bootstrap DateTimePicker Plugin](http://www.malot.fr/bootstrap-datetimepicker/) by smalot.
3. Added Spinner widget based on spin.js - an animated CSS3 loading spinner with VML fallback for IE.
  
version 2.0.0
=============
[enh # 40] FileInput widget now wraps the enhanced [JQuery Bootstrap FileInput Plugin](http://github.com/kartik-v/bootstrap-fileinput). 

The fileinput routines and rendering have been enhanced and offers ability to configure most options, call events, and methods.

version 1.0.0
=============
Initial release