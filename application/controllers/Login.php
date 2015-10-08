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
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->data['a_js_scripts'] = array(
				base_url()  . 'assets/js/home/index.js'
			);

		$this->data['a_css_sheets'] = array(
				base_url() . 'assets/css/home/index.css'
			);
	}

	public function index()
	{

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run())
		{
			$a_user_data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);

			$user_data = $this->user_model->login($a_user_data);
			if(!$this->user_model->error_message && $user_data)
			{
				$this->session->set_userdata('user', $user_data[0]);
				if($user_data[0]['user_type'] == 1)
				{
					redirect(base_url().'student');
				}
				elseif($user_data[0]['user_type'] == 3)
				{
					redirect(base_url().'admin');
				}
				else
				{
					redirect(base_url());
				}
			}
			else
			{
				$this->data['error'] = $this->user_model->error_message;
			}
		}
		else
		{
			$this->data['error'] = validation_errors();
			print_r(validation_errors());
		}

	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

}
