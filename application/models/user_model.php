<?php

Class user_model extends Base_Model
{	

	public function __construct()
	{
		parent::__construct();

        $this->table = 'users';
        
        $this->fillable = array(
        						'id',
        						'username',
        						'password',
        						'user_type',
        						'first_name',
        						'last_name'
        				  );
	}

	public function login($data , $user_type)
	{
		$condition = "username ="."'".$data["username"]."' AND "."password = "."'".md5($data["password"])."' AND "." user_type =".$user_type;

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);

		$query = $this->db->get();

		if($query->num_rows() == 1)
		{
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function info($username)
	{
		$condition = "username = "."'".$username."'";

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}


	public function stud_list($number)
	{
		$condition = "year = "."'".$number."'";
		$this->db->select('*');
		$this->db->from('student');
		$this->db->where($condition);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_student($id, $data){
		$this->db->where('Student_id', $id);
		$this->db->update('student',$data);
	}

	public function new_stud($insert){
		$data = $this->db->insert('student', $insert);
		if($data)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function delete_stud($id){
		$this->db->where('Student_id', $id);
		$this->db->delete('student');
	}


	public function getallteachers(){
		$this->db->select('*');
		$this->db->from('teacher');
		$this->db->orderby('lastname');
		$query = $this->db->get();
		return $query->result();
	}

	public function new_tea($insert){
		$data = $this->db->insert('teacher', $insert);
		if($data)
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function update_teacher($update){
		$data = $this->db->where('Teacher_id', $update->Teacher_id);
		$data = $this->db->update('teacher', $update);
	}

	public function delete_teacher($id){
		$this->db->where('Teacher_id', $id);
		$this->db->delete('teacher');
	}
}