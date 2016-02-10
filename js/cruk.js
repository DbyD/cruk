$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
    options.async = true;
});
//----------------------------------------------------------------------------------
jQuery.validator.addMethod("greaterThanTwo", function(value, element) {
    return this.optional(element) || (parseFloat(value) > 1);
}, "A team must consist of a minimum of 2 members.");
$(function(){
	$("#confirmTeam").validate({
		ignore: [],
		rules: {
			myTeamName: "required",
        	teamNO : { greaterThanTwo : true }
		},
		messages: {myTeamName: "Please add an appropriate team name. The team name will be visible on the Wall of Fame"},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('edit-team.php', $("#confirmTeam").serialize(), function(data) {
				if (data == 'created') {
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					location.reload();
				}
			});
		}
	});
	$("#deleteTeam").validate({
		submitHandler: function(form) { 
			$.post('edit-team.php', $("#deleteTeam").serialize(), function(data) {
				if (data == 'removed') {
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					location.reload();
				}
			});
		}
	});
	$("#searchColleague").validate({
		rules: {searchAuto: "required"},
		messages: {searchAuto: "Search Field cannot be empty. Please type in Colleague's First or Last name."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		}
	});
	$("#searchTeam").validate({
		rules: {searchTeamAuto: "required"},
		messages: {searchTeamAuto: "Search Field cannot be empty. Please type in a Team name or Colleague's First or Last name."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) {
			$("#popupContent1").load(
				'team-details.php',
				$('#searchTeam').serialize()
			);
		}
	});
	$("#searchAdminColleague").validate({
		rules: {searchAdmin: "required"},
		messages: {searchAdmin: "Search Field cannot be empty. Please type in Colleague's First or Last name."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		}
	});
	$("#editStaff").validate({
		rules: {EmpNum: "required"},
		messages: {EmpNum: "Please select a Staff Member"},
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
		rules: {myphoto: "required"},
		messages: {myphoto: "Please select a photo"},
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
		rules: {Volunteer: "required"},
		messages: {Volunteer: "Please add in the volunteer's full name."},
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
		rules: {Reason: "required"},
		messages: {Reason: "Please add in a reason for the little exra."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('little-extra-update.php', $("#LittleExtraForm").serialize(), function(data) {
				if (data != 'removed') {
					$('#littleExtraTick').addClass('circleTickChecked');
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					$("#littleExtra").val('Yes');
					$("#littleExtraMessage span").html(data);
					$("#littleExtraMessage div").removeClass('hidden');
				}
			});
		}
	});
	$("#teamLittleExtraForm").validate({
		rules: {Reason: "required"},
		messages: {Reason: "Please add in a reason for the little exra."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('team-little-extra-update.php', $("#teamLittleExtraForm").serialize(), function(data) {
				if (data != 'removed') {
					console.log(data);
					$('#littleExtraTick').addClass('circleTickChecked');
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					$("#littleExtra").val('Yes');
					$("#littleExtraMessage span").html(data);
					$("#littleExtraMessage div").removeClass('hidden');
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
			$.post('../approvals/individual-award-update.php', $("#approveAward").serialize(), function(data) {
				if (data = 'declined') {
					$("#popup1").css('display', 'none');
					$("#popupContent1").empty();
					location.reload();
				}
			});
		}
	});
	$("#approveTeamAward").validate({
		rules: {dReason: "required"},
		messages: {dReason: "Please add in a reason for the decline."},
		errorPlacement: function(error, element) {
			$("#alertContent").load("../alerts/alert-popup.php", {'error' : error.html() });
			$("#alert").css('display', 'block');
		},
		submitHandler: function(form) { 
			$.post('../approvals/team-award-update.php', $("#approveTeamAward").serialize(), function(data) {
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
	$('.clickAble').unbind().click(function(e) {
		var url = $(this).attr('data-url');
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');	
		var count = $(this).attr('data-count');
		switch (type) { 
			case 'donothing': 
				break; 
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
						$("#ecardPopup").css('display', 'none');
						$("#popupEcard").empty();
						break;
					case '3':
						$("#alert").css('display', 'none');
						$("#alertContent").empty();
						break;
					case '4':
						$("#subPopup").css('display', 'none');
						break;
				}
				break;
			case 'clear': 
				if(id=='v'){
					$.post('volunteer-update.php?clear=yes', $("#volunteerForm").serialize(), function(data) {
						if (data == 'removed') {
							$('#volunteerTick').removeClass('circleTickChecked');
							$("#volunteerName span").html('');
							$("#popup1").css('display', 'none');
							$("#popupContent1").empty();
							$("#volunteerName div").addClass('hidden');
						}
					});
				}
				if(id=='lexm'){
					$.post('little-extra-update.php?clear=yes', $("#LittleExtraForm").serialize(), function(data) {
						if (data == 'removed') {
							$('#littleExtraTick').removeClass('circleTickChecked');
							$("#littleExtraMessage span").html('');
							$("#littleExtra").val('No');
							$("#popup1").css('display', 'none');
							$("#popupContent1").empty();
							$("#littleExtraMessage div").addClass('hidden');
						}
					});
				}
				if(id=='tlexm'){
					$.post('team-little-extra-update.php?clear=yes', $("#teamLittleExtraForm").serialize(), function(data) {
						if (data == 'removed') {
							$('#littleExtraTick').removeClass('circleTickChecked');
							$("#littleExtraMessage span").html('');
							$("#littleExtra").val('No');
							$("#popup1").css('display', 'none');
							$("#popupContent1").empty();
							$("#littleExtraMessage div").addClass('hidden');
						}
					});
				}
				if(id=='20'){
					$("#includeMe").prop('checked', false);
					$("#optout").addClass('hide');
				}
				if(id=='te'){
					$("#includeMe").prop('checked', true);
					$("#optout").removeClass('hide');
				}
				break;
			case 'popup': 
				console.log(id)
				//if(id=='littleExtra') $('#littleExtra').prop('checked', false);
				if(count>3){
						$("#popupContent1").load(url+"?id="+id);
						$("#popup1").css('display', 'block');
				} else {
					$("#popupContent1").load(url+"?id="+id);
					$("#popup1").css('display', 'block');
				}
				break;
			case 'subPopup': 
				var top = $(this).position().top + 30
				var left = $(this).position().left - 7
				$("#subPopup").css('display', 'block');
				$("#subPopupbox").css('top', top);
				$(".whiteUpArrow").css('left', left);
				break;
			case 'ecard': 
				$("#popupEcard").load(url+"?id="+id);
				$("#ecardPopup").css('display', 'block');
				break;
			case 'alert': 
				$("#alertContent").load(url);
				$("#alert").css('display', 'block');
				break;
			case 'expandArrow': 
				$("#"+id+" .expandArrow i" ).attr( "data-type", "colapseArrow" );
				$("#"+id+" .expandArrow i" ).removeClass('icon-icons_pointright').addClass('icon-icons_pointdown');
				$("#"+id+" .claimedAwardsExpanded").css('display', 'block');
				break;
			case 'colapseArrow': 
				$("#"+id+" .expandArrow i" ).attr( "data-type", "expandArrow" );
				$("#"+id+" .expandArrow i" ).removeClass('icon-icons_pointdown').addClass('icon-icons_pointright');
				$("#"+id+" .claimedAwardsExpanded").css('display', 'none');
				break;
			case 'submitNoValidate':
				$("#dReason").val('');
				$("#"+url).validate().cancelSubmit = true
				$("#"+url).submit();
			//	location.reload();
				break;
			case 'submit':
				console.log(url)
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
							$("#BeliefID option[value='"+divID+"']").prop('selected', 'selected');
						}
					break;
				}
				break;
			case 'addTeam':
				console.log(id)
				var input = $("<input>")
				   .attr("type", "hidden")
				   .attr("name", "TeamMember").val(id);
				$("#addTeamMember").append($(input));
				$("#popupContent1").load('team-details.php',$('#addTeamMember').serialize());
				break;
			case 'removeTeamMember':
				console.log(id)
				url = url+"?removeMember="+id
				console.log(url)
				$("#popupContent1").load(url);
				break;
			case 'deleteTeam':
				console.log(id)
				url = url+"?deleteTeam="+id
				console.log(url)
			//	$("#popupContent1").load(url);
				break;
			case 'addFullTeam':
				console.log(id)
				var input = $("<input>")
				   .attr("type", "hidden")
				   .attr("name", "id").val(id);
				$("#addTeamMember").append($(input));
				$("#popupContent1").load('team-details.php',$('#addTeamMember').serialize());
				break;
			default:
				alert('Nothing to do!');
		}
	});
//----------------------------------------------------------------------------------
$('#searchAuto').autocomplete({source:'../inc/emp-list.php'});
//----------------------------------------------------------------------------------
$('#searchAdmin').autocomplete({source:'../inc/emp-admin-list.php'});
//----------------------------------------------------------------------------------
$('#searchTeamAuto').autocomplete({source:'../inc/emp-team-list.php'});
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
		$("[id='"+divID+"']").removeClass('hidden');
	},function(){
		var divID = this.id + "Text";
		$("[id='"+divID+"']").addClass('hidden');
	});
});
//----------------------------------------------------------------------------------
$(document).foundation();
//----------------------------------------------------------------------------------
(function($){
	$(window).load(function(){
		//$(".content").mCustomScrollbar();
	});
})(jQuery);
$("#scrollBar").mCustomScrollbar();
//----------------------------------------------------------------------------------
$(document).ready(function(){
	$(".sendMail").click(function(){
		var sender = $($(this).siblings()[0]).val();
		var recipient = $($(this).siblings()[1]).val();
		var senderName = $($(this).siblings()[2]).val();
		var recipientName = $($(this).siblings()[3]).val();
		var Department = $($(this).siblings()[4]).val();
		$('#modalForSendMail').click();
		$("#senderModal").val(sender);
		$("#recipientModal").val(recipient);
		$("#DepartmentModal").val(Department);
		$("#mailToEmployee").val('Hi '+recipientName+'. I saw your "Our Heroes" award on the Wall of Fame. Congratulations! '+ senderName);
		$("#messageModal").html('Hi '+recipientName+'. I saw your "Our Heroes" award on the Wall of Fame. Congratulations! '+ senderName);
		console.log(sender);
		console.log(recipient);
		console.log(senderName);
		console.log(recipientName);
		console.log(Department);
	});
	$("#sendButton").click(function(){
		var recipient = $("#recipientModal").val();
		var sender = $("#senderModal").val();
		var text = $("#mailToEmployee").val();
		var Department = $("#DepartmentModal").val();
		var siblings = $("#mailToEmployee").siblings();
		if( $.trim(text) != '' ){
			//siblings.addClass("hidden");
			$(".close-reveal-modal").click();
			$.ajax({
			  type:'post',
			  url: "message-submit.php?name=message",
			  data:  { 
			  	recipient : recipient,
			  	sender : sender,
			  	text : text,
			  	Department : Department
			  } ,
			  success: function(data){
			  		console.log(data);
			  }
			});
		} else {
			//siblings.removeClass("hidden");
		}
	});


	$("#price").click(function(e){
		var parentUL = $(this).children()[1];
		//$(this).find('p').html('Price <i class="icon-icons_thindownarrow right"></i>');
		$(parentUL).children().toggleClass('hide');
	});

	$('.price-list').click(function(e){
		var currentPrice = $(e.target).text();
		$("#price").find('p').html('Price ' + currentPrice + '<i class="icon-icons_thinrightarrow right"></i>');
		$("#aPrice").val(currentPrice.replace('£', ''));
	});

	$(".basket-item-remove").click(function(){
		var baID = $(this).siblings().val();
		var count = $(this).parent().siblings().find('.quantityPr').val();
		
		$("#baIDdel").val(baID);
		$("#countPr").val(count);

		$("#modalButton").click();
	});

	$("#close-basket-del").click(function(){
		$(".close-reveal-modal").click();
	});

	$(".del-item").click(function(el){
		var del_id = $(this).attr('data-del_id');
		
		$.ajax({
				type:"POST",
				url:"action.php",
				data:{del_id:del_id},
				success:function(d){
					
				}
			});
		el.value = "";

		$(this).closest( ".menu-item-holder" ).hide();
	});

	$(".quantityPr").bind("change paste keyup", function(){
		var table = $("#table_basket");
		var lists = table.find('tr');
		var quantityArr = [];
		var htmlInputs = '';


		for(var i = 1; i < ( lists.length - 1); i++){
			quantityArr[i-1] = {
								'quantity' : $(lists[i]).find('.quantityPr').val(),
								'busketIDS' : $(lists[i]).find('input[type=hidden]').val()
							};

			htmlInputs = htmlInputs + '<input type="hidden" name="busketIDS_' + i + '" value="' + $(lists[i]).find('input[type=hidden]').val() + '">' + '<input type="hidden" name="quantity_' + i + '" value="' + $(lists[i]).find('.quantityPr').val() + '">'; 				
		}

		

		$("#formUpdate").html(htmlInputs + '<input type="submit" class="hidden" name="submitUpdate" value="submit">');

	});


	$("#updateButton").click(function(){
		var button  = $("#formUpdate").find('input[type=submit]');
		button.click();
	});

});



	function _byId(el){

		return document.getElementById(el);
	}
	function _byClas(el){
		return document.getElementsByClassName(el)
	}

	//_byId("adding_new").onchange = 
	function AddHeadMenu(el, folder, parent){
		var newItem = el.value;

		console.log(newItem ,  folder, parent);

		$.ajax({
				type:"POST",
				url:"action.php",
				data:{newItem:newItem,folder:folder,parent:parent },
				success:function(d){
					console.log(d);
					_byId("menu_container").innerHTML = d;
				}
			});
		el.value = "";
	}


	function updateLabel(el, id)
	{
		

		var upLabel = el.value;

		$.ajax({
				type:"POST",
				url:"action.php",
				data:{
					upLabel:upLabel,
					id:id 
				},
				success:function(d){
					
				}
			});
	}

	function openSubmenu(el)
	{
		var menuItems = _byClas("menu-item-holder");

		for(var m = 0; m<menuItems.length ; m++){
			menuItems[m].setAttribute('class', 'menu-item-holder'); 
		}

		var s = _byId("holder_of_"+el.id);
		var curClass = s.getAttribute("className");

		if(curClass == "menu-item-holder activated" ){
			_byId("holder_of_"+el.id).setAttribute('class', 'menu-item-holder'); 
		}else{
			_byId("holder_of_"+el.id).setAttribute('class', 'menu-item-holder activated'); 	
		}
		
		
	}

//----------------------------------------------------------------------------------
$(function() {
	$('#winnerswall div.clickAble').hover(function(){
		var divID = this.id + "Text";
		$("[id='"+divID+"']").removeClass('hidden');
	},function(){
		var divID = this.id + "Text";
		$("[id='"+divID+"']").addClass('hidden');
	});
});
//----------------------------------------------------------------------------------