<?php

error_reporting(0);

if(isset($_POST["table_id"]) && isset($_POST["game_token"])){

	if(checkGameToken($_POST["table_id"], $_POST["game_token"])){
		echo 'OK';
	}else{
		die("FALSE");
	}
	
	unset($_POST["table_id"]);
	unset($_POST["game_token"]);
}



function checkGameToken($table_id, $game_token){

	require '../config.php';

	$db_token;

	if(is_numeric($table_id) && is_numeric($game_token) && isset($table_id) && isset($game_token)){

		$con=mysqli_connect($dbhost, $dbusr, $dbpass, $dbname);

		if(mysqli_connect_errno())
			die("FALSE");

		$sql = "SELECT game_token FROM `table` where id='$table_id' ";
		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) > 0) {
			$i = 0;
		    while($row = mysqli_fetch_assoc($result)){
		    	$db_token = $row[game_token];
		    }

		    if($game_token == $db_token){
		    	return true;
		    }else{
		    	return false;
		    }

		}else{
			return false;
		}

	}else{
		return false;
	}

	mysqli_close($con);
}

