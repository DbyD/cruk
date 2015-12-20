
//----------------------------------------------------------------------------------
//$(function(){
	$('.clickAble').click(function() {
		var url = $(this).attr('data-url');
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		switch (type) { 
			case 'gourl': 
				window.location.href = url;
				break;
			case 'close': 
				$("#alert").css('display', 'none');
				break;
			case 'alert': 
				$("#alertContent").load(url+"?id="+id);
				$("#alert").css('display', 'block');
				break;
			case 'expand': 
				$("#"+id+" .expandArrow i" ).attr( "data-type", "colapse" );
				$("#"+id+" .expandArrow i" ).removeClass('icon-icons_pointright').addClass('icon-icons_pointdown');
				$("#"+id+" .claimedAwardsExpanded").css('display', 'block');
				break;
			case 'colapse': 
				$("#"+id+" .expandArrow i" ).attr( "data-type", "expand" );
				$("#"+id+" .expandArrow i" ).removeClass('icon-icons_pointdown').addClass('icon-icons_pointright');
				$("#"+id+" .claimedAwardsExpanded").css('display', 'none');
				break;
			default:
				alert('Nothing to do!');
		}
 //   });
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
});
//----------------------------------------------------------------------------------