<?php require "assets/header.php";
if(isset($_POST["delete"])){
	
	//declare vars
	$site_id = $_POST["delete_id"];
	$site = new site;
	$site_info = $site->select_site($db_conn, $site_id);
	
?>
Are you sure you want to stop backups for <?php echo $site_info[0]["site_url"]; ?>

<a href="sites.php"><button>No</button></a>

<form action="delete.php" method="post">
	<input type="submit" name="destroy" id="destoy" value="DELETE" >
	<input name="delete_id" value = "<?php echo $site_id; ?>" style="display:none;" type="hidden">
</form>


<?php 
	} elseif(isset($_POST["destroy"])){
		$site_id = $_POST["delete_id"];
		$site = new site;
		if($site->delete_site($db_conn, $site_id)){
			?>
			<div class="alert">
				<div class="success-alert">
					Sites sucessfully deleted.
				</div>
			</div>
	<?php
		} else {
			?>
			<div class="alert">
				<div class="error-alert">
					Error: Site did not submit to database.
				</div>
			</div>
			<?php
		}
	}
	
	require "assets/footer.php"; ?>