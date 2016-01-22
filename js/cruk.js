$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
    options.async = true;
});
//----------------------------------------------------------------------------------
$(function(){
	$("#searchColleague").validate({
		rules: {searchAuto: "required"},
		messages: {searchAuto: "Search Field cannot be empty. Please type in Colleague's First or Last name."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		}
	});
	$("#nominateColleague").validate({
		rules: {EmpNum: "required"},
		messages: {EmpNum: "Please select a Colleague"},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('edit-nominee.php', $("#nominateColleague").serialize(), function(data) {
				window.location.href = 'nominate-colleague.php';
			});
		}
	});
	$("#uploadPhoto").validate({
		rules: {photo: "required"},
		messages: {photo: "Please select a photo"},
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
		},
		submitHandler: function(form) { 
			$.post('edit-nominee.php', $("#nominateColleague2").serialize(), function(data) {
				window.location.href = 'nominate-submit.php';
			});
		}
	});
	$("#volunteerForm").validate({
		rules: {volunteer: "required"},
		messages: {volunteer: "Please add in the volunteer's full name."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('volunteer-update.php', $("#volunteerForm").serialize(), function(data) {
				if (data != 'removed') {
					$('#volunteerTick').addClass('circleTickChecked');
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					$("#volunteerName span").html(data);
					$("#volunteerName div").removeClass('hidden');
				}
			});
		}
	});
	$("#LittleExtraForm").validate({
		rules: {reason: "required"},
		messages: {reason: "Please add in a reason for the little exra."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('little-extra-update.php', $("#LittleExtraForm").serialize(), function(data) {
				if (data = 'added') {
					$('#littleExtra').prop('checked', true);
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
				}
			});
		}
	});
	$("#approveAward").validate({
		rules: {dReason: "required"},
		messages: {dReason: "Please add in a reason for the decline."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('individual-award-update.php', $("#approveAward").serialize(), function(data) {
				if (data = 'declined') {
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					location.reload();
				}
			});
		}
	});
	$("#claimAward").validate({
		rules: {award: "required"},
		messages: {award: "Please select one award or click the close x to cancel."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('claim-award-update.php', $("#claimAward").serialize(), function(data) {
				if (data = 'updated') {
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					location.reload();
				}
			});
		}
	});
});
//----------------------------------------------------------------------------------
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
			case 'cancelPopup': 
				$("#popup1").css('display', 'none');
				$("#popupContent1").empty();
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
			case 'clear': 
				$.post('volunteer-update.php?clear=yes', $("#volunteerForm").serialize(), function(data) {
					if (data == 'removed') {
						$('#volunteerTick').removeClass('circleTickChecked');
						$("#popup1").css('display', 'none');
						$("#popupContent1").empty();
						$("#volunteerName div").addClass('hidden');
					}
				});
				break;
			case 'popup': 
				if(id=='littleExtra') $('#littleExtra').prop('checked', false);
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
			case 'submitNoValidate':
				$("#dReason").val('');
				$("#"+url).validate().cancelSubmit = true
				$("#"+url).submit();
				location.reload();
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
$('#personalMessage').keypress(function(e) {
	var tval = $('#personalMessage').val(),
	tlength = tval.length,
	set = 250,
	remain = parseInt(set - tlength);
	$('#chars').text(remain);
	if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
		$('#personalMessage').val((tval).substring(0, tlength - 1))
	}
});
//----------------------------------------------------------------------------------
$(function() {
	$('#beliefs div.clickAble').hover(function(){
		var divID = this.id + "Text";
		$("#"+divID).removeClass('hidden');
	},function(){
		var divID = this.id + "Text";
		$("#"+divID).addClass('hidden');
	});
});
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