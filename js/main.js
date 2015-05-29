jQuery(document).ready(function($){

	<!-- submit form -->

	var form = $('#ajax-contact');
	var formMessages = $('#form-messages');

	$(form).submit(function(e){
		event.preventDefault();
		var formData = $(form).serialize();
		
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})		
		.done(function(response) {
			$(formMessages).removeClass('error');
			$(formMessages).addClass('success');
			
			$(formMessages).text(response);
			
			//clear the form
		})
		.fail(function(data){
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');
			
			if (data.responseText !==''){
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});


	<!-- floating labels -->

	if( $('.floating-labels').length > 0 ) floatLabels();

	function floatLabels() {
		var inputFields = $('.floating-labels .cd-label').next();
		inputFields.each(function(){
			var singleInput = $(this);
			//check if user is filling one of the form fields 
			checkVal(singleInput);
			singleInput.on('change keyup', function(){
				checkVal(singleInput);	
			});
		});
	}

	function checkVal(inputField) {
		( inputField.val() == '' ) ? inputField.prev('.cd-label').removeClass('float') : inputField.prev('.cd-label').addClass('float');
	}
});