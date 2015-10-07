<div class="container">
	<div class="row">
		<div class="col s6 offset-s3 login white-text">
			<form id="frm_login" action="<?=base_url()?>login" method="POST" class="transparent">
			<div class="card-panel center-align row transparent">
				<div class="input-field col s6 offset-s3 black-text">
          			<input id="username" type="text" name="username" class="validate white-text" required>
          			<label for="username" class="white-text">Username</label>
        		</div>
				<div class="input-field col s6 offset-s3">
          			<input id="password" type="password" name="password" class="validate white-text" required>
          			<label for="password" class="white-text">Password</label>
        		</div>
        		<div class="col s6 offset-s3">
					<button type="submit" class="waves-effect waves-light btn-large transparent-border">Login</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>