$(document).ready(function() {
	$(window).scroll(function() {
  	if($(document).scrollTop() > 250) {
    	$('#nav').addClass('shrink');
    }
    else {
    $('#nav').removeClass('shrink');
    }
  });
});