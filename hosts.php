<?php require "assets/header.php"; ?>
<?php
$host = new host;
$id = $_GET["id"];

if(isset($_POST["submit"])){
	
	// Start Array
	$user_input = array();
	
	// Site Information
	$user_input["host_name"] = $_POST["host_name"];
	$user_input["host_location"] = $_POST["host_location"];
	
	
	if($host->add_host($db_conn, $user_input)){
		echo $codeformat->generate_alert("success", "Host added succesfully.");
	}else{
		echo $codeformat->generate_alert("error", "Host could not be added to database.");
	}
}

if(isset($_GET["id"]) && isset($_GET["cfirmdelete"]) && $_GET["cfirmdelete"] == "deletesites"){

  $user_input = array();
  $user_input["id"] = $id;
  
  if($host->host_delete($db_conn,$user_input)){
    echo $codeformat->generate_alert("success", "Host and sites deleted succesfully.");
  }else{
    echo $codeformat->generate_alert("error", "Host or sites could not be deleted from database.");
  }
  
}elseif(isset($_GET["id"]) && isset($_GET["cfirmdelete"]) && $_GET["cfirmdelete"] == "moveanddelete"){
  $user_input = array();
  $user_input["id"] = $id;
  $user_input["new_host"] = $_POST["host"];
  
  if($host->host_moveanddelete($db_conn,$user_input)){
    echo $codeformat->generate_alert("success", "Host deleted and sites moved succesfully.");
  }else{
    echo $codeformat->generate_alert("error", "ERROR delete host or moving sites.");
  }
  
}elseif(isset($_GET["id"]) && isset($_GET["dlte"])){
	?>
  What do you want to do with the websites link to this host?<br/><br/><br/>
  <a href='hosts.php?id=<?php echo $id;?>&cfirmdelete=deletesites' class='action-links'>DELETE</a><br/><br/> OR <br/>
  <form action="hosts.php?id=<?php echo $id;?>&cfirmdelete=moveanddelete" method="post">
    <select id="host" name="host">
      <?php $hosting_accounts = $main->list_hosts($db_conn); echo $codeformat->sort_hosts($hosting_accounts); ?>
    </select>
    <input type="submit" name="moveanddelte" value="MOVE SITES AND DELETE HOST" class="moveanddelete" style="float:none;">
  </form>
  <?php
}

?>
<script>
	function validateForm(){
		var a = document.forms["add_new"]["host_name"].value;
		var b = document.forms["add_new"]["host_location"].value;
		var cntr = '0';
		
		if ( a == null || a == "" ) {
 			$("#host_name").toggleClass("try_again");
      cntr++;
		}
			 
		if ( a == null || a == "" ) {
 			$("#host_location").toggleClass("try_again");
      cntr++;
		}
		
		if (cntr > 0) {
			return false;
		}
		
	}
</script>
			
			<h2>Hosts</h2>
			<div class="container">
				<div class="container_header">
					<div class="container_header_left">ADD HOST</div>
					<div class="container_header_right" style="font-size:19px; font-weight:bold;">+</div>
					<div class="clear"></div>
				</div>
				<div class="container_main">
				<form action="hosts.php" method="post" name="add_new">

					<div class="input_title">Hosting Account Name</div> <input type="text" name="host_name" id="host_name">
					<div class="clear"></div>
					<div class="input_title">Backup Script URL</div> <input type="text" name="host_location" id="host_location">
					<div class="clear"></div>
					
					<input type="submit" name="submit" id="submit" value="Submit Host">
					<div class="clear"></div>
				</form>
				</div>
				</div>
				<table class="sites-table">
					<thead>
						<tr>
							<td>ID #</td>
							<td>Host Name</td>
							<td>Backup URL</td>
							<td>Actions</td>
						</tr>
					</thead>
					<tbody>
					<?php
	          $hostArray = $host->select_hosts($db_conn, $user_input);		
	
						
						foreach($hostArray as $host){
							echo 
							"<tr>
								<td> ".$host['id']."</td>
								<td> ".$host['host_name']."</td>
								<td> ".$host['host_location']."</td>
								<td><a href='edit_host.php?id=".$host['id']."' class='action-links'>EDIT</a> <a href='hosts.php?id=".$host['id']."&dlte=cfrm' class='action-links'>DELETE</a></td>
							</tr>";
						}
						
					?>	
					</tbody>	
				</table>
			
<?php require "assets/footer.php"; ?>