<?php require "assets/header.php"; ?>

			<h2>Welcome to the Backup Dashboard</h2>
			<p>Cron has been shutoff until FTP is working and script is needed. To renable the cron, go to Cron Jobs in cPanel. On the drop down select Once Per Day (0 0 * * *) and use the command</p>
			<div class="cron-command">php /home/yourcpanelusername/script_location/functions/cron.php</div>
			<div class="instructions">
				<div class="instructions-head">
					<div class="instructions-head-text">Sites</div>
				</div>
				<div class="instructions-body">
					<p>
						To add a site you go to sites and then click on "ADD SITE." All information on the left side is required. Only fill in the FTP information if you want the backup to be sent to a different server then the default one.<br/><br/> To edit a site just click on the edit button next to each one.<br/><br/> Suspending a website will stop all backups for that website until activated again.<br/><br/></p>
						<ul>
							<li><b>Site URL:</b> Identifier for the website.</li>
							<li><b>cPanel Username/Password:</b> Login used for that websits cPanel.</li>
							<li><b>cPanel URL:</b> URL used to login to that cPanel.</li>
							<li><b>cPanel Host:</b> Where the cPanel is hosted (If not listed add it to a new one in Hosts).</li>
							<li><b>cPanel Theme:</b> In case the cPanel host does not have X3 installed, used paper latern.</li>
							<li><b>Backup Schedule:</b> How often the websites is backed up (Monthly, bi-weekly, or weekly).</li>
							<li><b>FTP Host:</b> URL/IP of the FTP server</li>
							<li><b>FTP Port:</b> Port used on the FTP server</li>
							<li><b>FTP Username/Password:</b> Login Information for FTP</li>
							<li><b>Save Location:</b> Full path the location of where backups will be stored. (Must already exist on the server.)</li>
						</ul>
				</div>
			</div>

			<div class="instructions">
				<div class="instructions-head">
					<div class="instructions-head-text">Users</div>
				</div>
				<div class="instructions-body">
					<p>
						To add a user you go to to users and then click on "ADD USER." All information is required.<br/><br/> To edit a user just click on the edit button next to each one.<br/><br/> Deleting a user will delete them from the databse, they will need to be added again in order for them to login.<br/><br/>Suspending a user will not allow them to login.<br/><br/></p>
						<ul>
							<li><b>Username:</b> Username used for logging into the script.</li>
							<li><b>Password:</b> User password used for logging into the script.</li>
							<li><b>Permission Level:</b> What they can view and do on the backup script. <b>*</b></li>
							<li><b>Level - Read:</b> Can view what websites are on the backup script.</li>
							<li><b>Level - Read/Add:</b> Can view and add websites to the backup script.</li>
							<li><b>Level - Admin:</b> Can view and add users and websites to the backup script. Along with editing the configuration.</li>
						</ul>
					<br/>
					<p>
						<b> * </b> Permissions are not configured yet, so everyone is an admin.
					</p>
				</div>
			</div>

			<div class="instructions">
				<div class="instructions-head">
					<div class="instructions-head-text">Hosts</div>
				</div>
				<div class="instructions-body">
					<p>
						To add a hosts you go to to hosts and then click on "ADD HOST." All information is required.<br/><br/> To edit a host just click on the edit button next to each one.<br/><br/> Deleting a host will delete them from the databse, you will be given an option to remove all sites with the host or to move them to a new host.<br/><br/></p>
						<ul>
							<li><b>Host Name:</b> Used to idetify the host.</li>
							<li><b>Backup Script URL:</b> Location of the backup script on that host. Must be available from the web.</li>
						</ul>
					<br/>
					<p>
						In order to install the backup script on a new host you must create a new account on the hosts cPanel.  <a href="assets/backup_script.zip">Download this package</a> and unzip in the public_html. You can check if the script is working by going to our <a href="check_host.php">host test page</a>.
					</p>
				</div>
			</div>

			<div class="instructions">
				<div class="instructions-head">
					<div class="instructions-head-text">Configuration</div>
				</div>
				<div class="instructions-body">
					<p>
						To edit the configuration page you must be an admin.<br/><br/></p>
						<ul>
							<li><b>Backup Limit:</b> This will limit how many backups are done each night. Only limits the ones marked for monthly backups.</li>
							<li><b>Notification E-Mail:</b> All e-mails from the automatic backup script will be sent to this e-mail.</li>
							<li><b>Exclude Days By Name:</b> All e-mails from the automatic backup script will be sent to this e-mail.</li>
							<li><b>Exclude Days by Number:</b> All e-mails from the automatic backup script will be sent to this e-mail.</li>
							<li><b>FTP Defaults:</b> These FTP defaults will change for all websites that do not have a custom FTP set.</li>
							<li><b>FTP Host:</b> URL/IP of the FTP server</li>
							<li><b>FTP Port:</b> Port used on the FTP server</li>
							<li><b>FTP Username/Password:</b> Login Information for FTP</li>
							<li><b>Save Location:</b> Full path the location of where backups will be stored. (Must already exist on the server.)</li>
						</ul>
					<p>
						Quick Actions<br/><br/>
					</p>
					<ul>
							<li><b>Reset Cycle:</b> This will reset the monthly, weekly, and bi-weekly backup cycle. That means that every website will be backedup again.</li>
							<li><b>Clear Error Logs:</b> This will clear all of the errors in the error log page.</li>
						</ul>
					
				</div>
			</div>
			<div class="clear"></div>
				
				
			
		<?php require "assets/footer.php"; ?>