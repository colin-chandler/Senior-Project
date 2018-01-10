<?php
require "/home/cchandlc/adodb5/adodb.inc.php";

function connect()
{
  $host = "localhost";
  $database = "cchandlc_Senior_Project_CARD$";
  $user = "cchandlc_seniorP";
  $password = "supersecretPASSWORD";
  $db = ADONewConnection("mysqli");
  $db->Connect($host, $user, $password, $database);
  return $db;
}
function totalHelp()
{
  $link = mysql_connect("localhost", "cchandlc_seniorP", "supersecretPASSWORD");
  mysql_select_db("cchandlc_Senior_Project_CARD$", $link);
  return $link;
}
function getHeader()
{
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
  echo '<html xmlns="http://www.w3.org/1999/xhtml">';
  echo '<head>';
	echo '<meta charset="utf-8">';
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
  echo '<script src="js/vendor/jquery.1.11.min.js"></script>';
  echo '<script src="js/WOW/dist/wow.min.js"></script>';
  echo '<script src="js/bootstrap.min.js"></script>';
  echo '<!-- Latest compiled and minified CSS -->';
  echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
  echo '<!-- Optional theme -->';
  echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">';
  echo '<!-- Latest compiled and minified JavaScript -->';
  echo '<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"></script>';
  echo '<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
  echo '<link rel="shortcut icon" href="img/favicon.ico"> ';
	echo '<link rel="stylesheet" href="css/vendor/fluidbox.min.css">';
	echo '<link rel="shortcut icon" href="img/tabIcon.jpg">';
  echo '<body>';
  return;
}

function getFooter()
{
  echo '</body>';
  echo '</html>';
  return;
}
?>
