<div class="container">
	<h5 class="center-align white-text"> All Logs </h5>
	<div class="panel panel-student">
		<div class="row white-text">
			<div class="col s12">
				<table class="highlight" id="tbl_admin_consulatation_logs" xurl="<?=base_url()?>logs/retrieve_all">
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
