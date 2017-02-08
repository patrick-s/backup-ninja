<?php require "functions/inc.php"; ?>
<!doctype html>
<html lang="en">
<head>

	<title>Website Backup Script</title>
	<meta charset="utf-8">
	
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
	
<script> 
$(document).ready(function(){
    $(".container_main").hide();
    $(".container_header").click(function(){
        $(".container_main").slideToggle("slow");
    });
});
	
	function site_information(site_id){
		console.log(site_id);
		
		var the_site_id = "hidden-" + site_id;
		var view_type = document.getElementById(the_site_id).style.display;
		
		if(view_type == "table-row"){
			document.getElementById(the_site_id).style.display = "none";
		}else{
			document.getElementById(the_site_id).style.display = "table-row";
		}

	}
</script>
	
</head>

<body>
<div id="wrapper">
	<header>
		<div id="headtext">
			<h1>Backup Ninja</h1>
			<h2> - Website backup dashboard.</h2>
			<div class="clear"></div>
		</div>
	</header>

		<nav>
			<ul>
				<li> <a href="index.php"> <div class="navlink"> HOME </div> </a> </li>
				<li> <a href="sites.php"> <div class="navlink"> SITES </div> </a> </li>
				<li> <a href="users.php"> <div class="navlink"> USERS </div> </a> </li>
				<li> <a href="hosts.php"> <div class="navlink"> HOSTS </div> </a> </li>
				<li> <a href="err_log.php"> <div class="navlink"> ERROR LOGS </div> </a> </li>
				<li> <a href="configuration.php"> <div class="navlink"> CONFIGURATION </div> </a> </li>
			</ul>
			<div class="clear"></div>
		</nav>
	
	<main>
		<div class="maintext">