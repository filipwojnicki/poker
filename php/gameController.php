<?php

require '../config.php';
include 'checkGameToken.php';

header("Content-Type: application/json; charset=UTF-8");
error_reporting(0);

$game_data;

$baseData = json_decode($_POST['myData']);

//mysqli
$con=mysqli_connect($dbhost, $dbusr, $dbpass, $dbname);

//pdo
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbusr, $dbpass);

if(mysqli_connect_errno()){
	http_response_code(404);
	die();
}

$result;


// zwrocenie danych gry w postaci danych typu JSON
if(isset($baseData) &&  isset($baseData->id) && isset($baseData->token) && $baseData->id != "" && $baseData->token != "" && is_numeric($baseData->id) && is_numeric($baseData->token)){
	if(getGameData($con, $baseData->id, $baseData->token) !== false){
		http_response_code(201);
		$game_data = getGameData($con, $baseData->id, $baseData->token);
	}else{
		http_response_code(404);
		echo json_encode('game_data2');
	}
}else{
	http_response_code(404);
	echo json_encode('game_data1');
}

// w przypadku podania gry
if(isset($baseData) && $baseData->fold == "fold") {
	if(checkGameToken($baseData->id, $baseData->token)){
		try{
			$sql = $db->prepare("UPDATE poker.table SET completed = '1', win = 'p1' where `id` = :id  ");

			$sql->execute([
				'id' => $baseData->id,
			]);

			if($sql->rowCount() >= 1){
				//http_response_code(201);
			}else{
				http_response_code(404);
			}

			unset($baseData->fold);

		}catch(PDOException $e){
			//http_response_code(404);
		}
	}else{
		http_response_code(404);
	}
}

// gracz gra dalej 
if(isset($baseData) && $baseData->call == "call") {
	if(checkGameToken($baseData->id, $baseData->token)){

		// aktualizujemy rekord w bazie informujacy o gotowosci gracza 2
		try{
			$sql = $db->prepare("UPDATE poker.table SET wait2 = '1' where `id` = ? LIMIT 1 ");

			$sql->execute(array($baseData->id));

		}catch(PDOException $e){
			http_response_code(404);
		}


		// zmienna określająca numer aktualnie rozgrywanej rundy
		$round;
		// decyzja gracza 1 o tym ze uczestniczy w grze dalej
		$wait1;
		// decyzja gracza 2 o tym ze uczestniczy w grze dalej
		$wait2;

		// pobieramy dane dotyczące gotowości i aktualnej rundy
		try{
			$query=$db->prepare("select round, wait1, wait2 from poker.table where id=?");
			$query->execute(array($baseData->id));
			while($row=$query->fetch(PDO::FETCH_OBJ)) {
				$round = $row->round;
				$wait1 = $row->wait1;
				$wait2 = $row->wait2;
			}
		}catch(PDOException  $e ){
			http_response_code(404);
		}

		// ustalenie aktualnej rundy
		if(isset($round) && isset($wait1) && isset($wait2)){
			if($wait1 == 1 && $wait2 == 1){
				if($round >= 1 && $round <= 3){
					if($round < 3)
						$round++;
				}
			}

			try{
				$sql = $db->prepare("UPDATE poker.table SET `round` = :round where `id` = :id LIMIT 1  ");

				$sql->execute([
					'round' => $round,
					'id' => $baseData->id,
				]);

			}catch(PDOException $e){
				http_response_code(404);
			}

			if($round == 3){
				try{
					$sql = $db->prepare("UPDATE poker.table SET `completed` = '1' where `id` = :id LIMIT 1  ");

					$sql->execute([
						'id' => $baseData->id,
					]);

				}catch(PDOException $e){
					http_response_code(404);
				}
			}

		}else{
			http_response_code(404);
		}

		if(isset($baseData) &&  isset($baseData->id) && isset($baseData->token) && $baseData->id != "" && $baseData->token != "" && is_numeric($baseData->id) && is_numeric($baseData->token)){
			if(getGameData($con, $baseData->id, $baseData->token) !== false){
				$game_data = getGameData($con, $baseData->id, $baseData->token);
			}else{
				http_response_code(404);
			}
		}else{
			http_response_code(404);
		}

		unset($baseData->call);
	}else{
		http_response_code(404);
	}
}

