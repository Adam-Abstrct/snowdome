<?php
date_default_timezone_set("Europe/London");
ini_set( 'date.timezone', 'Europe/London' );

// set up basic connection
$conn_id = ftp_connect("ftp.lightsource-re.co.uk") or die("Could not connect to $ftp_server");
$login_result = ftp_login($conn_id, "asldashboard", "ieC5phieeebei2Ni");
$contents = ftp_nlist($conn_id, ".");

$now = date('YmdH');
// We only get the first part of the minute variable as the
// regex picks up the rest below!
$minute_start = (date('i') >= 30 ? "3" : "0" );

$pattern = "/^[0-9a-zA-Z\-\_]+{$now}{$minute_start}[0-9]{3}\.csv/";

$results = preg_grep($pattern, $contents);
if ($results) {
  $filenames = array_values($results);
  $filename = $filenames[0];

  ob_start();
  $file = ftp_get($conn_id, "php://output", $filename, FTP_BINARY);
  $file_contents = ob_get_contents();
  ob_end_clean();


  $install_id_pattern = "/^.*\b10067001\b.*$/m";
  preg_match($install_id_pattern, $file_contents, $row_matches);
  if ($row_matches && count($row_matches) == 1) {
    $generation_data = explode(",", $row_matches[0]);
    $todays_generation_watts = $generation_data[3];
    $todays_generation = $todays_generation_watts /1000;
    echo $todays_generation. "kWh";
    die();
  }
} else {
  echo "No preg_grep matches...";
  die();
}
