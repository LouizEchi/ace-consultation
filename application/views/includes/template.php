<?php $this->load->view('includes/header'); ?>


<?php isset($s_main_content) ? $this->load->view($s_main_content) : null; ?>
	<?php
		if(isset($a_sub_contents)) {
			foreach($a_sub_contents as $s_sub_content) $this->load->view($s_sub_content);
		}
	?>
	
</div>
<?php $this->load->view('includes/footer'); ?>