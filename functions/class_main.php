<?php

class main{
	public function configuration($db_conn){
	  $sql_params = "config_name, config_info";
    $sql_select = "SELECT " . $sql_params ." FROM configs";
    
    $prep_sql = $db_conn->query($sql_select);
	
	        $config_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
							$config_name = $row["config_name"];
	            $config_array[$config_name] = $row["config_info"];
	            $countr++;
	        }
	        $prep_sql->free();
					
					return $config_array;
	}
	
	public function list_hosts($db_conn){
		$sql_params = "id, host_name, host_location";
    $sql_select = "SELECT " . $sql_params ." FROM hosts";
    
    $prep_sql = $db_conn->query($sql_select);
	
	        $host_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
							$host_array[$countr]["host_id"] = $row["id"];
	            $host_array[$countr]["host_name"] = $row["host_name"];
	            $host_array[$countr]["host_location"] = $row["host_location"];
	            $countr++;
	        }
	        $prep_sql->free();
		
		return $host_array;
	}
	
	public function errors_logged($db_conn, $user_input){
		$sql_params = "errors.error_id, errors.site_id, errors.error, errors.error_date, sites.site_url";
    $sql_select = "SELECT " . $sql_params ." FROM errors RIGHT JOIN sites ON errors.site_id = sites.site_id ORDER BY errors.error_id DESC";
    
    $prep_sql = $db_conn->query($sql_select);
	
	        $error_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
							$error_array[$countr]["error_id"] = $row["error_id"];
							$error_array[$countr]["site_id"] = $row["site_id"];
	            $error_array[$countr]["error"] = $row["error"];
							$error_array[$countr]["error_date"] = $row["error_date"];
							$error_array[$countr]["site_url"] = $row["site_url"];
	            $countr++;
	        }
	        $prep_sql->free();
		
		return $error_array;
	}
	
	public function grab_host($db_conn, $host_id){
		$sql_params = "host_name, host_location";
    $sql_select = "SELECT " . $sql_params ." FROM hosts WHERE id='" . $host_id ."'";
    
    $prep_sql = $db_conn->query($sql_select);
	
	        $host_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
	            $host_array["host_name"] = $row["host_name"];
	            $host_array["host_location"] = $row["host_location"];
	            $countr++;
	        }
	        $prep_sql->free();
		
		return $host_array;
	}
	
	public function config_update($db_conn, $user_input){
		$exclusion_days = strtolower($user_input['exclusion_days']);
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['backup_limit'] . "' WHERE config_name='backup_limit'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['notify_email'] . "' WHERE config_name='notify_email'";
		$sql_update[] = "UPDATE configs SET config_info='" . $exclusion_days . "' WHERE config_name='exclusion_days'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['exclusion_days_num'] . "' WHERE config_name='exclusion_days_num'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['ftp_host'] . "' WHERE config_name='ftp_default_host'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['ftp_port'] . "' WHERE config_name='ftp_default_port'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['ftp_username'] . "' WHERE config_name='ftp_default_username'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['ftp_password'] . "' WHERE config_name='ftp_default_password'";
		$sql_update[] = "UPDATE configs SET config_info='" . $user_input['ftp_destination'] . "' WHERE config_name='ftp_default_destination'";

		foreach($sql_update as $sql_update_statement){
			$prep_update = $db_conn->prepare($sql_update_statement);
			$prep_update->execute();
			$prep_update->close();
		}

		return true;
	}
}

class site{

	// Add site to Database
	public function add_site($db_conn, $user_input){

	$sql_write = "INSERT INTO sites (site_url, site_username, site_password, site_host, ftp_username, ftp_password, ftp_host, ftp_port, ftp_destination, comments, backup_schedule, last_backup, backup_active, comp_cycle, cpanel_theme, hosting, fingerprint_uname)
                            VALUES(?,?,?,?,?,?,?,?,?,?,?,0,1,0,?,?,?)";
    $prep_sql = $db_conn->prepare($sql_write);
    $prep_sql->bind_param("sssssssissisis", $site_url, $site_username, $site_password, $site_host, $ftp_username, $ftp_password, $ftp_host, $ftp_port, $ftp_destination, $comments, $backup_schedule, $cpanel_theme, $cpanel_host, $fingerprint_uname);

		$site_url = $user_input["site_url"];
		$site_username = $user_input["site_username"];
		$site_password = $user_input["site_password"];
		$site_host = $user_input["site_host"];
		$ftp_username = $user_input["ftp_username"];
		$ftp_password = $user_input["ftp_password"];
		$ftp_host = $user_input["ftp_host"];
		$ftp_port = $user_input["ftp_port"];
		$ftp_destination = $user_input["ftp_destination"];
		$comments = $user_input["comments"];
		$backup_schedule = $user_input["backup_schedule"];
		$cpanel_theme = $user_input["cpanel_theme"];
		$cpanel_host = $user_input["cpanel_host"];
		$fingerprint_uname = $user_input["fingerprint_uname"];
		
		if($prep_sql->execute()){
			$prep_sql->close();
			return true;
		} else {
			$prep_sql->close();
			return false;
			//should we add $db_conn->close();
		}
		}


