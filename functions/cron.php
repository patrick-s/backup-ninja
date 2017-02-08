<?php
//Require functions files and database
require_once("inc.php");
require_once("class_backup.php");

$date_whole = date("m/d/Y");
echo "Beacon Backup Ninja " . $date_whole . "\n\n\n";

// Start Classes
$backup = new backup;
$config = $main->configuration($db_conn);

// Set Viarables
$excluded = false;
$defaults["ftp_default_host"] = $config["ftp_default_host"];
$defaults["ftp_default_username"] = $config["ftp_default_username"];
$defaults["ftp_default_password"] = $config["ftp_default_password"];
$defaults["ftp_default_port"] = $config["ftp_default_port"];
$defaults["ftp_default_destination"] = $config["ftp_default_destination"];
$defaults["backup_limit"] = $config["backup_limit"];
$defaults["notify_email"] = $config["notify_email"];

// Seperate exclusion days and numbers into arrays
$exclude_days = explode(",", $config["exclusion_days"]);
$exclude_days_num = explode(",", $config["exclusion_days_num"]);

// Grab Day by Number and Name
$day_num = date(j);
$day_name = date(l);
$day_of_week = date(w);
$week_num = date(W);
$days_in_month = date(t);
$day_in_week = date(N);

//Convert Day Name to Lower Case
$day_name = strtolower($day_name);

// -----------------------------
// Start Running Operations
// -----------------------------

// Reset Cycles if a new cycle is up
if($day_num == 1){
  if($backup->reset_cycle($db_conn, 0)){
    echo "Monthly Cycle has been reset.\n\n";
  }else{
    echo "There was an error resetting the monthly cycle.\n\n";
  }
}

if($day_of_week == 0){
  if($backup->reset_cycle($db_conn, 2)){
    echo "Weekly Cycle has been reset.\n\n";
  }else{
    echo "There was an error resetting the weekly cycle.\n\n";
  }
}

if($day_num == 1 || $day_num == 15){
  if($backup->reset_cycle($db_conn, 1)){
    echo "Bi-weekly Cycle has been reset.\n\n";
  }else{
    echo "There was an error resetting the bi-weekly cycle.\n\n";
  }
}

// Check for exclusions before running the script.
foreach($exclude_days as $day_n){
  if($day_name == $day_n){
    $excluded = true;
  }
}

foreach($exclude_days_num as $day_nu){
  if($day_num == $day_nu){
    $excluded = true;
  }
}

// Check if exclusion on today
if(!$excluded){
  
  // Count how many websites to backup per day.
  if($defaults["backup_limit"] == 0){
    $number_of_websites_daily = $backup->number_sites($db_conn, true, 0);
    $days_left_month = ($days_in_month + 1) - $day_num;
    if($days_left_month > $number_of_websites_daily){
      $backup_limit_daily = 1;
    }else{
      $days_divided_websites = $number_of_websites_daily / $days_left_month;
      $backup_limit_daily = round($days_divided_websites, 0, PHP_ROUND_HALF_UP);
    }
    
    if($number_of_websites_daily == 0){
      $backup_limit_daily = 0;
    }
  }else{
    $backup_limit_daily = $defaults["backup_limit"];
  }
  
  
  // Count how many websites to backup biweekly
  $number_of_websites_biweekly = $backup->number_sites($db_conn, true, 1);
  if($day_num < 15){
    $days_left_biweekly = 15 - $day_num;
  }else{
    $days_left_biweekly = ($days_in_month + 1) - $day_num;
  }
  
  if($days_left_biweekly > $number_of_websites_biweekly){
    $backup_limit_biweekly = 1;
  }else{
    $days_divided_websites_biweekly = $number_of_websites_biweekly / $days_left_biweekly;
    $backups_limit_biweekly = round($days_divided_websites_biweekly, 0, PHP_ROUND_HALF_UP);
  }
  
  if($number_of_websites_biweekly == 0){
    $backups_limit_biweekly = 0;
  }
  
  // Count how many websites to backup weekly
  $number_of_websites_weekly = $backup->number_sites($db_conn, true, 2);
  
  $days_left_weekly = 8 - $day_in_week;
  if($day_in_week > $number_of_websites_weekly){
    $backup_limit_weekly = 1;
  }else{
    $days_divided_websites_weekly = $number_of_websites_weekly / $days_left_weekly;
    $backup_limit_weekly = round($days_divided_websites_weekly, 0, PHP_ROUND_HALF_UP);
  }
  
  if($number_of_websites_weekly == 0){
    $backup_limit_weekly = 0;
  }
  

  
  //Grab websites
  $grab_sites_daily = $backup->grab_sites($db_conn, true, 0, $backup_limit_daily);
  $grab_sites_biweekly = $backup->grab_sites($db_conn, true, 1, $backup_limit_biweekly);
  $grab_sites_weekly = $backup->grab_sites($db_conn, true, 2, $backup_limit_weekly);

  //Run Backups
  echo "Normal/Monthly Backups\n";
  $start_backups_daily = $backup->start_backups($db_conn, $grab_sites_daily, $defaults);
  echo "\n\nBi-Weekly Backups\n";
  $start_backups_biweekly = $backup->start_backups($db_conn, $grab_sites_biweekly, $defaults);
  echo "\n\nWeekly Backups\n";
  $start_backups_weekly = $backup->start_backups($db_conn, $grab_sites_weekly, $defaults);
  
}else{
  echo "Today has been excluded.";
}