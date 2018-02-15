<?php
header("Content-Type: application/json; charset=UTF-8");
error_reporting(0);

require '../config.php';

$con=mysqli_connect($dbhost, $dbusr, $dbpass, $dbname);

$rows = array();

if(mysqli_connect_errno())
	die();

$sql = "SELECT id, game_token, table_name FROM `table` where completed = 0 and player2 = '' or player2 = NULL ";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
	$i = 0;
    while($row = mysqli_fetch_assoc($result)){
    	$rows[] = $row;
    }
    echo json_encode($rows);
}

mysqli_close($con);