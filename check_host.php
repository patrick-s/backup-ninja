<?php require "assets/header.php"; require_once "functions/class_checkhost.php"; ?>
<?php
$checkhost = filter_input(INPUT_POST, "checkhost", FILTER_SANITIZE_STRING);
$hostingurl = filter_input(INPUT_POST, "hosting_url", FILTER_SANITIZE_URL);

if(ISSET($checkhost) && ISSET($hostingurl)){
  
  $checkhost = new checkhost;
  $user_input["hosting_url"] = $hostingurl;
  if($checkhost->check_hosting($user_input)){
    echo $codeformat->generate_alert("success", "Host can be contacted and returns results.");
  }else{
    echo $codeformat->generate_alert("error", "Host could not be contacted or didn't return anything. Please re-upload the backup script.");
  }
  
}
?>
<h2>Check Hosting</h2>

<form action="check_host.php" method="post">
  Please input the URL of the backup script on the hosting account. <br/>
  <input type="text" name="hosting_url" class="hosting_url" id="hosting_url" placeholder="http://hostname.beaconbackup.ninja/buscript/backup_script.php" value="<?php echo $hostingurl; ?>">
  <input type="submit" name="checkhost" value="Check hosting account" class="action_submit">
</form>
<?php require "assets/footer.php"; ?>