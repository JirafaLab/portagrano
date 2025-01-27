jQuery(document).ready(function()
{
	console.log("JS Gestor anuncios OK");
	jQuery(window).scroll(function() 
	{
		var scrollPos = jQuery(window).scrollTop();
		jQuery(".jky-oreja-ad").css({top: scrollPos + "px"});
	});
});