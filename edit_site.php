<?php require "assets/header.php"; ?>

<?php $id = $_GET["id"];
	
	$site = new site;
	$user_search = array();
	$user_search["site_id"] = $id;

	if(isset($_POST["update_site"])){
		$user_input = array();
		$user_input["site_id"] = $id;
		$user_input["site_url"] = $_POST["site_url"];
		$user_input["site_username"] = $_POST["site_username"];
		$user_input["site_password"] = $_POST["site_password"];
		$user_input["site_host"] = $_POST["site_host"];
		$user_input["cpanel_theme"] = $_POST["cpanel_theme"];
		$user_input["cpanel_host"] = $_POST["cpanel_host"];
		$user_input["ftp_host"] = $_POST["ftp_host"];
		$user_input["ftp_username"] = $_POST["ftp_user"];
		$user_input["ftp_password"] = $_POST["ftp_password"];
		$user_input["ftp_port"] = $_POST["ftp_port"];
		$user_input["ftp_destination"] = $_POST["ftp_destination"];
		$user_input["backup_schedule"] = $_POST["backup_schedule"];
		$user_input["comments"] = $_POST["comments"];
		$user_input["fingerprint_uname"] = $session_input["user_name"];
		
		if($site->site_update($db_conn, $user_input)){
			echo $codeformat->generate_alert("success", "Site Updated Sucessfully.");
		}else{
			echo $codeformat->generate_alert("error", "Site Could Not Be Updated.");
		}
	}
	
	$site = $site->site_information($db_conn, $user_search);
	
	
	//if submit encode base 64
	
	
?>
		
		<form action="edit_site.php?id=<?php echo $id; ?>" method="post">
			<table class="edit-table">
				<colgroup>
					<col class="edit-col-1">
					<col class="edit-col-2">
				</colgroup>
				<tr>
					<td>ID #</td>
					<td>#<?php echo $site['site_id'] ?></td>
				</tr>
				<tr>
					<td>Last Edit</td>
					<td><?php echo $site['fingerprint_uname'] ?></td>
				</tr>
				<tr>
					<td>URL</td>
					<td><input type="text" name="site_url" value="<?php echo $site['site_url'] ?>" /></td>
				</tr>
				<tr>
					<td>Username</td>
					<td><input type="text" name="site_username" value="<?php echo $site['site_username'] ?>" /></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="text" name="site_password" value="<?php echo $site['site_password'] ?>" /></td>
				</tr>
				<tr>
					<td>cPanel URL</td>
					<td><input type="text" name="site_host" value="<?php echo $site['site_host'] ?>" /></td>
				</tr>
				<tr>
					<td>cPanel Host</td>
					<td><select name="cpanel_host" id="cpanel_host">
						<option value="<?php echo $site['cpanel_host']; ?>"><?php $host = $main->grab_host($db_conn, $site['cpanel_host']); echo $host["host_name"];  ?> (Current)</option>
						<option disabled="--">-----------------</option>
						<?php $hosting_accounts = $main->list_hosts($db_conn); echo $codeformat->sort_hosts($hosting_accounts); ?>
					</select></td>
				</tr>
				<tr>
					<td>cPanel Theme</td>
					<td><select name="cpanel_theme" id="cpanel_theme">
						<option value="<?php echo $site['cpanel_theme']; ?>"><?php echo $site['cpanel_theme']; ?> (Current)</option>
						<option disabled="--">-----------------</option>
						<option value="x3">X3</option>
						<option value="paper_lantern">paper_lantern</option>
					</select></td>
				</tr>
				<tr>
					<td>Backup Schedule</td>
					<td><select name="backup_schedule" id="backup_schedule">
						<option value="<?php echo $site['backup_schedule']; ?>"><?php echo $codeformat->backup_schedule($site['backup_schedule']); ?> (Current)</option>
						<option disabled="--">-----------------</option>
						<option value="0">Monthly</option>
						<option value="1">Every two weeks</option>
						<option value="2">Once a week</option>
					</select></td>
				</tr>
				<tr>
					<td>FTP Host</td>
					<td><input type="text" name="ftp_host" value="<?php echo $site['ftp_host'] ?>" /></td>
				</tr>
				<tr>
					<td>FTP User</td>
					<td><input type="text" name="ftp_user" value="<?php echo $site['ftp_username'] ?>" /></td>
				</tr>
				<tr>
				</tr>
					<td>FTP Password</td>
					<td><input type="text" name="ftp_password" value="<?php echo $site['ftp_password'] ?>" /></td>
				<tr>
					<td>FTP Backup Destination</td>
					<td><input type="text" name="ftp_destination" value="<?php echo $site['ftp_destination'] ?>" /></td>
				</tr>
				<tr>
					<td>FTP Port</td>
					<td><input type="text" name="ftp_port" value="<?php echo $site['ftp_port'] ?>" /></td>
				</tr>
				<tr>
					<td>Comments</td>
					<td><textarea name="comments" /><?php echo $site['comments'] ?></textarea></td>
				</tr>
        <tr>
					<td>Update Site</td>
					<td><input type="submit" name="update_site" id="update_site" value="Update Site" /></td>
				</tr>
			</table>
		</form>
<?php require "assets/footer.php"; ?>