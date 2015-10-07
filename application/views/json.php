<?php
	// RFC4627-compliant header
	header('Content-type: application/json');

	// Encode data
	if(isset($response)) 
	{
		echo json_encode($response);
	}
	elseif(isset($error))
	{
		echo json_encode(array('error' => $error));
	}
?>