<?php require "assets/header.php"; ?>

<?php $id = $_GET["id"];
	
	$grab = new site;
	$user_input = array();
	$user_input["site_id"] = $id;
	
	$site = $grab->site_information($db_conn, $user_input);
	
	
	//if submit encode base 64
	
	
?>


		<form>
			<table>
				<thead>
					<tr>
						<td>ID #</td>
						<td>URL</td>
						<td>Username Encoded</td>
						<td>Password Info Encoded</td>
						<td>cPanel Host</td>
						<td>Backup Schedule</td>
						<td>FTP Host</td>
						<td>FTP User</td>
						<td>FTP Password</td>
						<td>FTP Backup Destination</td>
						<td>Last Backup</td>
						<td>Comments</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" name="site_id" value="<?php echo $site['site_id'] ?>" /></td>
						<td><input type="text" name="site_url" value="<?php echo $site['site_url'] ?>" /></td>
						<td><input type="text" name="site_id" value="Change Username?" /></td>
						<td><input type="text" name="site_id" value="Change Password?" /></td>
						<td><input type="text" name="site_id" value="<?php echo $site['site_host'] ?>" /></td>
						<td><select name="backup_schedule" id="backup_schedule">
							<?php
								switch ($site['backup_schedule']) {
								    case 1:
								        echo "<option value='1' selected>Every two weeks</option>";
								        break;
								    case 2:
								        echo "<option value='2' selected>Once a week</option>";
								        break;
								    default:
								     	echo "<option value='0' selected>Monthly</option>";
								}
							?>
							<option disabled="--"></option>
							<option value="0" selected>Monthly</option>
							<option value="1">Every two weeks</option>
							<option value="2">Once a week</option>
						</select></td>
						
						<td><input type="text" name="site_id" value="<?php echo $site['ftp_host'] ?>" /></td>
						<td><input type="text" name="site_id" value="<?php echo $site['ftp_username'] ?>" /></td>
						<td><input type="text" name="site_id" value="<?php echo $site['ftp_password'] ?>" /></td>
						<td><input type="text" name="site_id" value="<?php echo $site['ftp_destination'] ?>" /></td>
						<td><input type="text" name="site_id" value="<?php echo $site['last_backup'] ?>" /></td>
						<td><input type="text" name="site_id" value="<?php echo $site['comments'] ?>" /></td>
					</tr>
				</tbody>
			</table>
		</form>
<?php require "assets/footer.php"; ?>