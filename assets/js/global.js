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
		empty_body.append('<tr><td colspan="'+ colspan +'" class="center-align"> NO RECORDS FOUND. </td></tr>');
	}
})