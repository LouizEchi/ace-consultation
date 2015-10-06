<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->data['s_page_header'] = 'home';
		$this->data['s_page_type'] = 'home';

		$this->data['a_js_scripts'] = array(
				base_url()  . 'assets/js/home/index.js'
			);

		$this->data['a_css_sheets'] = array(
				base_url() . 'assets/css/home/index.css'
			);
	}
    
	public function index()
	{
		$this->data['s_main_content'] = 'home/index';
		$this->load->view('includes/template', $this->data);
	}
    
}
