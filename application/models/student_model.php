<?php
class student_model extends Consultation_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->table = 'students';
        
        $this->fillable = array(
        						'id',
        						'user_id',
        						'course'
        				  );
    }


	function retrieveAll($fields = '*', $order_by_field = null, $sort_by = null)
	{
		if($fields == '*')
		{
			$fields = 'students.*,users.first_name, users.last_name,users.id as user_id';
		}
		$this->db->select($fields);

		$this->db->join('users', 'users.id=students.user_id');
		$this->db->order_by('users.first_name', 'asc');

		if($result = $this->db->get($this->table))
		{
			$result = $result->result();
		}
		else
		{
			$this->error_message = $this->db->_error_message();
		}
		return $result;
	}

	function retrieve($data, $fields = '*')
	{
		$result = false;
		if($fields == '*')
		{
			$fields = 'students.*,users.first_name, users.last_name,users.id as user_id';
		}
		$data = $this->getFillableData($data);
		if($data)
		{
			$data['students.id'] = $data['id'];
			unset($data['id']);
			$this->db->select($fields);
			$this->db->from('students');
			$this->db->where($data);
			$this->db->join('users', 'students.user_id = users.id');
			
			if($result = $this->db->get())
			{
				$result = count($result->result()) > 0 ? $result->result() : false;
			}
			else
			{
				$this->error_message = $this->db->_error_message();
			}
		}
		

		return $result;
	}
}

?>