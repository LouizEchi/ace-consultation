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

		);

		$this->data['a_css_sheets'] = array(

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

		$this->data['s_main_content'] = 'admin/index';
		$this->load->view('includes/template', $this->data);
	}

	public function teacher_logs()
	{
		$this->load->model('teacher_model');

		$this->data['a_teacher_logs'] = $this->teacher_model->retrieveAll();

		$this->data['s_main_content'] = 'admin/teacher_logs';
		$this->load->view('includes/template', $this->data);
	}
    
}
