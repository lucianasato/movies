$( document ).ready(function() {
	
	$("#btn_newsletter").click(function(){
		var email = $("#email").val() ;
		var url = $(".form_newsletter").attr('action') ;
		$.ajax({
			type: "post",
			url: url ,
			data:{ 
				email: email, 
				action: 'newsletter' 
			}
			, success:function( data ) {
				if ( data.error && data.error == 'email' ) {
					$("#email").css( "border" , "1px solid red" ) ;
				}

				if ( data.success ) {
					$("#email").css( "border" , "1px solid black" ) ;
					$("#msg_newsletter").html( data.success ) ;
					$("#email").val("") ;
				}
			}
		});
		return false;
	});
} ) ;