<?php

class user{
	public function random_id_generator($username){

		// Not the best way to do it, but it'll work. If there are any complaints about this script please.
		$username_length = strlen($username);
		$username_random = rand(1,$username_length);
		$username_divided = $username_length / $username_random;
		$username_rounded = round($username_divided, 0, PHP_ROUND_HALF_UP);
		$random_number = rand(5786,761372);
		$whole_number = $username_length + $username_rounded + $random_number;
		$time_unix = date(U);
		$whole_divided = $time_unix / $whole_number;
		$whole_rounded = round($whole_divided,0,PHP_ROUND_HALF_UP);
		$id = $time_unix + $whole_rounded;
		$first_random = substr($random_number, 0, 2);
		$second_random = substr($id, 6);

		$id = $first_random . $second_random;

		return $id;
	}
	
	// Add user to Database
	public function add_user($db_conn, $user_input){
		$user_id = $this->random_id_generator($user_input["user_name"]);
		$sql_write = "INSERT INTO users (user_id, user_name, user_password, user_permission_level, user_active)
                            VALUES(?,?,?,?, 1)";
    		$prep_sql = $db_conn->prepare($sql_write);
    		$prep_sql->bind_param("issi", $u_id, $user_name, $user_password, $user_permission_level);
		
		$u_id = $user_id;
		$user_name = $user_input["user_name"];
		$user_password = hash("sha256", $user_input["user_password"]);
		$user_permission_level = $user_input["user_permission_level"];
		
		if($prep_sql->execute()){
			$prep_sql->close();
			return true;
		} else {
			$prep_sql->close();
			return false;
		}
		}


		// Select Users From Database
		public function select_users($db_conn, $user_input){
        
	        $sql_parms = "user_id, user_name, user_permission_level, user_active";
	        $sql_select = "SELECT " . $sql_parms . " FROM users ORDER BY user_name ASC";
	
	        $prep_sql = $db_conn->query($sql_select);
	
	        $user_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
	            $user_array[$countr]["user_id"] = $row["user_id"];
	            $user_array[$countr]["user_name"] = $row["user_name"];
	            $user_array[$countr]["user_permission_level"] = $row["user_permission_level"];
							$user_array[$countr]["user_active"] = $row["user_active"];
	            $countr++;
	        }
	        $prep_sql->free();
	
	        return $user_array;
		}
		
		
		// Grab Information from Specific User
		public function user_information($db_conn, $user_input){
		$sql_parms = "user_id, user_name, user_permission_level, user_active";
	        $sql_select = "SELECT " . $sql_parms . " FROM users WHERE user_id='" . $user_input['user_id'] . "'";
	
	        $prep_sql = $db_conn->query($sql_select);
	
	        $user_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
	            $user_array["user_id"] = $row["user_id"];
	            $user_array["user_name"] = $row["user_name"];
	            $user_array["user_permission_level"] = $row["user_permission_level"];
							$user_array["user_active"] = $row["user_active"];
	        }

	        $prep_sql->free();
	
	        return $user_array;
		}
		
		// Update user Information
		public function user_update($db_conn, $user_information){
			
			$sql_update[] = "UPDATE users SET user_name='" . $user_information['user_name'] . "' WHERE user_id='" . $user_information['user_id'] . "'";
			
			if(!empty($user_information["user_password"])){
				$user_password = hash("sha256", $user_information['user_password']);
				$sql_update[] = "UPDATE users SET user_password='" . $user_password . "' WHERE user_id='" . $user_information['user_id'] . "'";
			}

			$sql_update[] = "UPDATE users SET user_permission_level='" . $user_information['user_permission_level'] . "' WHERE user_id='" . $user_information['user_id'] . "'";

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
		
		// Activate or Suspend user
		public function user_active($db_conn, $user_input){
			$sql_update = "UPDATE users SET user_active='" . $user_input['updateto'] . "' WHERE user_id='" . $user_input['user_id'] . "'";
	        	$prep_update = $db_conn->prepare($sql_update);
	        	if($prep_update->execute()){
	        		$prep_update->close();
	        		return true;
	        	}else{
	        		$prep_update->close();
	        		return false;
	        	}
		}
	
	// Delete user
	public function user_delete($db_conn, $user_input){
		$sql_update = "DELETE FROM users WHERE user_id='" . $user_input['user_id'] . "'";
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

class login{
	public function check_user($db_conn, $user_input){
		if(!$user_input['user_name'] && empty($user_input['user_name'])){	
			return false;
		}
		
		if(!$user_input['user_password'] && empty($user_input['user_password'])){
			return false;
		}
		
		$sql_params = "count(user_id)";
    $sql_select = "SELECT " . $sql_params ." FROM users WHERE user_name='" . $user_input['user_name'] ."' AND user_password='" . $user_input['user_password'] . "' AND user_active='1'";
		
    $prep_sql = $db_conn->query($sql_select);
		$results = $prep_sql->fetch_array();
		
		if($results[0] == 1){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function login_user($user_input){
		$_SESSION["fbp_us"] = $user_input["user_name"];
		$_SESSION["fbp_ps"] = $user_input["user_password"];
		
		if($_SESSION["fbp_us"] && $_SESSION["fbp_ps"]){
			return true;
		}else{
			return false;
		}
		
	}
	
}

?>