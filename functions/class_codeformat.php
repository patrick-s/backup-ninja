<?php

class codeformat{
	public function last_backup($lbtime){
		if($lbtime != 0){
			return date('h:iA m/d/y',$lbtime);
		}else{
			return "None";
		}
	}
	
	public function backup_schedule($schedule){
		switch($schedule){
			case 1:
				return "Bi-Weekly";
				break;
			case 2:
				return "Weekly";
				break;
			default:
				return "Monthly";
				break;
		}
	}
	
	public function active_button($buactive, $id){
		switch($buactive){
			case 0:
				return "<a href='?active=1&id=" . $id . "' class='action-links'>ACTIVATE</a>";
				break;
			case 1:
				return "<a href='?active=0&id=" . $id . "' class='action-links'>SUSPEND</a>";
				break;
			default:
				return "<a href='?active=1&id=" . $id . "' class='action-links'>ACTIVATE</a>";
				break;
		}
	}
	
	public function backup_active_style($buactive){
		switch($buactive){
			case 0:
				return "site_suspended";
				break;
			case 1:
				return "site_active";
				break;
			default:
				return "site_suspended";
				break;
		}
	}
	
	public function user_permission_level($user_level){
		switch($user_level){
			case 1:
				return "Read/Add";
				break;
			case 2:
				return "Admin";
				break;
			default:
				return "Read";
				break;
		}
	}
	
	public function generate_alert($type, $text){
		if($type == "success"){
			$alert = "<div class='alert'>
				<div class='success-alert'>
					" . $text . "
				</div>
			</div>";
		}else if($type == "error"){
			$alert = "<div class='alert'>
				<div class='error-alert'>
					Error: " . $text . "
				</div>
			</div>";
		}else{
			$alert = "<div class='alert'>
				<div class='error-alert'>
					Error: Unknown
				</div>
			</div>";
		}
		
		return $alert;
	}
	
	public function sort_hosts($hosting_accounts){
		$hosting_list = "";
		foreach($hosting_accounts as $hosting){
			$hosting_list .= "<option value='" . $hosting["host_id"] . "'> " .$hosting["host_name"] . " </option>";
		}
		
		return $hosting_list;
	}
	
	public function reconstruct_date($input_format, $output_format, $date){
		$date = DateTime::createFromFormat($input_format, $date);
		return $date->format($output_format);
	}
}

?>