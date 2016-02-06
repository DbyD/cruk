$(document).ready(function(){
	$("#checkOutButton").click(function(e){
		e.preventDefault();
		var price = $.trim($('.price-panel').text());
		priceNumber = price.slice( 1,price.length );
		

		var total = $.trim( $("#table_basket tr").last().children().eq(2).text() );
		totalNumber = total.slice( 7,total.length );

		if(totalNumber > priceNumber){
			$('#modalCheckButton').click();
		}
		
	});

	$("#closeCheckOut").click(function(e){
		e.preventDefault();
		$(this).next().click();
	});

});