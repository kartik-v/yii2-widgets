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
 */
!function ($) {
    $(function () {
        var $window = $(window)
        var $body = $(document.body)
        var navHeight = $('.navbar').outerHeight(true) + 10

        $body.scrollspy({
            target: '.kv-sidebar',
            offset: navHeight
        })

        $window.on('load', function () {
            $body.scrollspy('refresh')
        })

        $('.kv-sidebar [href=#]').click(function (e) {
            e.preventDefault()
        })

        // back to top
        setTimeout(function () {
            var $sideBar = $('.kv-sidebar')

            $sideBar.affix({
                offset: {
                    top: function () {
                        var offsetTop = $sideBar.offset().top
                        var sideBarMargin = parseInt($sideBar.children(0).css('margin-top'), 10)
                        var navOuterHeight = $('.kv-header').height()

                        return (this.top = offsetTop - navOuterHeight - sideBarMargin)
                    },
                    bottom: function () {
                        return (this.bottom = $('.kv-footer').outerHeight(true))
                    }
                }
            })
        }, 100)
    })
}(window.jQuery)
