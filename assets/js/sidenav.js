/**
 * Side navigation menu bar scripting
 *
 * Copyright 2013 Kartik Visweswaran <kartikv2@gmail.com>
 * Krajee.com
 *
 */
$(document).ready(function() {
    $('.kv-toggle').click(function(event) {
        event.preventDefault(); // cancel the event
		$(this).children('.opened').toggle()
		$(this).children('.closed').toggle()
		$(this).parent().children('ul').toggle()
		$(this).parent().toggleClass('active')
		return false;
    });
});
