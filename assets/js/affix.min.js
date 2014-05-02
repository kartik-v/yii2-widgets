/**
 * Scrollspy and affixed enhanced navigation for Twitter Bootstrap
 * Modified and built for Yii Framework 2.0
 *
 * Based on affix sidenav examples available in Twitter Bootstrap
 * documentation site at http://getbootstrap.com/
 *
 * Author: Kartik Visweswaran
 * Year: 2013
 * For more Yii related demos visit http://demos.krajee.com
 */!function(e){e(function(){var t=e(window),n=e(document.body),r=e(".kv-sidebar"),i=e(".navbar").outerHeight(true)+10;n.scrollspy({target:".kv-sidebar",offset:i});t.on("load",function(){n.scrollspy("refresh")});e(".kv-sidebar [href=#]").click(function(e){e.preventDefault()});setTimeout(function(){r.affix({offset:{top:function(){var t=r.offset().top;var n=parseInt(r.children(0).css("margin-top"),10);var i=e(".kv-header").height();return this.top=t-i-n},bottom:function(){return this.bottom=e(".kv-footer").outerHeight(true)}}})},100);r.width(r.parent().width());t.resize(function(){r.width(r.parent().width())})})}(window.jQuery)