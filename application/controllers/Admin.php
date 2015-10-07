<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->data['s_page_header'] = 'admin';
		$this->data['s_page_type'] = 'admin';

		$this->data['a_js_scripts'] = array(
			base_url()  . 'assets/js/admin/base.js'
		);

		$this->data['a_css_sheets'] = array(
			base_url() . 'assets/css/admin/base.css'
		);
	}
    
	public function index()
	{
		$this->data['a_js_scripts'] = $this->data['a_js_scripts'] + array(
				base_url()  . 'assets/js/admin/index.js'
		);

		$this->data['a_css_sheets'] = $this->data['a_css_sheets']  + array(
				base_url() . 'assets/css/admin/index.css'
		);

		$this->data['page_title'] = 'Admin Home';
		$this->data['menu_id'] = 'menu_home';

		$this->data['s_main_content'] = 'admin/index';
		$this->load->view('includes/template', $this->data);
	}

	public function teacher_logs()
	{

		$this->data['a_js_scripts'] = array(
			base_url()  . 'assets/js/admin/base.js',
			base_url()  . 'assets/js/admin/teacher/records.js'
		);

		$this->load->model('teacher_model');

		$this->data['page_title'] = 'Teacher Logs';
		$this->data['menu_id'] = 'menu_teacher_logs';
		$this->data['a_teacher_logs'] = $this->teacher_model->retrieveAll();

		$this->data['s_main_content'] = 'admin/teacher_logs';
		$this->load->view('includes/template', $this->data);
	}

	public function student_logs()
	{

		$this->data['a_js_scripts'] = array(
			base_url()  . 'assets/js/admin/base.js',
			base_url()  . 'assets/js/admin/student/records.js'
		);

		$this->load->model('student_model');

		$this->data['page_title'] = 'Student Logs';
		$this->data['menu_id'] = 'menu_student_logs';
		$this->data['a_student_logs'] = $this->student_model->retrieveAll();

		$this->data['s_main_content'] = 'admin/student_logs';
		$this->load->view('includes/template', $this->data);
	}
    
}
