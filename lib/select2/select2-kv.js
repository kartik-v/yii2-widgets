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
 */
(function ($) {
    initSelect2Loading = function (id) {
        var $el = $('#' + id), groupCss = 'group-' + id, $group = $('.kv-hide.' + groupCss), 
            $container = $el.select2('container'), 
            $loading = $('.kv-plugin-loading.loading-' + id);
        $el.removeClass('kv-hide');
        $container.removeClass('kv-hide');
        $loading.remove();
        if (Object.keys($group).length > 0) {
            $group.removeClass('kv-hide').removeClass(groupCss);
        }
    };

    initSelect2DropStyle = function (id) {
        var $el = $('#' + id), $drop = $("#select2-drop"), cssClasses, i;
        $drop.removeClass("has-success has-error has-warning");
        if ($el.parents("[class*='has-']").length) {
            cssClasses = $el.parents("[class*='has-']")[0].className.split(/\s+/);
            for (i = 0; i < cssClasses.length; i++) {
                if (cssClasses[i].match("has-")) {
                    $drop.addClass(cssClasses[i]);
                }
            }
        }
    }
})(jQuery);