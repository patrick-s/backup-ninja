<?php require "assets/header.php"; ?>
			
			<h2>Error Log</h2>
				<table class="sites-table">
					<thead>
						<tr>
							<td>Site</td>
							<td>Error</td>
							<td>Date Logged</td>
						</tr>
					</thead>
					<tbody>
					<?php
	          $errors_logged = $main->errors_logged($db_conn, $user_input);		
	
						
						foreach($errors_logged as $error_logged){
							if($error_logged["error"] != "" || !empty($error_logged["error"])){
								echo 
								"<tr>
									<td> " . $error_logged['site_url'] . "</td>
									<td> ".$error_logged['error']."</td>
									<td> " . $codeformat->reconstruct_date('Y-m-d', 'm/d/Y', $error_logged['error_date']) . " </td>
								</tr>";
							}
						}
						
					?>	
					</tbody>	
				</table>
			
<?php require "assets/footer.php"; ?>