<?php require "assets/header.php"; ?>
<?php
$site = new site;

if(isset($_POST["submit"])){
	
	// Start Array
	$user_input = array();
	
	// Site Information
	$user_input["site_url"] = $_POST["site_url"];
	$user_input["site_username"] = $_POST["site_username"];
	$user_input["site_password"] = $_POST["site_password"];
	$user_input["site_host"] = $_POST["cpanel_url"];
	$user_input["cpanel_host"] = $_POST["cpanel_host"];
	
	// FTP Information
	if(!empty($_POST["ftp_username"])){
		$user_input["ftp_username"] = $_POST["ftp_username"];
	}else{
		$user_input["ftp_username"] = "";
	}
	
	if(!empty($_POST["ftp_password"])){
		$user_input["ftp_password"] = $_POST["ftp_password"];
	}else{
		$user_input["ftp_password"] = "";
	}
	
	if(!empty($_POST["ftp_host"])){
		$user_input["ftp_host"] = $_POST["ftp_host"];
	}else{
		$user_input["ftp_host"] = "";
	}
	
	if(!empty($_POST["ftp_destination"])){
		$user_input["ftp_destination"] = $_POST["ftp_destination"];
	}else{
		$user_input["ftp_destination"] = "";
	}
	
	if(!empty($_POST["ftp_port"])){
		$user_input["ftp_port"] = $_POST["ftp_port"];
	}else{
		$user_input["ftp_port"] = "0";
	}

	$user_input["comments"] = $_POST["comments"];
	$user_input["backup_schedule"] = $_POST["backup_schedule"];
	$user_input["cpanel_theme"] = $_POST["cpanel_theme"];
	$user_input["fingerprint_uname"] = $session_input["user_name"];
	
	
	if($site->add_site($db_conn, $user_input)){
		echo $codeformat->generate_alert("success", "Site added successfully.");
	}else{
		echo $codeformat->generate_alert("error", "Site was not added to database.");
	
	}
}

if(isset($_GET["active"]) && isset($_GET["id"])){
	
	$user_input = array();
	$user_input["updateto"] = $_GET["active"];
	$user_input["site_id"] = $_GET["id"];
	
	if($site->site_active($db_conn, $user_input)){
		echo $codeformat->generate_alert("success", "Site Updated Succesfully.");
	}else{
		echo $codeformat->generate_alert("error", "Site Was Not Updated Successfully.");
	}
}

//  function site_denied(){
// 	 echo $codeformat->generate_alert("error", "Please fill in all required fields.");
//  }

?>

<script>
	function validateForm(){
		var a = document.forms["add_new"]["site_url"].value;
		var b = document.forms["add_new"]["site_username"].value;
		var c = document.forms["add_new"]["site_password"].value;
		var d = document.forms["add_new"]["cpanel_url"].value;
		
		var cntr = '0';
		
		if ( a == null || a == "" ) {
 			$("#site_url").toggleClass("try_again");
      cntr++;
		}
			 
		if ( b == null || b == "" ) {
 			$("#site_username").toggleClass("try_again");
      cntr++;
		}
				
		if ( c == null || c == "" ) {
 			$("#site_password").toggleClass("try_again");
      cntr++;
		}
					
		if ( d == null || d == "" ) {
 			$("#cpanel_url").toggleClass("try_again");
      cntr++;
		}
		
		if (cntr > 0) {
			return false;
		}
		
	}
