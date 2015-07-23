<?php
session_start();

require("../../site_includes/php/constants.php");
//comment
require("../../site_includes/php/log_to_database.php");

//SQLinject zastita
$HS_NAME = str_replace("'","",$_REQUEST['data']);
$HS_NAME = str_replace("\"","",$HS_NAME);
$HS_NAME = str_replace("(","",$HS_NAME);
$HS_NAME = str_replace(")","",$HS_NAME);

$HS_PORT = intval ($_REQUEST['p']);

$qry = "SELECT IP FROM ip_refresh WHERE hs_name = '".$HS_NAME."'";
$res = mysql_query($qry);

if(mysql_num_rows($res) == 0){
	$qry1 = "INSERT INTO ip_refresh (IP,port,updated,hs_name) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$HS_PORT."',NOW(),'".$HS_NAME."')";
	if(!mysql_query($qry1)){
		echo "false";
	}else{
		echo "true";
	}
}else{
	$qry2 = "UPDATE ip_refresh SET IP = '".$_SERVER['REMOTE_ADDR']."', port = '".$HS_PORT."', updated = NOW() WHERE hs_name = '".$HS_NAME."'";
	if(!mysql_query($qry2)){
		echo "false";
	}else{
		echo "true";
	}	
}
?>
