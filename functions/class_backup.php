<?php

class backup{
  
  public function grab_sites($db_conn, $cycle, $backup_schedule, $db_limit){
    $sql_params = "site_id, site_url, site_username, site_password, site_host, ftp_username, ftp_password, ftp_host, ftp_port, ftp_destination, cpanel_theme, hosting";
    $sql_select = "SELECT " . $sql_params ." FROM sites WHERE backup_active='1' AND backup_schedule='" . $backup_schedule . "'";
    if($cycle === true){
      $sql_select = $sql_select . " AND comp_cycle='0'";
    }
		
		if($db_limit){
			$sql_select = $sql_select . " LIMIT 0," . $db_limit;
		}
    
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
							$site_array[$countr]["cpanel_theme"] = $row["cpanel_theme"];
							$site_array[$countr]["hosting"] = $row["hosting"];
	            $countr++;
	        }
	        $prep_sql->free();
		
		return $site_array;
  }
  
	public function number_sites($db_conn, $cycle, $backup_schedule){
    $sql_params = "count(site_id)";
    $sql_select = "SELECT " . $sql_params ." FROM sites WHERE backup_active='1' AND backup_schedule='" . $backup_schedule . "'";
    if($cycle === true){
      $sql_select = $sql_select . " AND comp_cycle='0'";
    }
		
    $prep_sql = $db_conn->query($sql_select);
		$results = $prep_sql->fetch_array();
		return $results[0];
  }
	
	public function start_backups($db_conn, $site_info, $defaults){
		global $main;
		// Run all of the sites listed for Daily
		foreach($site_info as $site){
			echo $site["site_url"] . " ";
			// Check if custom FTP has been set
			if($site["ftp_host"] == "" || empty($site["ftp_host"])){
				$site["ftp_host"] = $defaults["ftp_default_host"];
				$site["ftp_username"] = $defaults["ftp_default_username"];
				$site["ftp_password"] = $defaults["ftp_default_password"];
				$site["ftp_port"] = $defaults["ftp_default_port"];
				$site["ftp_destination"] = $defaults["ftp_default_destination"];
			}
			
			$site["notify_email"] = $defaults["notify_email"];

			$site_host_location = $main->grab_host($db_conn, $site["hosting"]); // Grab Host from DB
			$site["site_host_location"] = $site_host_location["host_location"]; // Grab Script Location
			$run_backup = $this->run_backup($site); // Run the Backup
			
			if($this->check_output_complete($run_backup)){
				
				echo "Backup Completed.\n";
				$input_array["site_id"] = $site["site_id"];
				$this->update_site($db_conn, $input_array);
				
			}else{
				
				$log_error = $this->check_output_errors($run_backup); // Check for errors
				
				// If known error output the error, if not output the code.
				if($log_error){
					echo $log_error . "\n";
					$this->log_error_db($db_conn, $site["site_id"],$log_error);
				}else{
					echo "Unkown error: Please see code below for information:\n\n" . $run_backup . "\n\n\n";
				}
				
			}
			
		}
	}
	
	public function run_backup($script_input){
		
		$logininfo = base64_encode($script_input["site_username"] . ":" . $script_input["site_password"]);

		$data = array(
			'run_script' => true,
			'logininfo' => $logininfo,
			'site_host' => $script_input["site_host"],
			'cpanel_theme' => $script_input["cpanel_theme"],
			'secure_use' => true,
			'ftp_use' => true,
			'ftp_host' => $script_input["ftp_host"],
			'ftp_port' => $script_input["ftp_port"],
			'ftp_username' => $script_input["ftp_username"],
			'ftp_password' => $script_input["ftp_password"],
			'ftp_destination' => $script_input["ftp_destination"],
			'notify_email' => $script_input["notify_email"]
		);
		
		$url = $script_input["site_host_location"];
		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		$curloutput = curl_exec($handle);

		return $curloutput;
	}
	
	public function check_output_complete($curl_return){
		$complete_checklist = array(
			"Full Backup in Progress"
		);
		
		foreach($complete_checklist as $complete_text){
			if (strpos($curl_return, $complete_text)){
				return true;
			}
		}
		
		return false;
	}
	
	public function check_output_errors($curl_return){
		$error_checklist = array(
			"login is invalid.",
			"Fileman::fullbackup",
			"Unable to Create Backup"
		);
		
		foreach($error_checklist as $error_text){
			if (strpos($curl_return, $error_text)){
				return $error_text;
			}
		}
		
		return false;
	}
	
	public function log_error_db($db_conn, $site_id, $log_curl_error){
		$sql_write = "INSERT INTO errors (site_id, error, error_date)
                            VALUES(?,?,?)";
    $prep_sql = $db_conn->prepare($sql_write);
    $prep_sql->bind_param("iss", $siteid, $logcurlerror, $error_date);

		$siteid = $site_id;
		$logcurlerror = $log_curl_error;
		$error_date = date("Y-m-d");
		
		if($prep_sql->execute()){
			$prep_sql->close();
			return true;
		} else {
			$prep_sql->close();
			return false;
		}
		
	}
	
	public function reset_cycle($db_conn, $backup_schedule){
		$sql_update = "UPDATE sites SET comp_cycle='0' WHERE backup_schedule='" . $backup_schedule ."'";
		
		$prep_update = $db_conn->prepare($sql_update);
		if($prep_update->execute()){
			$prep_update->close();
			return true;
		}else{
			$prep_update->close();
			return false;	
		}
	}
	
	private function update_site($db_conn, $user_input){
		$time_unix = date(U);
		$sql_update[] = "UPDATE sites SET last_backup='" . $time_unix . "' WHERE site_id='" . $user_input['site_id'] . "'";
		$sql_update[] = "UPDATE sites SET comp_cycle='1' WHERE site_id='" . $user_input['site_id'] . "'";

		foreach($sql_update as $sql_update_statement){
			$prep_update = $db_conn->prepare($sql_update_statement);
			$prep_update->execute();
			$prep_update->close();
		}

		return true;
	}
	
}

?>