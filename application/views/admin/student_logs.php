<div class="container">
	<div class="panel transparent">
		<div class="row white-text">
			<div class="col s3 offset-s9 right-align">
				<a class="btn button-collapse btn-form-side waves-effect waves-light transparent-border" data-activates="slide-out"><i class="material-icons">add</i></a>
			</div>
			<div class="col s12">
				<table class="highlight">
					<thead>
						<tr>
							<th>ID</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Course</th>
							<th class="center-align">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($a_student_logs as $student){?>
							<tr>
								<td class="id"><?= $student->id ?></td>
								<td class="first"><?= $student->first_name?></td>
								<td class="last"><?= $student->last_name ?></td>
								<td class="department"><?= $student->department ?></td>
								<td class="center-align">
									<a class="btn waves-effect waves-light transparent-border"><i class="material-icons">edit</i></a>
									<a href="" class="btn waves-effect waves-light transparent-border"><i class="material-icons">delete</i> </a></td>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="slide-out" class="side-nav side-form grey darken-3 white-text right">
	<div class="row">
		<h5 class="center-align"><u>Add New Student</u></h5>
		<div class="input-field col s8">
          <input id="first_name" type="text" name="first_name" class="validate">
          <label for="first_name">First Name</label>
		</div>
       	<div class="input-field col s8">
          <input id="last_name" type="text" name="last_name" class="validate">
          <label for="last_name">Last Name</label>
      	</div>
       	<div class="input-field col s8">
          <input id="department" type="text" name="department" class="validate">
          <label for="department">Course</label>
      	</div>
      	<div class="col s8 offset-s2 center-align">
			<a class="waves-effect waves-light btn-large transparent-border white-text">Add Student</a>
		</div>
	</div>
</div>