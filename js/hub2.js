$(document).ready(function(){

	$('.clickable').click(function() {
		var url = $(this).attr('href');

		if (typeof url !== typeof undefined && url !== false) 
		{
   	 		window.location.href = url;
		}
	});
});