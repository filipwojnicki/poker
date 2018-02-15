<meta charset="utf-8">

<?php

require '../config.php';
include 'checkGameToken.php';

if(isset($_GET['id']) && isset($_GET['token']) && $_GET['id'] != "" && $_GET['token'] != "" && is_numeric($_GET['id']) && is_numeric($_GET['token'])){

	if(checkGameToken($_GET['id'], $_GET['token'])){
		
		try{
			$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbusr, $dbpass);

			$sql = $db->prepare("UPDATE poker.table SET player2 = :player2 where id = :id LIMIT 1");

			$sql->execute([
				'player2' => 'Filip',
				'id' => $_GET['id'],
			]);

			if($sql->rowCount() >= 1){
				// SUKCES
				header("Location: ../#tables");
			}else{
				echo 'Błąd dołączenia. Przekierowanie za 5 sekund.';
				header("refresh:5;url=../#tables");
			}

		}catch(PDOException $e){
			echo 'Błąd dołączenia. Przekierowanie za 5 sekund.';
			header("refresh:5;url=../#tables");
		}

	$db = null;

	}else{
		echo 'Błąd dołączenia. Przekierowanie za 5 sekund.';
		header("refresh:5;url=../#tables");
	}
}else{
	echo 'Błąd dołączenia. Przekierowanie za 5 sekund.';
	header("refresh:5;url=../#tables");
}