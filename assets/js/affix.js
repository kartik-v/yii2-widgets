/*!
 * Copyright 2013 Kartik Visweswaran
 *
 * Sourced from Twitter Bootstrap Documentation Examples
 * http://getbootstrap.com/
 */
!function ($) {
  $(function(){
    var $window = $(window)
    var $body   = $(document.body)
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
					var offsetTop      = $sideBar.offset().top
					var sideBarMargin  = parseInt($sideBar.children(0).css('margin-top'), 10)
					var navOuterHeight = $('.kv-nav').height()

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
