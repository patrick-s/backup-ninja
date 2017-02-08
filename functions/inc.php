<?php
require "dbconfig.php";
require "class_main.php";
require "class_user.php";
require "class_host.php";
require "class_codeformat.php";
require "array_words.php";

// Start Classes
global $main;
$main = new main;
$codeformat = new codeformat;
$user = new user;
$login = new login;

session_start();

$session_input["user_name"] = $_SESSION["fbp_us"];
$session_input["user_password"] = $_SESSION["fbp_ps"];

if($page != "login"){
  if(!$login->check_user($db_conn, $session_input)){
    header("LOCATION: login.php");
  }
}else{
  if($login->check_user($db_conn, $session_input)){
    header("LOCATION: index.php");
  }
}

?>