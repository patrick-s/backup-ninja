<?php require "assets/header.php"; require_once "functions/class_quickactions.php"; ?>

<h2>Configuration</h2>

<?php
  $qa = filter_input(INPUT_GET, "qa", FILTER_SANITIZE_STRING);
  
  if(ISSET($qa)){
    $confirmaction = filter_input(INPUT_POST, "confirmaction", FILTER_SANITIZE_STRING);
    if(ISSET($confirmaction)){
      $quickactions = new quickactions;
      
      $user_input["qa"] = $qa;
      if($quickactions->quick_actions($db_conn, $user_input)){
        $qa_comp = $qa . "_comp";
        echo $codeformat->generate_alert("success", $convert_word[$qa_comp]);
      }else{
        $qa_fail = $qa . "_fail";
        echo $codeformat->generate_alert("error", $convert_word[$qa_fail]);
      }
      
    }else{
      ?>
        <form action="quick_actions.php?qa=<?php echo $qa; ?>" method="post">
          Are you sure you want to <?php echo $convert_word[$qa]; ?>?
          <input type="submit" name="confirmaction" value="Confirm Action" class="action_submit">
        </form>
      <?php
    }
  }
?>
<?php require "assets/footer.php"; ?>