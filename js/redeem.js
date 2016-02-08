$(document).ready(function(){
	$("#checkOutButton").click(function(e){
		e.preventDefault();
		var price = $.trim($('.price-panel').text());
		priceNumber = price.slice( 1,price.length );

		var total = $.trim( $("#table_basket tr").last().children().eq(2).text() );
		totalNumber = total.slice( 1,total.length );

        console.log("totalNumber = ", totalNumber);
        console.log("priceNumber = ", priceNumber);
        console.log(parseInt(totalNumber) > parseInt(priceNumber));

		if(parseInt(totalNumber) > parseInt(priceNumber)){
			$('#modalCheckButton').click();
		} else {
			window.location.replace($(this).attr('linkGo'));
		}
		
	});
	
	$("#closeCheckOut").click(function(){
		$(".close-reveal-modal").click();
	});

	$(".proceedButton").click(function(e){
		if(!$("input[name=read]").prop('checked')){
			e.preventDefault();
			alert("Please indicate if you have read the Terms & Conditions.");
		}
	});

});