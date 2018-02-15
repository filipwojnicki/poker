<?php

//error_reporting(0);

require 'classes/card.php';
require 'classes/hand.php';
require '../config.php';
include 'checkGame.php';

$hand = new Hand;

$myData = json_decode($_POST['myData']);

if(isset($myData) && $myData != ""){

	$table_name = $myData->tableName;

	$p1 = $hand->getHand();
	$p2 = $hand->getHand();
	
	$p1card1 = $p1->card1->color.".".$p1->card1->symbol;
	$p1card2 = $p1->card2->color.".".$p1->card2->symbol;

	$p2card1 = $p2->card1->color.".".$p2->card1->symbol;
	$p2card2 = $p2->card2->color.".".$p2->card2->symbol;

	$tcard1 = getNewCard();
	$tcard2 = getNewCard();
	$tcard3 = getNewCard();
	$tcard4 = getNewCard();
	$tcard5 = getNewCard();

	$table->card1 = $tcard1;
	$table->card2 = $tcard2;
	$table->card3 = $tcard3;
	$table->card4 = $tcard4;
	$table->card5 = $tcard5;

	$tablecard1 = $tcard1->color.".".$tcard1->symbol;
	$tablecard2 = $tcard2->color.".".$tcard2->symbol;
	$tablecard3 = $tcard3->color.".".$tcard3->symbol;
	$tablecard4 = $tcard4->color.".".$tcard4->symbol;
	$tablecard5 = $tcard5->color.".".$tcard5->symbol;

	$game_token = rand(100000000000000000, 999999999999999999999);

	$p1_result = checkGame($p1, $table);
	$p2_result = checkGame($p2, $table);

	try{
		$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbusr, $dbpass);

		$sql = $db->prepare("INSERT INTO poker.table (player1, p1_card1, p1_card2, p1_result, p2_card1, p2_card2, p2_result, table_card1, table_card2, table_card3, table_card4, table_card5, game_token, table_name)
					 VALUES (:player1name, '$p1card1', '$p1card2', '$p1_result','$p2card1', '$p2card2', '$p2_result', '$tablecard1', '$tablecard2', '$tablecard3', '$tablecard4', '$tablecard5', '$game_token', :table_name)
					");

		$sql->execute([
			'table_name' => $table_name,
			'player1name' => 'John',
		]);

		var_dump(http_response_code(201));
		echo "OK";

	}catch(PDOException $e){
		var_dump(http_response_code(404));
		die("FALSE");
	}

	$db = null;
}else{
	var_dump(http_response_code(404));
	die("FALSE");
}





