<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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

		$this->load->model('User_model');
		$this->load->model('Admin_model');


		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				$this->load->view('php/admin_page', $this->session->userdata['logged_in']);
				redirect('admin/admin_index');
			}else{
				$this->load->view('login');
			}
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->projectmodel->login($data);
			if ($result == TRUE) {
				$username = $this->input->post('username');
				$result = $this->projectmodel->info($username);
				if ($result != false) {
					$session_data = array(
					'username' => $result[0]->username,
					);
				// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
					$this->load->view('php/admin_page', $session_data);
					redirect('admin/admin_index');

				}
			} else {
				$data = array(
				'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('login', $data);
			}
		}	
	}
    
}
