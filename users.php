<?php require "assets/header.php"; ?>
<?php

if(isset($_POST["submit"])){
	
	//Sanitize Strings
	$username = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, "user_password", FILTER_SANITIZE_STRING);

	//HTML entities
	$username = htmlentities($username);
	$password = htmlentities($password);

	//Add slashes
	$username = addslashes($username);
	$password = addslashes($password);
	
	// Site Information
	$user_input["user_name"] = $username;
	$user_input["user_password"] = $password;
	$user_input["user_permission_level"] = $_POST["user_permission_level"];
	
	
	if($user->add_user($db_conn, $user_input)){
		echo $codeformat->generate_alert("success", "User added succesfully.");
	}else{
		echo $codeformat->generate_alert("error", "User could not be added to database.");
	}
}

if(isset($_GET["active"]) && isset($_GET["id"])){
	
	$user_input = array();
	$user_input["updateto"] = $_GET["active"];
	$user_input["user_id"] = $_GET["id"];
	
	if($user->user_active($db_conn, $user_input)){
		echo $codeformat->generate_alert("success", "Site Updated Succesfully.");
	}else{
		echo $codeformat->generate_alert("error", "Site Was Not Updated Successfully.");
	}
}

if(isset($_GET["user_id"]) && isset($_GET["cfirmdelete"]) && $_GET["cfirmdelete"] == "deleteuser"){

  $user_id = $_GET["user_id"];
  $user_input["user_id"] = $user_id;
  
  if($user->user_delete($db_conn,$user_input)){
    echo $codeformat->generate_alert("success", "User deleted succesfully.");
  }else{
    echo $codeformat->generate_alert("error", "User could not be deleted from database.");
  }
  
}elseif(isset($_GET["user_id"]) && isset($_GET["dlte"])){
	?>
  Are you sure you want to delete this user?<br/><br/><br/>
  <a href='users.php?user_id=<?php echo $_GET["user_id"];?>&cfirmdelete=deleteuser' class='action-links'>Yes, I'm sure</a>
  <?php
}

?>
<script>
	function validateForm(){
		var a = document.forms["add_new"]["user_name"].value;
		var b = document.forms["add_new"]["user_password"].value;
		var cntr = '0';
		
		if ( a == null || a == "" ) {
 			$("#user_name").toggleClass("try_again");
      cntr++;
		}
			 
		if ( a == null || a == "" ) {
 			$("#user_password").toggleClass("try_again");
      cntr++;
		}
		
		if (cntr > 0) {
			return false;
		}
		
	}
</script>
			
			<h2>Users</h2>
			<div class="container">
				<div class="container_header">
					<div class="container_header_left">ADD USER</div>
					<div class="container_header_right" style="font-size:19px; font-weight:bold;">+</div>
					<div class="clear"></div>
				</div>
				<div class="container_main">
				<form action="users.php" method="post" name="add_new">

					<div class="input_title">Username</div> <input type="text" name="user_name" id="user_name">
					<div class="clear"></div>
					<div class="input_title">Password</div> <input type="password" name="user_password" id="user_password">
					<div class="clear"></div>
					<div class="input_title">Permission Level</div>
					<select name="user_permission_level" id="user_permission_level">
						<option value="0">Read</option>
						<option value="1">Read/Add</option>
						<option value="2">Admin</option>
					</select>
					<div class="clear"></div>
					
					<input type="submit" name="submit" id="submit" value="Submit User">
					<div class="clear"></div>
				</form>
				</div>
				</div>
				<table class="sites-table">
					<thead>
						<tr>
							<td>ID #</td>
							<td>Username</td>
							<td>Permission Level</td>
							<td>Actions</td>
						</tr>
					</thead>
					<tbody>
					<?php
	$userArray = $user->select_users($db_conn, $user_input);		
	
						
						foreach($userArray as $user){
							echo 
							"<tr>
								<td> ".$user['user_id']."</td>
								<td> ".$user['user_name']."</td>
								<td> ".$codeformat->user_permission_level($user['user_permission_level'])."</td>
								<td><a href='edit_user.php?id=".$user['user_id']."' class='action-links'>EDIT</a> " . $codeformat->active_button($user['user_active'], $user['user_id']) . "  <a href='users.php?user_id=".$user['user_id']."&dlte=cfrm' class='action-links'>DELETE</a>
							</tr>";
						}
						
					?>	
					</tbody>	
				</table>
			
<?php require "assets/footer.php"; ?>