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
		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->model('teacher_model');
		$this->load->model('user_model');
		$this->data['s_page_header'] = 'teacher';
		$this->data['s_page_type'] = 'teacher';
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
			$this->form_validation->set_rules('department', 'Department', 'trim|required');

			if($this->form_validation->run())
			{
				$a_user_data = array(
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password')),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'user_type' => 2
				);

				$user_result = $this->user_model->create($a_user_data);

				if($user_result)
				{
					$a_teacher_data = array(
						'user_id' => $user_result,
						'department' => $this->input->post('department'),
					);
					$teacher_result = $this->teacher_model->create($a_teacher_data);
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
    				'users.user_type' => 2
    	];
    	$result = $this->teacher_model->retrieve($a_data);
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
			$a_teacher_result = $this->teacher_model->retrieve($where_data);
			if($a_teacher_result)
			{
		    	$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
				$this->form_validation->set_rules('department', 'department', 'trim|required');

				if($this->form_validation->run())
				{
					$a_user_data = array(
						'username' 	 => $this->input->post('username'),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'user_type' => 2
					);

					$user_result = $this->user_model->edit($a_user_data, 'id = '.$a_teacher_result[0]->user_id);

					if(!$this->user_model->error_message)
					{
						$a_teacher_data = array(
							'department' => $this->input->post('department')
						);
						$teacher_result = $this->teacher_model->edit($a_teacher_data, 'id ='.$id);
						if(!$this->teacher_model->error_message)
						{
							$this->data['error'] = $this->teacher_model->error_message;
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
			$teacher_result = $this->teacher_model->retrieve($where_data);				
			if($teacher_result)
			{
				$teacher_result = $teacher_result[0];
				$this->teacher_model->delete(['id' => $teacher_result->id]);
				$this->user_model->delete(['id' => $teacher_result->user_id]);

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
		$teacher_result = $this->teacher_model->retrieveAll();				
		if($teacher_result)
		{
			$this->data['response'] = ['success' => 'true', 'data' => $teacher_result];
		}
		else
		{
			$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
		}


		$this->load->view('json', $this->data);
    }
}
