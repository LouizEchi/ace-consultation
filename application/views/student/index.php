<div class="container">
	<div class="row">
		<div class="col s6 login left-align form-logs">
			<h5 class="center-align">ICT Consultation</h5>
			<div class="card-panel left-align row">
				<div class="input-field col s7 black-text">
          			<input id="id" type="text" name="id" class="validate">
          			<label for="id">ID No.</label>
        		</div>
				<div class="input-field col s7">
				    <select>
						<option value="" disabled selected>Choose your option</option>
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
				    <select>
						<option value="" disabled selected>Choose your option</option>
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
	           	<div class="input-field col s7">
					<textarea id="comment" class="materialize-textarea" length="120"></textarea>
					<label for="comment">Comment</label>
	          	</div>
	          	<div class="col s12">
					<a class="waves-effect waves-light btn-large green right">Create Log</a>
				</div>

			</div>
		</div>
		<div class="col s6 logs-list">
		</div>
	</div>
</div>