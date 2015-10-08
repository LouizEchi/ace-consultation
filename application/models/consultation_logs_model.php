<?php
class consultation_logs_model extends Consultation_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->table = 'consultations';

        $this->fillable = array(
        						'id',
        						'student_id',
        						'teacher_id',
        						'category_id',
        						'comment',
        						'time_in',
        						'time_out'
        				  );
    }

    function retrieveAll($fields = '*', $order_by_field = null, $sort_by = null)
    {
        if($fields == '*')
        {
            $fields = 'consultations.*, students.id as student_id, students.user_id as student_user_id, teachers.id as teacher_id, teachers.user_id as teacher_user_id, students.course as student_course, teachers.department as teacher_department, category.id as category_id, category.category_name';
        }
        $this->db->select($fields);

        $this->db->join('students', 'students.id=consultations.student_id');
        $this->db->join('teachers', 'teachers.id=consultations.teacher_id');
        $this->db->join('category', 'category.id=consultations.category_id');

        $this->db->order_by('consultations.id', 'desc');

        if($result = $this->db->get($this->table))
        {
            $result = $result->result_array();
        }
        else
        {
            $this->error_message = $this->db->_error_message();
        }
        return $result;
    }

    function retrieveStudentLogs($student_id, $fields = '*', $order_by_field = null, $sort_by = null)
    {
        if($fields == '*')
        {
            $fields = 'consultations.*, students.id as student_id, students.user_id as student_user_id, teachers.id as teacher_id, teachers.user_id as teacher_user_id, students.course as student_course, teachers.department as teacher_department, category.id as category_id, category.category_name';
        }
        $this->db->select($fields);
				$this->db->where('consultations.student_id='.$student_id);
        $this->db->join('students', 'students.id=consultations.student_id');
        $this->db->join('teachers', 'teachers.id=consultations.teacher_id');
        $this->db->join('category', 'category.id=consultations.category_id');

        $this->db->order_by('consultations.id', 'desc');

        if($result = $this->db->get($this->table))
        {
            $result = $result->result_array();
        }
        else
        {
            $this->error_message = $this->db->_error_message();
        }
        return $result;
    }

    function checkStudentLogsWithoutTimeOut($student_id)
    {
        $this->db->select('max(time_in) as time_in, time_out, student_id');
        $this->db->where('student_id='.$student_id.' AND time_out IS NULL' );

        if($result = $this->db->get($this->table))
        {
            $result = (count($result->result()) != 0) ? true : false;
        }
        else
        {
            $this->error_message = $this->db->_error_message();
        }
        return $result;
    }

    function getLatestTimeIn($student_id)
    {
        $this->db->select('time_in, time_out, student_id');
        $this->db->where('student_id='.$student_id );

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

    function timeOut($student_id)
    {
        $this->db->select('max(time_in) as time_in, time_out, student_id');
        $where = 'student_id='.$student_id;
        $data =  ['time_out' => date('y-m-d H:i:s')];

        if($result = $this->db->update($this->table,$data, $where))
        {
            $result = $this->db->affected_rows();
        }
        else
        {
            $this->error_message = $this->db->_error_message();
        }
        return $result;
    }


}

?>
