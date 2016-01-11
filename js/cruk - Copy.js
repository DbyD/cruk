$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
    options.async = true;
});
//----------------------------------------------------------------------------------
//$(function(){
$(function(){
     $("#searchColleague").validate();
	 $("#nominateColleague").validate({
            rules: {
               EmpNum: {
                  required: true
               }
            },
            messages: {
               EmpNum: {
                  required: "Please select a Colleague"
               }
            },
			errorPlacement: function(error, element) {
				if (element.is(":radio") ){
					$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
					$("#alertbox").addClass('smallAlert');
					$("#alert").css('display', 'block');
				}
				else if ( element.is(":checkbox") )
					alert(error.html());
					//error.appendTo( ("#alertbox") );
				else
					alert(error.html());
					//error.appendTo( ("#alertbox") );
			}
         });
		 
	 $("#uploadPhoto").validate({
            rules: {
               photo: {
                  required: true
               }
            },
            messages: {
               photo: {
                  required: "Please select a photo"
               }
            },
			errorPlacement: function(error, element) {
				alert(error.html());
			}/*,
			submitHandler: function(form) {
				alert($('#thisphoto').val());
  				event.preventDefault();
				$.post( "../inc/upload.php", function( data ) {
					alert( "Data Loaded: " + data );
					//$("#alertContent").load("../alerts/upload-photo.php");
				});
				
				//$("#alertContent").load("../alerts/upload-photo.php");
					//$("#alertbox").addClass('smallAlert');
				//	$("#alert").css('display', 'block');
				//$("#alertContent").submit();
				//$("#alertContent").load("../alerts/upload-photo.php"});
				//$("#alert").css('display', 'block');
			}*/
         });
});
	
	$('.clickAble').click(function() {
		var url = $(this).attr('data-url');
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		switch (type) { 
			case 'gourl': 
				window.location.href = url;
				break;
			case 'close': 
				$("#alertbox").removeClass('smallAlert');
				$("#alert").css('display', 'none');
				break;
			case 'popup': 
				$("#alertContent").load(url+"?id="+id);
				$("#alert").css('display', 'block');
				break;
			case 'alert': 
				$("#alertbox").addClass('smallAlert');
				$("#alertContent").load(url);
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
			case 'submit':
				if ($("#"+url).valid()) {
					$("#"+url).submit();
				}
				break;
			default:
				alert('Nothing to do!');
		}
	});
//----------------------------------------------------------------------------------
$('#searchAuto').autocomplete({source:'../inc/emp-list.php'});
//----------------------------------------------------------------------------------
$('.custom-upload input[type=file]').change(function(){
    $(this).next().find('input').val($(this).val());
});
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------