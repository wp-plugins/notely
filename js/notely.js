
jQuery(function($) {
	$(".notely-icon").click(function(){
		$(this).next(".notely-preserve").slideToggle(150);
		$(this).toggleClass("notely-open");
	});
});
