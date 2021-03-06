$(function(){
	var page_title = $('[name="page_title"]').val();
	var menu_id = $('[name="menu_id"]').val();

	 $('.btn-form-side').sideNav({
	      menuWidth: 500, // Default is 240
	      edge: 'left', // Choose the horizontal origin
	      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
	    }
	  );

	if(page_title != '') {
		$('title').append(page_title);
	}

	if(menu_id != '' && (typeof($('#' + menu_id)) != 'undefined')) {
		$('#' + menu_id).addClass('active');
	}

	if($('tbody').children().length == 0)
	{
		var empty_body = $('tbody');
		var colspan = empty_body.parent().find('thead tr').children().length;
		empty_body.append('<tr class="empty-item"><td colspan="'+ colspan +'" class="center-align"> NO RECORDS FOUND. </td></tr>');
	}

	if(typeof $('table').attr('xurl') != 'undefined')
	{
		$('table').each(function(){
			load_table($(this));
		})
	}

})

function load_table(table) {
	var _this = table;
	if(_this.attr('xurl') != 'undefined')
	{
		table.find('.empty-item').remove();
		_this.find('.item').remove();
		$.ajax({
  			url: _this.attr('xurl'),
  			type: 'GET',
  			success: function(o_response, s_message, o_xhr) {
    			if(typeof(o_response.success) != 'undefined') {
    				if(o_response.data.length > 0)
    				{
	    				for(var i in o_response.data)
	    				{
	        				var clone = _this.find('.cloned_item').clone();
	        				var current_data = o_response.data[i];
	        				clone.removeClass('cloned_item');
	        				clone.removeClass('hide');
	        				clone.addClass('item');
	        				clone.find('[data-column]').each(function(){
	        					var element = $(this);
	        					var element_idx = element.attr('data-column');
	        					for(var j in current_data)
	        					{
	        						if(j == element_idx)
	        						{
	        							element.text(current_data[j]);
	        						}
	        					}
	        				});

	        				clone.find('[data-delete-url]').each(function(){
	        					delete_url = $(this).attr('data-delete-url').split('/id_placeholder').join('/' + o_response.data[i]['id']);
	        					$(this).attr('href', delete_url);
								$(this).attr('data-id', o_response.data[i]['id']);
								$(this).click(function(e){
									e.preventDefault();
									confirm_delete($(this), table);
								});
							});

	         				clone.find('[data-edit-url]').each(function(){
	         					var edit_button = $(this);
	        					edit_url = edit_button.attr('data-edit-url').split('/id_placeholder').join('/' + o_response.data[i]['id']);
	        					edit_button.attr('href', edit_url);
	        					edit_button.attr('data-id', o_response.data[i]['id']);
								edit_button.sideNav({
							      menuWidth: 500, // Default is 240
							      edge: 'left', // Choose the horizontal origin
							      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
							    });
	        					edit_button.click(function(e){
	        						e.preventDefault();
									$('[data-put-url]').each(function(e){
										var edit_form = $(this);
										var id = edit_button.data('id');
										var a_url = [];
										a_url['get'] = edit_form.data('get-url').split('/id_placeholder').join('/' + id);
										a_url['put'] = edit_form.data('temp-put-url').split('/id_placeholder').join('/' + id);
										edit_form.removeClass('hide');
										initialize_edit_form(a_url, edit_form, _this);	
									});
									$('[data-post-url]').addClass('hide');

	        					});
	        				});
	        				_this.find('tbody').append(clone);
	        			}
	        		}
	        		else
	        		{
						
	        		}
    			} else {
 					if(typeof(o_response.error) != 'undefined' && typeof(o_response.error.message) != 'undefined') {
 						if(o_response.error.code == '9003') {
 							var colspan = table.find('thead tr').children().length;
							table.find('tbody').append('<tr class="empty-item"><td colspan="'+ colspan +'" class="center-align">'+  o_response.error.message + '</td></tr>');
						}
 					}	
    			}
  			},
  			error: function(o_response)
  			{
  			}
		});
	}
}

function confirm_delete(btn, table)
{
	container = $('.confirm.confirm-container');
	container.removeClass('hide');
	container.empty();
	container.append('<p>Are you sure you want to delete this record?</p>' +
						'<a class="btn transparent-border" id="btn_accept_delete">YES</a>' +
						'<a class="btn transparent-border" id="btn_reject_delete">NO</a>'

					);
	$('#btn_accept_delete').click(function(){
		delete_item(btn, table);
		container.addClass('hide');
	})

	$('#btn_reject_delete').click(function(){
		container.addClass('hide');
	})
}

function delete_item(btn, table)
{
	$.ajax({
  			url:  btn.attr('href'),
  			type: 'POST',
  			data: {id: btn.data('id')},
  			success: function(o_response, s_message, o_xhr) {
    			if(typeof(o_response.success) != 'undefined')
    			{
    				load_table(table);
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
}

function initialize_edit_form(a_url, edit_form, table)
{
	$.ajax({
  			url:  a_url['get'],
  			type: 'GET',
  			success: function(o_response, s_message, o_xhr) {
    			if(typeof(o_response.success) != 'undefined')
    			{
    				if(!$.isEmptyObject(o_response.data)) {
    					edit_form_id = edit_form.attr('id');
    					edit_form.attr('data-put-url', edit_form.data('temp-put-url').split('/id_placeholder').join('/' + o_response.data['id']));
    					for(var i in o_response.data) {
    						var edit_data = o_response.data[i];
    						if(typeof(edit_form.find('[name="'+i+'"]')) != 'undefined')
    						{
    							input_element = edit_form.find('[name="'+i+'"]');
    							input_element.val(edit_data);
    							input_element.siblings('label').addClass('active');
    						}
    					}
    					$('[data-put="'+edit_form_id+'"]').unbind('click');
    					$('[data-put="'+edit_form_id+'"]').click(function(e){
							$('.error').addClass('hide');
							e.preventDefault();
							$.ajax({
						  			url:  a_url['put'],
						  			type: 'POST',
						  			data: edit_form.serialize(),
						  			success: function(o_response, s_message, o_xhr) {
						    			if(typeof(o_response.success) != 'undefined')
						    			{
						    				load_table($(table));
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
    				}
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
}