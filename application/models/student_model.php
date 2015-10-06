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
        						'department'
        				  );
    }


	function retrieveAll($fields = '*', $order_by_field = null, $sort_by = null)
	{
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
}

?>