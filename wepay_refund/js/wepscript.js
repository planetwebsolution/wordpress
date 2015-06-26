 $(function() {
    $( "#start_from" ).datepicker({
      
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#start_to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#start_to" ).datepicker({
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#start_from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });



$(document).ready(function() {
    $('input[type=radio][class=refundtype]').change(function() {
        if (this.value == 'full') {
          //  alert("Allot Thai Gayo Bhai");

		$(this).parents('.refundsction').find('.showdiv_data').css( "display", "none" );
        }
        else if (this.value == 'partial') {
        // alert("Transfer Thai Gayo");

		$(this).parents('.refundsction').find('.showdiv_data').css( "display", "block" );
        }
    });
});



$(document).ready(function() {
	$( ".refund_btn" ).click(function() {
	 // alert( "Handler for .click() called." );
		
		var typeradio = $('input[type=radio][class=refundtype]:checked').val();

		var total_refund_amt =Number($(this).parents('.refundsction').find('.ref_amt').val());
		var user_refund_amt =Number($(this).parents('.refundsction').find('.refund_amt').val());

		//alert(typeradio+"<br>"+total_refund_amt+"<br>"+user_refund_amt);
		
		
		if(typeradio=="partial"){

			
			if(user_refund_amt==''){
				alert("Please enter Refund amonunt");
				return false;
			}	
			if(total_refund_amt<user_refund_amt){
				alert("You may not refund more than the non-refunded balance of the payment");
				return false;
			}
		}

		var refund_desc = $(this).parents('.refundsction').find('.refund_desc').val();
		if(refund_desc==""){
	
				alert("Please enter Refund Reason");
				return false;

			}
		
	});
});