</script>
			
			<h2>Sites</h2>
			<div class="container">
				<div class="container_header">
					<div class="container_header_left">ADD SITE</div>
					<div class="container_header_right" style="font-size:19px; font-weight:bold;">+</div>
					<div class="clear"></div>
				</div>
				<div class="container_main">
				<form action="sites.php" method="post" onsubmit="return validateForm()" name="add_new">
					<div class="form_left">
					<div class="input_title">Site URL</div> <input type="text" name="site_url" id="site_url">
					<div class="clear"></div>
					<div class="input_title">cPanel Username</div> <input type="text" name="site_username" id="site_username">
					<div class="clear"></div>
					<div class="input_title">cPanel Password</div> <input type="text" name="site_password" id="site_password">
					<div class="clear"></div>
					<div class="input_title">cPanel URL (URL or IP Test both)</div> <input type="text" name="cpanel_url" id="cpanel_url">
					<div class="clear"></div>
					<div class="input_title">cPanel Host</div> 
					<select name="cpanel_host" id="cpanel_host">
						<?php $hosting_accounts = $main->list_hosts($db_conn); echo $codeformat->sort_hosts($hosting_accounts); ?>
					</select>
					<div class="clear"></div>
					<div class="input_title">cPanel Theme</div> 
					<select name="cpanel_theme" id="cpanel_theme">
						<option value="x3">x3</option>
						<option value="paper_lantern">paper_lantern</option>
					</select>
					<div class="clear"></div>
						<br/>
					<div class="input_title">Backup</div>
					<select name="backup_schedule" id="backup_schedule">
						<option value="0">Monthly</option>
						<option value="1">Every two weeks</option>
						<option value="2">Once a week</option>
					</select>
					<div class="clear"></div>
					Comments:<br/>
					<textarea name="comments" id="comments">
					</textarea>
					
					
					</div>
					<div class="form_right">
					(FTP is optional for backing up to a different server. Leave blank to use default FTP. Location must already exist on the server in order for backup to work.)<br/>
					<div class="input_title">FTP Username</div> <input type="text" name="ftp_username" id="ftp_username">
					<div class="clear"></div>
					<div class="input_title">FTP Password</div> <input type="text" name="ftp_password" id="ftp_password">
					<div class="clear"></div>
					<div class="input_title">FTP Host</div> <input type="text" name="ftp_host" id="ftp_host">
					<div class="clear"></div>
					<div class="input_title">FTP Port</div> <input type="text" name="ftp_port" id="ftp_port">
					<div class="clear"></div>
					<div class="input_title">Save Location</div> <input type="text" name="ftp_destination" id="ftp_destination">
					<div class="clear"></div>
					</div>
					<div class="clear"></div>
					<input type="submit" name="submit" id="submit" value="Submit Site">
					<div class="clear"></div>
				</form>
				</div>
				</div>

				<!-- Show off websites via table -->
				<table class="sites-table">
					<thead>
						<tr>
							<td>ID #</td>
							<td>URL</td>
							<td>cPanel Login</td>
							<td> Hosting </td>
							<td>Information</td>
							<td>Actions</td>

						</tr>
					</thead>
					<tbody>
					<?php
	$siteArray = $site->select_sites($db_conn, $user_input);		
	
						
						foreach($siteArray as $site){
							$cpanel_host = $main->grab_host($db_conn, $site["cpanel_host"]);
							echo "<tr class='" . $codeformat->backup_active_style($site['backup_active']) . "'>
								<td> ".$site['site_id']."</td>
								<td> ".$site['site_url']."</td>
								<td> ".$site['site_host']."</td>
								<td> " . $cpanel_host["host_name"] . " </td>
								<td> Backup Schedule: ". $codeformat->backup_schedule($site['backup_schedule'])."<br/>
								Last Backup: " . $codeformat->last_backup($site['last_backup']) . "<br/>
								Last Edit: " . $site["fingerprint_uname"] ."</td>
								<td>
								<a href='edit_site.php?id=" . $site['site_id']. "' class='action-links'>EDIT</a> 
								" . $codeformat->active_button($site['backup_active'], $site['site_id']) . "
								<div class='action-links' onclick='site_information(this.id);' id='site-".$site['site_id']."' style='display:inline-block;'>View Information</div><div class='clear'></div>
							</tr>
							<tr id='hidden-site-".$site['site_id']."' style='display:none;'>
								<td colspan='5'> ".$site['comments']."</td>
								<td> Username: ".$site['ftp_username']."<br />
								Password: ".$site['ftp_password']."<br />
								Host: ".$site['ftp_host']."<br />
								Location: ".$site['ftp_destination']."</td>
							</tr>
								";
						}
						
					?>	
					</tbody>	
				</table>
			
<?php require "assets/footer.php"; ?>