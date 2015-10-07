<?php
class category_model extends Consultation_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->table = 'category';
        
        $this->fillable = array(
        						'id',
        						'category_name'
        				  );
    }

}

?>