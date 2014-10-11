/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @version 3.0.0
 *
 * Additional enhancements for Select2 widget extension for Yii 2.0.
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2014, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */(function($){initSelect2Loading=function(e){var s=$("#"+e),a="group-"+e,l=$(".kv-hide."+a),r=s.select2("container"),n=$(".kv-plugin-loading.loading-"+e);s.removeClass("kv-hide"),r.removeClass("kv-hide"),n.remove(),Object.keys(l).length>0&&l.removeClass("kv-hide").removeClass(a)};initSelect2DropStyle=function(e){var s,a,l=$("#"+e),r=$("#select2-drop");if(r.removeClass("has-success has-error has-warning"),l.parents("[class*='has-']").length)for(s=l.parents("[class*='has-']")[0].className.split(/\s+/),a=0;a<s.length;a++)s[a].match("has-")&&r.addClass(s[a])};})(jQuery);