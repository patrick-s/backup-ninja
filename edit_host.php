<?php require "assets/header.php"; ?>

<?php $id = $_GET["id"];
	$script_input = array();
	$script_input["id"] = $id;
	
	$host = new host;
	if(isset($_POST["update_host"])){
		$user_input = array();
		$user_input["id"] = $id;
		$user_input["host_name"] = $_POST["host_name"];
		$user_input["backup_url"] = $_POST["backup_url"];
		
		if($host->host_update($db_conn, $user_input)){
			echo $codeformat->generate_alert("success", "Host Updated Sucessfully.");
		}else{
			echo $codeformat->generate_alert("error", "Host Could Not Be Updated.");
		}
	}
	
	$host_information = $host->host_information($db_conn, $script_input);
	
?>
		
		<form action="edit_host.php?id=<?php echo $host_information['id']; ?>" method="post">
			<table class="edit-table">
				<colgroup>
					<col class="edit-col-1">
					<col class="edit-col-2">
				</colgroup>
				<tr>
					<td>ID #</td>
					<td>#<?php echo $host_information['id']; ?></td>
				</tr>
				<tr>
					<td>Host Name</td>
					<td><input type="text" name="host_name" value="<?php echo $host_information['host_name'] ?>" /></td>
				</tr>
				<tr>
					<td>Backup URL</td>
					<td><input type="text" name="backup_url" value="<?php echo $host_information['host_location'] ?>" /></td>
				</tr>
				<tr>
					<td>Update Host</td>
					<td><input type="submit" name="update_host" id="update_host" value="Update Host" /></td>
				</tr>
			</table>
		</form>
<?php require "assets/footer.php"; ?>