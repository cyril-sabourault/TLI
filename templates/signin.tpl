<div class="form-group">
	<form method="POST" action="index.php?page=signin">
		<label for="email">Email</label>
		<input type="email" class="form-control" name="email" placeholder="Enter email">
		<label for="password">Mot de passe</label>
		<input type="password" class="form-control" name="password" placeholder="Password">
		<input type="submit" class="button-submit btn btn-default pull-right" value="Se connecter">
		<input type="hidden" name="action" value="signIn">
		<input type="hidden" name="kind_action" value="auth">
	</form>
</div>
