<div class="container">
	<h5 class="center-align white-text"> Recent Logs </h5>
	<div class="card-panel panel panel-student">
		<div class="row white-text">
			<div class="col s12">
				<table class="highlight" id="tbl_consulatation_logs" xurl="<?=base_url()?>logs/retrieve_student_logs/<?=$student_id?>">
					<thead>
						<tr>
							<th>ID</th>
							<th>Student</th>
							<th>Teacher</th>
							<th>Category</th>
							<th>Comment</th>
							<th>Time In</th>
							<th>Time Out</th>
						</tr>
					</thead>
					<tbody>
						<tr class="cloned_item hide">
							<td data-column="id"></td>
							<td data-column="student_name"></td>
							<td data-column="teacher_name"></td>
							<td data-column="category_name"></td>
							<td data-column="comment"></td>
							<td data-column="time_in"></td>
							<td data-column="time_out"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="slide-out" class="side-nav side-form white-text">
	<div class="card-panel row clock" >
		<div class="col s4 offset-s4 minor-date">
			<span class="left" id="current_day">
			</span>
			<span class="right" id="current_date">
			</span>
		</div>
		<div class="col s12 center-align" id="clock">
		</div>
	</div>
	<form data-post-url="<?=base_url()?>logs/create" id="frm_create_consultation">
		<div class="row">
			<h5 class="center-align col s12"><u>TIME IN</u></h5>
		</div>
		<div class="row">
			<input type="hidden" name="student_id" value="<?= isset($student_id) ? $student_id : '' ?>">
			<div class="input-field col s7">
			    <select name="teacher_id">
					<option value="" disabled selected>Select a teacher</option>
				  	<?php
				  		if(isset($a_teachers_list))
				  		{
				  			foreach($a_teachers_list as $key => $teacher)
				  			{
				  				echo '<option value="'.$key.'">'.$teacher. '</a><li>';
				  			}
				  		}

				  	?>
			    </select>
			    <label>Teacher</label>
    		</div>

			<div class="input-field col s7">
			    <select class="select-transparent" name="category_id">
					<option value="" disabled selected>Select a category</option>
				  	<?php
				  		if(isset($a_category_list))
				  		{
				  			foreach($a_category_list as $key => $category)
				  			{
				  				echo '<option value="'.$key.'">'.$category. '</a><li>';
				  			}
				  		}

				  	?>
			    </select>
			    <label>Category</label>
    		</div>
           	<div class="input-field col s12">
				<textarea id="comment" class="materialize-textarea" name="comment" length="255" rows="10" cols="50"></textarea>
				<label for="comment">Comment</label>
          	</div>
          	<div class="col s6 offset-s3">
				<a class="waves-effect waves-light btn-large transparent-border white-text" data-post="frm_create_consultation">Time In</a>
			</div>

		</div>
	</form>
</div>
