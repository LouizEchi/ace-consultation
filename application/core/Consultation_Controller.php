<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultation_Controller extends CI_Controller {

	public $ignored_methods;

    function __construct()
	{
		parent::__construct();
		$b_can_login = false;
		$this->load->model('user_model');
		$this->load->helper('url');

		if($user = $this->session->userdata('user'))
		{
			if($this->user_model->retrieve(['id' => $user['id']]))
			{
				$b_can_login = true;
			}
		}

		if(!$b_can_login)
		{
			redirect('/', 'refresh');
		}
	}
}