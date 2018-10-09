Change Log: yii2-widgets
========================

## Version 3.4.1

**Date**: 09-Oct-2018

- Update composer dependencies
- Move all source code to `src` directory.
- Add github contribution and issue/PR log templates.
- Added ActiveField component

## Version 3.4.0

**Date:** 09-Nov-2014

- enh #199: Revamp yii2-widgets extension bundle to refer to individual sub repositories.
- Set release to stable.

## Version 3.3.0

**Date:** 05-Nov-2014

- enh #198: Enhance dependency validation using common code base.
- enh #195: Enable Typeahead option to conditionally load HandleBars.
- enh #193: Upgraded select2 plugin to latest version.
- enh #166: Reverted back Select2 placeholder CSS for bootstrap v3.3.0.

## Version 3.2.0

**Date:** 25-Oct-2014

- enh #186: Better replacement of tags for field template.
- enh #185: Update typeahead plugin to the latest release v0.10.5.
- enh #184: Update select2 plugin to the latest release v3.5.1.
- bug #183: Fix typeahead remote loading spinning indicator.
- enh #181: Enhance RangeInput to include new vertical orientation

## Version 3.1.0

**Date:** 10-Oct-2014

- enh #177: Add Italian translations.
- enh #173: Fix styling for FileInput additional line feed.
- bug #172: More correct InputWidget name field parsing.
- enh #169: Enhancement for ICU format con## Version for DatePicker and DateTimePicker (enrica, kartik-v).

## Version 3.0.0

**Date:** 08-Oct-2014

- enh #165, #166, #168: Various Select2 styling enhancements for Bootstrap.
- enh #162: Add Russian locale and translation for DatePicker plugin.
- PSR4 alias change
- Updated Select2 plugin ## Version to latest version.

## Version 2.9.0

**Date:** 14-Aug-2014

- bug # 157: Correct duplicate `label` displayed after SwitchInput.
- enh # 153: Various enhancements to `ColorInput` widget to read colors correctly based on plugin `preferredFormat`.
- bug # 151: Remove duplicate encoding for placeholder.
- enh # 150: Enhance `ColorInput` widget to allow controlling display of default palette of colors.
- Separate animation enhancements added to growl.
- bug #132: Enhance growl widget for major changes to core plugin.


## Version 2.8.0

**Date:** 31-Jul-2014

- enh #122: Upgrade bootstrap growl to latest plugin ## Version with various related enhancements
- enh #121, #119: Various styling enhancements to Select2.
- enh #71: Created separate [yii2-editable](https://github.com/kartik-v/yii2-editable) extension

## Version 2.7.0

**Date:** 18-Jul-2014

- Added `iconPrefix` property in SideNav to easily configure with more icon frameworks (other than glyphicon).
- enh #111: Allow configuring of template for each item in SideNav.
- bug #110: Allow use of Select2 with tags, when tags are empty.
- enh #106: Added Turkish translations for FileInput widget.
- enh #104: Add more information to documentation for Select2 widget and explain placeholder setting when `allowClear` is `true`. 
- bug #99: Fix DateControl to work for date time formatting with DateTimePicker. 
- enh #98: Added `language` configuration property for  DatePicker, DateTimePicker, and TimePicker.
- enh #96: Enhanced DatePicker, DateTimePicker, and TimePicker to work along with the new `autoWidgetSettings` for DateControl module .

## Version 2.6.0

**Date:** 01-Jul-2014

- Issue Fixes from #73 to #95.
- Added `language` property to `InputWidget` along with `initLanguage` method for automatic language setting in `pluginOptions`.
   The `language` property will be auto defaulted to `Yii::$app->language` if not set.

## Version 2.5.1

- Updated DepDrop widget to support rendering of \kartik\widgets\Select2 widget.

## Version 2.5.0

- New DepDrop widget based on [dependent-dropdown plugin](http://plugins.krajee.com/dependent-dropdown).
- Upgrade Select2 Widget to v3.4.8 of the `select2` plugin.

## Version 2.4.0

- Star Rating Widget upgraded as a result of the base Krajee StarRating JQuery plugin upgrade.
- Upgrade Select2 Widget to v3.4.6 of the `select2` plugin.

## Version 2.3.0

- Typeahead widget upgraded to use ## Version 0.10 of the `typeahead.js` plugin.
- The widget has been released as 2 variants:

- `TypeaheadBasic`: This widget is a basic implementation of the *typeahead.js* plugin without any suggestion engine. 
  It uses a javascript substring matcher and Regular Expression matching to query and display suggestions. 
  [```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead-basic)
  
- `Typeahead`: This widget is an advanced implementation of the *typeahead.js* plugin with the *BloodHound* suggestion
   engine and the *Handlebars* template compiler.
  [```VIEW DEMO```](http://demos.krajee.com/widget-details/typeahead)

## Version 2.2.0


- New category of widgets added - 'Notification'. Widgets now categorized as
   - Input Widgets
   - Progress Widgets
   - Navigation Widgets
   - Notification Widgets
- Added `Alert` widget extending the default \yii\bootstrap\Alert widget with more styling and auto fade out options.
- Added `Growl` widget wrapping the Bootstrap Growl JQuery plugin.
- Added `AlertBlock` widget allowing a block of alerts to be displayed and faded out. Uses and processes session flash messages if needed.

## Version 2.1.0

- Widgets categorized as
   - Input Widgets
   - Progress Widgets
   - Navigation Widgets
- Added DateTimePicker widget enhanced for Bootstrap 3.x based on the [Bootstrap DateTimePicker Plugin](http://www.malot.fr/bootstrap-datetimepicker/) by smalot.
- Added Spinner widget based on spin.js - an animated CSS3 loading spinner with VML fallback for IE.
  
## Version 2.0.0

- enh #40: FileInput widget now wraps the enhanced [JQuery Bootstrap FileInput Plugin](http://github.com/kartik-v/bootstrap-fileinput). 

The fileinput routines and rendering have been enhanced and offers ability to configure most options, call events, and methods.

## Version 1.0.0

Initial release