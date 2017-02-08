<?php

class checkhost{
  public function check_hosting($user_input){
    $curloutput = $this->contact_host($user_input["hosting_url"]);
    return $this->check_out_results($curloutput);
  }
  
  private function contact_host($hosting_url){

		$data = array(
			'run_check' => true
		);

		$handle = curl_init($hosting_url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		$curloutput = curl_exec($handle);

		return $curloutput;
  }
  
  private function check_out_results($curl_results){
    if (strpos($curl_results, "success20167789")){
      return true;
    }
		
		return false;
  }
  
}

?>