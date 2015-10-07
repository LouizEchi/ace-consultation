$(function(){
	$('#add_new_student').click(function(e){
		$('.error').addClass('hide');
		e.preventDefault();
		$.ajax({
	  			url:  $('#frm_add_student').data('post-url'),
	  			type: 'POST',
	  			data: $('#frm_add_student').serialize(),
	  			success: function(o_response, s_message, o_xhr) {
	    			if(typeof(o_response.success) != 'undefined')
	    			{
	    				load_table($('#tbl_students'));
	    			}
	    			else
	    			{
	    				$('.error').removeClass('hide');
	    				$('.error').html(o_response.error);
	    			}
	  			},
	  			error: function(o_response)
	  			{
	  			}
		});
	});

	$('#add_student').click(function(){
		$('#frm_add_student').removeClass('hide');
	});

})