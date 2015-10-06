<?php
class Consultation_Model extends CI_Model 
{
	/**
	 * Holds the table
	 *
	 * @var string
	 */
	public $table;
	
	
	/**
	 * Holds the error messages
	 *
	 * @var array
	 */
	public $error_message;
	
	
	/**
	 * Holds the model fillable fields 
	 *
	 * @var array
	 */
	public $fillable;
	
		
	/**
	* Constructor
	*/
	function __construct()
	{
        parent::__construct();
        
        $this->load->database();
	}
	
	/**
	* Adds a record in a table
	* @param	array	$data
	* @return	mixed
	 */
	function create($data)
	{
		$result = false;
		$data = $this->getFillableData($data);
		if($data)
		{
			if ($this->db->insert($this->table, $data)) 
			{
				$result = $this->db->insert_id();
			}
			else
			{
				$this->error_message = $this->db->_error_message();
			}
		}
		
		return $result;
	}
	
	/**
	* Deletes a record in a table
	* @param	array	$data
	* @return	mixed
	 */
	function delete($data)
	{
		$result = false;
		$data = $this->getFillableData($data);
		if($data)
		{
			if($this->db->delete($this->table, $data))
			{
				$result = $this->db->affected_rows();
			}
			else
			{
				$this->error_message = $this->db->_error_message();
			}
		}
		
		return $result;
	}
	
	/**
	* Updates a record in a table
	* @param	array	$data
	* @return	mixed
	 */
	function edit($data, $where)
	{
		$result = false;
		$data = $this->getFillableData($data);
		
		if($data && $where)
		{
			if($this->db->update($this->table, $data, $where))
			{
				$result = $this->db->affected_rows();
			}
			else
			{
				$this->error_message = $this->db->_error_message();
			}
		}
		
		return $result;
	}
	
	/**
	* Gets the total number of rows
	* @param	array	$data
	* @return	mixed
	 */
	function found_rows()
	{
		return $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
	}
	
	/**
	* Gets a record in a table by condition
	* @param	array	$data
	* @return	mixed
	 */
	function retrieve($data, $fields = '*')
	{
		$result = false;
		$data = $this->getFillableData($data);
		if($data)
		{
			$this->db->select($fields);
			$this->db->from($this->table);
			$this->db->where($data);
			
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
	
	/**
	* Gets all records in a table
	* @param	array	$data
	* @return	mixed
	 */
	function retrieveAll($fields = '*', $order_by_field = null, $sort_by = null)
	{
		$result = false;
		
		$this->db->select($fields);
		if($order_by_field && $sort_by)
		{
			$this->db->order_by($order_by_field, $sort_by);
		}
		
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
	
	
	//---------- getters
	
	function getFillableData($data)
	{
		$result = false;
		if($data && $this->fillable)
		{
			$result = array();
			for($i=0; $i<count($this->fillable); $i++)
			{
				$key = $this->fillable[$i];
				if(isset($data[$key]))
					$result[$key] = $data[$key];
			}
		}
		
		
		return $result;
	}

}

?>