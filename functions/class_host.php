<?php

class host{
	// Add Host to Database
	public function add_host($db_conn, $user_input){
	
		$sql_write = "INSERT INTO hosts (host_name, host_location)
                            VALUES(?,?)";
    		$prep_sql = $db_conn->prepare($sql_write);
    		$prep_sql->bind_param("ss", $host_name, $host_location);

		$host_name = $user_input["host_name"];
		$host_location = $user_input["host_location"];
		
		if($prep_sql->execute()){
			$prep_sql->close();
			return true;
		} else {
			$prep_sql->close();
			return false;
		}
		}


		// Select Hosts From Database
		public function select_hosts($db_conn, $user_input){
        
	        $sql_parms = "id, host_name, host_location";
	        $sql_select = "SELECT " . $sql_parms . " FROM hosts ORDER BY host_name ASC";
	
	        $prep_sql = $db_conn->query($sql_select);
	
	        $host_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
	            $host_array[$countr]["id"] = $row["id"];
	            $host_array[$countr]["host_name"] = $row["host_name"];
	            $host_array[$countr]["host_location"] = $row["host_location"];
	            $countr++;
	        }
	        $prep_sql->free();
	
	        return $host_array;
		}
		
		
		// Grab Information from Specific Host
		public function host_information($db_conn, $user_input){
			$sql_parms = "id, host_name, host_location";
			$sql_select = "SELECT " . $sql_parms . " FROM hosts WHERE id='" . $user_input['id'] . "'";

			$prep_sql = $db_conn->query($sql_select);

			$host_array = array();
			$countr = 0;

			while ($row = $prep_sql->fetch_assoc()) {
					$host_array["id"] = $row["id"];
					$host_array["host_name"] = $row["host_name"];
					$host_array["host_location"] = $row["host_location"];
			}

			$prep_sql->free();

			return $host_array;
		}
		
		// Update host Information
		public function host_update($db_conn, $user_information){
			
			$sql_update[] = "UPDATE hosts SET host_name='" . $user_information['host_name'] . "' WHERE id='" . $user_information['id'] . "'";	
			$sql_update[] = "UPDATE hosts SET host_location='" . $user_information['backup_url'] . "' WHERE id='" . $user_information['id'] . "'";

			foreach($sql_update as $sql_update_statement){
				$prep_update = $db_conn->prepare($sql_update_statement);
				if($prep_update->execute()){
				}else{
					return false;
				}
				$prep_update->close();
			}

			return true;
		}
		
		// Delete host and all websites under it
		public function host_delete($db_conn, $user_input){
			$sql_update = "DELETE FROM hosts WHERE id='" . $user_input['id'] . "'";
			$prep_update = $db_conn->prepare($sql_update);
			if($prep_update->execute()){
				$prep_update->close();
				$sql_update = "DELETE FROM sites WHERE hosting='" . $user_input['id'] . "'";
				$prep_update = $db_conn->prepare($sql_update);
				if($prep_update->execute()){
					$prep_update->close();
					return true;
				}else{
					$prep_update->close();
					return false;
				}
			}else{
				$prep_update->close();
				return false;
			}
		}
	
	// Delete host and move all websites under it
	public function host_moveanddelete($db_conn, $user_input){
		$sql_delete = "DELETE FROM hosts WHERE id='" . $user_input['id'] . "'";
		$prep_delete = $db_conn->prepare($sql_delete);
		if($prep_delete->execute()){
			$prep_delete->close();
			
			$sql_update = "UPDATE sites SET hosting='" . $user_input["new_host"] . "' WHERE hosting='" . $user_input['id'] . "'";

			$prep_update = $db_conn->prepare($sql_update);
			if($prep_update->execute()){
				$prep_update->close();
				return true;
			}else{
				$prep_update->close();
				return false;
			}
		}else{
			$prep_update->close();
			return false;
		}
	}
}

?>