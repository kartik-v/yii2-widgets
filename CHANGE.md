version 2.6.0
=============
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