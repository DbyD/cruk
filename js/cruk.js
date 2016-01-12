$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
    options.async = true;
});
//----------------------------------------------------------------------------------
//$(function(){
$(function(){
	$("#searchColleague").validate();
	$("#nominateColleague").validate({
		rules: {
			EmpNum: "required"
		},
		messages: {
			EmpNum: "Please select a Colleague"
		},
			errorPlacement: function(error, element) {
				$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
				$("#alert").css('display', 'block');
			}
	});
	$("#uploadPhoto").validate({
		rules: {
			photo: "required"
		},
		messages: {
			photo: "Please select a photo"
		},
			errorPlacement: function(error, element) {
				$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
				$("#alert").css('display', 'block');
			}
	});
	$("#nominateColleague2").validate({
		ignore: [],
		rules: {
			BeliefID: "required",
			personalMessage: "required"
		},
		messages: {
			BeliefID: "Please select a Belief",
			personalMessage: "Please add a Personal Message",
			nominateBoth: "Please select a Belief and add a Personal Message"
		},
			groups: {
				nominateBoth: "BeliefID personalMessage"
			},
			errorPlacement: function(error, element) {
				if (element.attr("name") == "BeliefID" || element.attr("name") == "personalMessage"){
					$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html()});
				} else {
					$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
				}
				$("#alert").css('display', 'block');
			}
	});
	$("#volunteerForm").validate({
		rules: {
			volunteer: "required"
		},
		messages: {
			volunteer: "Please add in the volunteer's full name."
		},
			errorPlacement: function(error, element) {
				$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
				$("#alert").css('display', 'block');
			}
	});
});
	
	$('.clickAble').click(function() {
		var url = $(this).attr('data-url');
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		switch (type) { 
			case 'goback': 
				history.back();
				break;
			case 'gourl': 
				window.location.href = url;
				break;
			case 'close':
				switch (id) {
					case '1':
						$("#popup1").css('display', 'none');
						$("#popupContent1").empty();
						break;
					case '2':
						$("#popup2").css('display', 'none');
						$("#popupContent2").empty();
						break;
					case '3':
						$("#alert").css('display', 'none');
						$("#alertContent").empty();
						break;
				}
				break;
			case 'popup': 
				$("#popupContent1").load(url+"?id="+id);
				$("#popup1").css('display', 'block');
				break;
			case 'alert': 
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
			case 'select':
				switch (id) {
					case 'beliefs':
						var divID = this.id;
						if (divID!=""){
							$('#beliefs div').removeClass('selectedecard');
							$(this).addClass('selectedecard');
							$('#BeliefID option').removeAttr("selected");
							$('#BeliefID option[value='+divID+']').prop('selected', 'selected');
						}
					break;
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
var maxLength = 200;
$('#personalMessage').keyup(function() {
	var length = $(this).val().length;
	var length = maxLength-length;
	$('#chars').text(length);
});
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
	$(document).foundation();
//----------------------------------------------------------------------------------
(function($){
	$(window).load(function(){
		$(".content").mCustomScrollbar();
	});
})(jQuery);
//----------------------------------------------------------------------------------