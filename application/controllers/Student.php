<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends Consultation_Controller {

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
		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->load->model('teacher_model');
		$this->load->model('student_model');
		$this->load->model('user_model');
		$this->data['s_page_header'] = 'student';
		$this->data['s_page_type'] = 'student';

		$this->data['a_js_scripts'] = array(
				base_url()  . 'assets/js/student/base.js'
			);

		$this->data['a_css_sheets'] = array(
				base_url() . 'assets/css/student/base.css'
			);

		if($user = $this->session->userdata('user'))
		{
			if($user['user_type'] != 3)
			{
				if($user['user_type'] != 1)
				{
					redirect('/', 'refresh');
				}
				else
				{
					$student = $this->student_model->retrieve(['user_id' => $user['id']])[0];

					if(!$student)
						redirect(base_url());
					$this->data['student_id'] = $student->id;
					$this->data['user_id'] = $student->user_id;
					$this->data['name'] =  $student->first_name . ' ' . $student->last_name;

				}
			}
		}
	}

	public function index()
	{
		$student = $this->student_model->retrieve(['user_id' =>  $this->session->userdata('user')['id']])[0];

		if(!$student)
			redirect(base_url());
		$this->data['a_js_scripts'] = array(
				base_url()  . 'assets/js/student/base.js',
				base_url()  . 'assets/js/student/index.js'
			);

		$this->data['a_css_sheets'] = array(
				base_url() . 'assets/css/student/base.css',
				base_url() . 'assets/css/student/index.css'
			);

		$this->load->model('category_model');
		$a_teachers_list = array();
		$a_category_list = array();
		$user = $this->session->userdata('user');


		foreach($this->teacher_model->retrieveAll() as $key => $o_teacher_names) {
			$a_teachers_list[$o_teacher_names->id] = $o_teacher_names->first_name . ' ' . $o_teacher_names->last_name;
		}

		foreach($this->category_model->retrieveAll() as $key => $o_category) {
			$a_category_list[$o_category->id] = $o_category->category_name;
		}

		$this->data['a_teachers_list'] = $a_teachers_list;
		$this->data['a_category_list'] = $a_category_list;
		$this->data['s_main_content'] = 'student/index';
		$this->load->view('includes/template', $this->data);
	}

   public function create()
    {
    	if($this->input->post())
    	{
    		$this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]|trim|required');
    		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_confirmation]');
    		$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required');
	    	$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('course', 'Course', 'trim|required');

			if($this->form_validation->run())
			{
				$a_user_data = array(
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password')),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'user_type' => 1
				);

				$user_result = $this->user_model->create($a_user_data);

				if($user_result)
				{
					$a_student_data = array(
						'user_id' => $user_result,
						'course' => $this->input->post('course'),
					);
					$student_result = $this->student_model->create($a_student_data);
					$this->data['response'] = ['success' => 'true'];
				}
			}
			else
			{
				$this->data['error'] = validation_errors();
			}
		}
		else
		{
			$this->data['error'] = ['code' => '9002', 'message' => 'No Input was found.'];
		}

		$this->load->view('json', $this->data);
    }

    public function read($id)
    {
    	$a_data = [
    				'id' => $id,
    				'users.user_type' => 1
    	];
    	$result = $this->student_model->retrieve($a_data);
    	if($result)
    	{
    		unset($result[0]->password);
    		$this->data['response'] = ['success' => 'true', 'data' => $result[0]];
    	}
    	else
    	{
    		$this->data['error'] = ['code' => '9004', 'message' => 'Record does not exist.'];
    	}
		$this->load->view('json', $this->data);
    }

    public function update($id)
    {
    	if($this->input->post())
    	{
    		$where_data = array('id' => $id);
			$a_student_result = $this->student_model->retrieve($where_data);
			if($a_student_result)
			{
		    	$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
				$this->form_validation->set_rules('course', 'course', 'trim|required');

				if($this->form_validation->run())
				{
					$a_user_data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'user_type' => 1
					);

					$user_result = $this->user_model->edit($a_user_data, 'id = '.$a_student_result[0]->user_id);

					if(!$this->user_model->error_message)
					{
						$a_student_data = array(
							'course' => $this->input->post('course')
						);
						$student_result = $this->student_model->edit($a_student_data, 'id ='.$id);
						if(!$this->student_model->error_message)
						{
							$this->data['error'] = $this->student_model->error_message;
						}
						$this->data['response'] = ['success' => 'true'];
					}
					else
					{
						$this->data['error'] = $this->user_model->error_message;
					}
				}
				else
				{
					$this->data['error'] = validation_errors();
				}
			}
			else
			{
				$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
			}
		}
		else
		{
			$this->data['error'] = ['code' => '9002', 'message' => 'No Input was found.'];
		}

		$this->load->view('json', $this->data);
    }

    public function delete($id)
    {
    	if($this->input->post())
    	{
			$where_data = array('id' => $id);
			$student_result = $this->student_model->retrieve($where_data);
			if($student_result)
			{
				$student_result = $student_result[0];
				$this->student_model->delete(['id' => $student_result->id]);
				$this->user_model->delete(['id' => $student_result->user_id]);

				$this->data['response'] = ['success' => 'true'];
			}
			else
			{
				$this->data['error'] = ['code' => '9004', 'message' => 'Record does not exist.'];
			}
		}

		$this->load->view('json', $this->data);
    }

    public function retrieve_all()
    {
		$student_result = $this->student_model->retrieveAll();
		if($student_result)
		{
			$this->data['response'] = ['success' => 'true', 'data' => $student_result];
		}
		else
		{
			$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
		}


		$this->load->view('json', $this->data);
    }

}
