<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('teacher_model');
		$this->data['s_page_header'] = 'teacher';
		$this->data['s_page_type'] = 'teacher';

		$this->data['a_js_scripts'] = array(
				base_url()  . 'assets/js/student/index.js'
			);

		$this->data['a_css_sheets'] = array(
				base_url() . 'assets/css/student/index.css'
			);
	}
    
}
