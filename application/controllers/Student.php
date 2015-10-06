<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

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
		$this->data['s_page_header'] = 'student';
		$this->data['s_page_type'] = 'student';

		$this->data['a_js_scripts'] = array(
				base_url()  . 'assets/js/student/index.js'
			);

		$this->data['a_css_sheets'] = array(
				base_url() . 'assets/css/student/index.css'
			);
	}
    
	public function index()
	{
		$a_teachers_list = array();
		foreach($this->teacher_model->retrieveAll() as $key => $o_teacher_names) {
			$a_teachers_list[$o_teacher_names->id] = $o_teacher_names->first_name . ' ' . $o_teacher_names->last_name;
		}
		$this->data['a_teachers_list'] = $a_teachers_list;
		$this->data['s_main_content'] = 'student/index';
		$this->load->view('includes/template', $this->data);
	}
    
}
