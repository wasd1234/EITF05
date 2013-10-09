<form name="login_form" method="post" action="">
	<table>
		<thead>
			<tr>
				<td><h2>Login </h2></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Username</td>
				<td>:</td>
				<td>
				<input name="username" type="text" id="username" class="lu-input-field" placeholder="Username">
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>:</td>
				<td>
				<input name="password" type="password" id="password" class="lu-input-field" placeholder="Password">
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
					<input id="btn-submit-login" type="submit" name="Submit" value="Login">
				</td>
			</tr>
		</tbody>
	</table>
</form>
<a type="button" href="?page=create_user">Create new user</a>
<a type="button" href="?page=lost_password">Lost password?</a>