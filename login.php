<?php $page = "login"; ?>
<?php require "assets/header.php"; ?>
<?php

if(!$checkUserLogin){

  if(ISSET($_POST["submit_login"])){
    
    // Sanitize Inputs
    $username = filter_input(INPUT_POST, "fbp_username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "fbp_password", FILTER_SANITIZE_STRING);
    
    //HTML entities
    $username = htmlentities($username);
    $password = htmlentities($password);
      
    //Add slashes
    $username = addslashes($username);
    $password = addslashes($password);
    
    //Hash Password
    $password = $user_password = hash("sha256", $password);
    
    //Input information into an array
    $user_input["user_name"] = $username;
    $user_input["user_password"] = $password;
    
    // Start Login Class
    $login = new login;
    
    if($login->check_user($db_conn, $user_input)){
      
      if($login->login_user($user_input)){
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
      }else{
        echo $codeformat->generate_alert("error", "Logging your session, pleaes try again.");
      }
      
    }else{
      echo $codeformat->generate_alert("error", "Logging you in. Please check your information and try again.");
    }
    
  }
  
}else{
  echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
}

?>
<form action="login.php" method="post">
  Username: <input type="text" name="fbp_username" id="fbp_username"><br/><br/>
  Password: <input type="password" name="fbp_password" id="fbp_password"><br/>
  <input type="submit" name="submit_login" id="submit_login" value="Login">
</form>

<?php require "assets/footer.php"; ?>