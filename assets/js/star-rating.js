/*!
 * @copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 * 
 * A simple plugin to generate rating stars for jQuery and Bootstrap.
 * 
 * Built for Yii Framework 2.0. But could be used for various frameworks & scenarios.
 * For more Yii related demos visit http://demos.krajee.com
 */
(function($) {
    // Rating public class definition
    var Rating = function(element, options) {
        this.$element = $(element);
        this.$star = this.$element.children("s");
        this.$stars = this.$element.find("s");
        this.$reset = this.$element.find(".reset");
        this.$caption = this.$element.find(".caption");
        this.$input = $(options.input);
        this.starTitles = options.starTitles;
        this.starTitleClasses = options.starTitleClasses;
        this.resetTitle = options.resetTitle;
        this.resetTitleClass = options.resetTitleClass;
        this.resetValue = options.resetValue;
        this._init();
    };
    Rating.prototype = {
        constructor: Rating,
        _init: function() {
            var self = this;
            self.$star.on("click", function(e) {
                var numStars = $(e.target).parentsUntil("div").length + 1;
                var title = self.starTitles[numStars];
                var titleClass = self.starTitleClasses[numStars];
                title = '<span class="' + titleClass + '">' + title + '</span>';
                self.$input.val(numStars);
                self.$caption.html(title);
                self.$stars.removeClass('rated');
                $(e.target).removeClass('rated').addClass('rated');
                $(e.target).parentsUntil("div", "s").removeClass('rated').addClass('rated');
                self.$element.trigger({
                    'type': 'rating.change',
                    'value': numStars,
                    'title': title
                });
            });
            self.$reset.on("click", function(e) {
                var title = '<span class="' + self.resetTitleClass + '">' + self.resetTitle + '</span>';
                self.$stars.removeClass('rated');
                self.$caption.html(title);
                self.$input.val(self.resetValue);
                self.$element.trigger('rating.reset');
            });
        }
    };
    //Rating plugin definition
    $.fn.rating = function(options) {
        return this.each(function() {
            var $this = $(this), data = $this.data('rating')
            if (!data) {
                $this.data('rating', (data = new Rating(this, options)))
            }
            if (typeof options == 'string') {
                data[options]()
            }
        })
    };
}(jQuery));