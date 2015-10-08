<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

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
		$this->load->model('consultation_logs_model');
		$this->load->model('student_model');
		$this->load->model('teacher_model');
		$this->load->model('user_model');
		$this->data['s_page_header'] = 'consultation';
		$this->data['s_page_type'] = 'consultation';
	}

    public function index()
   	{

   	}

    public function create()
    {
    	if($this->input->post())
    	{
    		$this->form_validation->set_rules('student_id', 'Student', 'numeric|required');
    		$this->form_validation->set_rules('teacher_id', 'Teacher', 'numeric|required');
	    	$this->form_validation->set_rules('category_id', 'Category', 'numeric|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');

			if($this->form_validation->run())
			{
				$a_consulation_data = array(
					'student_id' => $this->input->post('student_id'),
					'teacher_id' => $this->input->post('teacher_id'),
					'category_id' => $this->input->post('category_id'),
					'comment'	=> $this->input->post('comment'),
					'time_in'	=> date('y-m-d H:i:s')
				);

				$consulation_result = $this->consultation_logs_model->create($a_consulation_data );

				if(!$this->consultation_logs_model->error_message)
				{
					$this->data['response'] = ['success' => 'true'];
				}
				else
				{
					$this->data['error'] = $this->consultaion_logs_model->error_message;
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

		public function retrieve_student_logs($student_id)
		{
			$consultation_result = $this->consultation_logs_model->retrieveStudentLogs($student_id);
			if($consultation_result)
			{
				$a_return = [];
				foreach($consultation_result as $record)
				{
					$a_student_data = array(
						'id' => $record['student_user_id']
					);
					$a_teacher_data = array(
						'id' => $record['teacher_user_id']
					);
					$teacher_result = $this->user_model->retrieve($a_teacher_data)[0];
					$record['teacher_name'] = $teacher_result->first_name . ' ' . $teacher_result->last_name;

					$student_result = $this->user_model->retrieve($a_student_data)[0];
					$record['student_name'] = $student_result->first_name . ' ' . $student_result->last_name;

					$a_return[] = $record;
				}
				$this->data['response'] = ['success' => 'true', 'data' => $a_return];
			}
			else
			{
				$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
			}


			$this->load->view('json', $this->data);
		}

    public function retrieve_all()
    {
			$consultation_result = $this->consultation_logs_model->retrieveAll();
			if($consultation_result)
			{
				$a_return = [];
				foreach($consultation_result as $record)
				{
					$a_student_data = array(
						'id' => $record['student_user_id']
					);
					$a_teacher_data = array(
						'id' => $record['teacher_user_id']
					);
					$teacher_result = $this->user_model->retrieve($a_teacher_data)[0];
					$record['teacher_name'] = $teacher_result->first_name . ' ' . $teacher_result->last_name;

					$student_result = $this->user_model->retrieve($a_student_data)[0];
					$record['student_name'] = $student_result->first_name . ' ' . $student_result->last_name;

					$a_return[] = $record;
				}
				$this->data['response'] = ['success' => 'true', 'data' => $a_return];
			}
			else
			{
				$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
			}


			$this->load->view('json', $this->data);
    }

    public function check_time_out($student_id)
    {
    	return !$this->consultation_logs_model->checkStudentLogsWithoutTimeOut($student_id);
    }

    public function get_latest_time_in($student_id)
    {
    	if($result = $this->consultation_logs_model->getLatestTimeIn($student_id))
    	{
    		$this->data['response'] = ['success' => 'true', 'data' => $result];
    	}
    	else
    	{
    		$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
    	}
    	$this->load->view('json', $this->data);
    }

    public function time_out($student_id)
    {
	    	if($result = $this->consultation_logs_model->timeOut($student_id))
	    	{
	    		$this->data['response'] = ['success' => 'true', 'data' => $result];
	    	}
	    	else
	    	{
	    		$this->data['error'] = ['code' => '9003', 'message' => 'No Records Found.'];
	    	}
    		$this->load->view('json', $this->data);
    }
}
