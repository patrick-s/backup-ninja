<?php
class quickactions{
  public function quick_actions($db_conn, $user_input){
    
    switch($user_input["qa"]){
      case "reset_cycle":
        return $this->reset_cycle($db_conn);
        break;
      case "clear_log":
        return $this->clear_log($db_conn);
      default:
        return false;
    }
    
  }
  
  private function reset_cycle($db_conn){
    $sql_update = "UPDATE sites SET comp_cycle='0'";
		
		$prep_update = $db_conn->prepare($sql_update);
		if($prep_update->execute()){
			$prep_update->close();
			return true;
		}else{
			$prep_update->close();
			return false;	
		}
  }
  
  private function clear_log($db_conn){
    $sql_update = "DELETE FROM errors";
		
		$prep_update = $db_conn->prepare($sql_update);
		if($prep_update->execute()){
			$prep_update->close();
			return true;
		}else{
			$prep_update->close();
			return false;	
		}
  }
  
}
?>