		// Select Sites From Database
		public function select_sites($db_conn, $user_input){
        
	        $sql_parms = "site_id, site_url, site_username, site_password, site_host, ftp_username, ftp_password, ftp_host, ftp_port, ftp_destination, comments, backup_schedule, last_backup, backup_active, comp_cycle, cpanel_theme, hosting, fingerprint_uname";
	        $sql_select = "SELECT " . $sql_parms . " FROM sites ORDER BY site_url ASC";
	
	        $prep_sql = $db_conn->query($sql_select);
	
	        $site_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
	            $site_array[$countr]["site_id"] = $row["site_id"];
	            $site_array[$countr]["site_url"] = $row["site_url"];
	            $site_array[$countr]["site_username"] = $row["site_username"];
							$site_array[$countr]["site_password"] = $row["site_password"];
	            $site_array[$countr]["site_host"] = $row["site_host"];
	            $site_array[$countr]["ftp_username"] = $row["ftp_username"];
	            $site_array[$countr]["ftp_password"] = $row["ftp_password"];
	            $site_array[$countr]["ftp_host"] = $row["ftp_host"];
							$site_array[$countr]["ftp_port"] = $row["ftp_port"];
	            $site_array[$countr]["ftp_destination"] = $row["ftp_destination"];
	            $site_array[$countr]["comments"] = $row["comments"];
	            $site_array[$countr]["backup_schedule"] = $row["backup_schedule"];
	            $site_array[$countr]["last_backup"] = $row["last_backup"];
	            $site_array[$countr]["backup_active"] = $row["backup_active"];
						  $site_array[$countr]["comp_cycle"] = $row["comp_cycle"];
						  $site_array[$countr]["cpanel_theme"] = $row["cpanel_theme"];
							$site_array[$countr]["cpanel_host"] = $row["hosting"];
							$site_array[$countr]["fingerprint_uname"] = $row["fingerprint_uname"];
	            $countr++;
	        }
	        $prep_sql->free();
	        //$prep_sql->close();
	
	        return $site_array;
		}
		
		
		// Grab Information from Specific Site
		public function site_information($db_conn, $user_input){
		$sql_parms = "site_id, site_url, site_username, site_password, site_host, ftp_username, ftp_password, ftp_host, ftp_port, ftp_destination, comments, backup_schedule, last_backup, backup_active, comp_cycle, cpanel_theme, hosting, fingerprint_uname";
	        $sql_select = "SELECT " . $sql_parms . " FROM sites WHERE site_id='" . $user_input['site_id'] . "'";
	
	        $prep_sql = $db_conn->query($sql_select);
	
	        $site_array = array();
	        $countr = 0;
	
	        while ($row = $prep_sql->fetch_assoc()) {
	            $site_array["site_id"] = $row["site_id"];
	            $site_array["site_url"] = $row["site_url"];
	            $site_array["site_username"] = $row["site_username"];
					  	$site_array["site_password"] = $row["site_password"];
	            $site_array["site_host"] = $row["site_host"];
	            $site_array["ftp_username"] = $row["ftp_username"];
	            $site_array["ftp_password"] = $row["ftp_password"];
	            $site_array["ftp_host"] = $row["ftp_host"];
							$site_array["ftp_port"] = $row["ftp_port"];
	            $site_array["ftp_destination"] = $row["ftp_destination"];
	            $site_array["comments"] = $row["comments"];
	            $site_array["backup_schedule"] = $row["backup_schedule"];
	            $site_array["last_backup"] = $row["last_backup"];
	            $site_array["backup_active"] = $row["backup_active"];
						  $site_array["comp_cycle"] = $row["comp_cycle"];
						  $site_array["cpanel_theme"] = $row["cpanel_theme"];
							$site_array["cpanel_host"] = $row["hosting"];
							$site_array["fingerprint_uname"] = $row["fingerprint_uname"];
	        }

	        $prep_sql->free();
	        //$prep_sql->close();
	
	        return $site_array;
		}
		
		// Update Website Information
		public function site_update($db_conn, $site_information){
			
			$sql_update[] = "UPDATE sites SET site_url='" . $site_information['site_url'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET site_username='" . $site_information['site_username'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET site_password='" . $site_information['site_password'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET site_host='" . $site_information['site_host'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET ftp_username='" . $site_information['ftp_username'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET ftp_password='" . $site_information['ftp_password'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET ftp_host='" . $site_information['ftp_host'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET ftp_port='" . $site_information['ftp_port'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET ftp_destination='" . $site_information['ftp_destination'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET comments='" . $site_information['comments'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET backup_schedule='" . $site_information['backup_schedule'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET cpanel_theme='" . $site_information['cpanel_theme'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET hosting='" . $site_information['cpanel_host'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			$sql_update[] = "UPDATE sites SET fingerprint_uname='" . $site_information['fingerprint_uname'] . "' WHERE site_id='" . $site_information['site_id'] . "'";
			
			$confignum = 0;
			foreach($sql_update as $sql_update_statement){
				$prep_update = $db_conn->prepare($sql_update_statement);
				$prep_update->execute();
				$prep_update->close();
			}

			return true;
		}
		
		// Update Website Information
		public function site_active($db_conn, $user_input){
			$sql_update = "UPDATE sites SET backup_active='" . $user_input['updateto'] . "' WHERE site_id='" . $user_input['site_id'] . "'";

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