<div class="container">
	<div class="panel transparent">
		<div class="row white-text">
			<div class="col s3 offset-s9 right-align">
				<a id="add_student" class="btn button-collapse btn-form-side waves-effect waves-light transparent-border" data-activates="slide-out"><i class="material-icons">add</i></a>
			</div>
			<div class="col s12">
				<table class="highlight" id="tbl_students" xurl="<?=base_url()?>student/retrieve_all">
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
						<tr class="cloned_item hide">
							<td data-column="id"></td>
							<td data-column="first_name"></td>
							<td data-column="last_name"></td>
							<td data-column="course"></td>
							<td class="center-align">
								<a class="btn waves-effect waves-light transparent-border" data-edit-url="<?=base_url()?>student/edit/id_placeholder"><i class="material-icons">edit</i></a>
								<a href="" class="btn waves-effect waves-light transparent-border" data-delete-url="<?=base_url()?>student/delete/id_placeholder"><i class="material-icons">delete</i> </a></td>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="slide-out" class="side-nav side-form white-text right">
	<form data-post-url="<?=base_url()?>student/create" class="hide" id="frm_add_student">
		<div class="row center-align">
			<h5 class="center-align"><u>Add New Student</u></h5>
			<div class="input-field col s8">
	          <input id="username" type="text" name="username" class="validate">
	          <label for="username">Username</label>
			</div>
			<div class="input-field col s8">
	          <input id="password" type="password" name="password" class="validate">
	          <label for="password">Password</label>
			</div>
			<div class="input-field col s8">
	          <input id="password_confirmation" type="password" name="password_confirmation" class="validate">
	          <label for="password_confirmation">Confirm Password</label>
			</div>
			<div class="input-field col s8">
	          <input id="first_name" type="text" name="first_name" class="validate">
	          <label for="first_name">First Name</label>
			</div>
	       	<div class="input-field col s8">
	          <input id="last_name" type="text" name="last_name" class="validate">
	          <label for="last_name">Last Name</label>
	      	</div>
	       	<div class="input-field col s8">
	          <input id="course" type="text" name="course" class="validate">
	          <label for="course">Course</label>
	      	</div>
	      	<div class="col s8 offset-s2 center-align">
				<a class="waves-effect waves-light btn-large transparent-border white-text" id="add_new_student">Add Student</a>
			</div>
		</div>
	</form>
</div>