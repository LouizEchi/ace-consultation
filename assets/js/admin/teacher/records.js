$(function(){
	$('#add_new_teacher').click(function(e){
		$('.error').addClass('hide');
		e.preventDefault();
		$.ajax({
	  			url:  $('#frm_add_teacher').data('post-url'),
	  			type: 'POST',
	  			data: $('#frm_add_teacher').serialize(),
	  			success: function(o_response, s_message, o_xhr) {
	    			if(typeof(o_response.success) != 'undefined')
	    			{
	    				load_table($('#tbl_teachers'));
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

	$('#add_teacher').click(function(){
		$('#frm_add_teacher').removeClass('hide');
		$('#frm_edit_teacher').addClass('hide');
	});

})