// wyświetlenie danych gry w formacie JSON
echo json_encode($game_data);

//zakończenie połączenia mysqli
mysqli_close($con);

//zakończenie połączenia PDO
$db = null;


// zebranie informacji o grze do obiektu game_data i zwrocenie go jesli argument przejdzie warunki 
function getGameData($con, $id, $token){
	if(isset($id) && isset($token) && $id != "" && $token != "" && is_numeric($id) && is_numeric($token)){
		if(checkGameToken($id, $token)){
			$sql = "SELECT * FROM `table` where id='$id' ";
			$result = mysqli_query($con, $sql);

			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)){

					// ---------------- Gracz 1 tworzenie obiektu kart ----------------------------

					$player1->name = $row[player1];

					// Gracz 1 karta 1

					$p1card1 = explode( '.', $row[p1_card1]);

					$card1->color = $p1card1[0];
					$card1->symbol = $p1card1[1];

					$player1->card1 = $card1;

					unset($card1);

					// Gracz 1 karta 2

					$p1card2 = explode( '.', $row[p1_card2]);

					$card2->color = $p1card2[0];
					$card2->symbol = $p1card2[1];

					$player1->card2 = $card2;

					unset($card2);

					// ----------------------- Gracz 2 ------------------------

					$player2->name = $row[player2];

					// Gracz 2 karta 1

					$p2card1 = explode( '.', $row[p2_card1]);

					$card1->color = $p2card1[0];
					$card1->symbol = $p2card1[1];
					
					$player2->card1 = $card1;

					unset($card1);

					// Gracz 2 karta 2

					$p2card2 = explode( '.', $row[p2_card2]);

					$card2->color = $p2card2[0];
					$card2->symbol = $p2card2[1];
					
					$player2->card2 = $card2;

					unset($card2);

					// -------------------------- Karty na stole --------------------------

					// Karta 1

					$tablecard1 = explode( '.', $row[table_card1]);

					$card1->color = $tablecard1[0];
					$card1->symbol = $tablecard1[1];

					$table->card1 = $card1;

					unset($card1);

					// Karta 2

					$tablecard2 = explode( '.', $row[table_card2]);

					$card2->color = $tablecard2[0];
					$card2->symbol = $tablecard2[1];

					$table->card2 = $card2;

					unset($card2);

					// Karta 3

					$tablecard3 = explode( '.', $row[table_card3]);

					$card3->color = $tablecard3[0];
					$card3->symbol = $tablecard3[1];

					$table->card3 = $card3;

					unset($card3);

					if($row[round] >= 2){
						// Karta 4

						$tablecard4 = explode( '.', $row[table_card4]);

						$card4->color = $tablecard4[0];
						$card4->symbol = $tablecard4[1];

						$table->card4 = $card4;

						unset($card4);
					}

					if($row[round] == 3){
						// Karta 5

						$tablecard5 = explode( '.', $row[table_card5]);

						$card5->color = $tablecard5[0];
						$card5->symbol = $tablecard5[1];

						$table->card5 = $card5;

						unset($card5);
					}		

						

					// ------------------------------------ Zebranie wszystkich obiektów w obiekt game_data ------------------------

					$game_data->player1 = $player1;
					$game_data->player2 = $player2;

					$game_data->table = $table;

					if($row[completed] == 1){
						$game_data->msg = $player1->name . ": ". $row[p1_result] . " " . $player2->name . ": ". $row[p2_result];
					}		

				}

				return $game_data;

			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
