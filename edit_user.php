<?php require "assets/header.php"; ?>

<?php $id = $_GET["id"];
	$user_input = array();
	$user_input["user_id"] = $id;
	
	if(isset($_POST["update_user"])){
		//Sanitize Strings
		$username = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, "user_password", FILTER_SANITIZE_STRING);

		//HTML entities
		$username = htmlentities($username);
		$password = htmlentities($password);

		//Add slashes
		$username = addslashes($username);
		$password = addslashes($password);
		
		$user_input["user_id"] = $id;
		$user_input["user_name"] = $username;
		$user_input["user_password"] = $password;
		$user_input["user_permission_level"] = $_POST["user_permission_level"];
		
		if($user->user_update($db_conn, $user_input)){
			echo $codeformat->generate_alert("success", "User Updated Sucessfully.");
		}else{
			echo $codeformat->generate_alert("error", "User Could Not Be Updated.");
		}
	}
	
	$user_information = $user->user_information($db_conn, $user_input);
	
	
	//if submit encode base 64
	
	
?>
		
		<form action="edit_user.php?id=<?php echo $user_information['user_id']; ?>" method="post">
			<table class="edit-table">
				<colgroup>
					<col class="edit-col-1">
					<col class="edit-col-2">
				</colgroup>
				<tr>
					<td>ID #</td>
					<td>#<?php echo $user_information['user_id']; ?></td>
				</tr>
				<tr>
					<td>Username</td>
					<td><input type="text" name="user_name" value="<?php echo stripslashes($user_information['user_name']); ?>" /></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="user_password" placeholder="Leave blank if not changed" /></td>
				</tr>
				
				<tr>
					<td>User Permission</td>
					<td><select name="user_permission_level" id="user_permission_level">
						<option value="<?php echo $user_information["user_permission_level"]; ?>"><?php echo $codeformat->user_permission_level($user_information["user_permission_level"]); ?> (Current)</option>
						<option disabled>-----</option>
						<option value="0">Read</option>
						<option value="1">Read/Add</option>
						<option value="2">Admin</option>
					</select></td>
				</tr>
				
				<tr>
					<td>Update User</td>
					<td><input type="submit" name="update_user" id="update_user" value="Update User" /></td>
				</tr>
			</table>
		</form>
<?php require "assets/footer.php"; ?>