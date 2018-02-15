<?php 

// 2 3 4 5 6 7 8 9 10 J Q K A

//echo getNewCard();

function getNewCard() {

	// tworzymy karte przez wylosowanie jej numeru i symbolu z posrod liczb 2-14, 1-4

	// 2 3 4 5 6 7 8 9 10 J Q K A - 13
	//spades, hearts, diamonds, clubs (♠ ♥ ♦ ♣) - 4

	$randCard = mt_rand(2,14);
	$randSymbol = mt_rand(1,4);

	//$card = $randCard . ' ' . $randSymbol;

	$newcard->color = $randCard;
	$newcard->symbol = $randSymbol;

	return $newcard;
}


/*
function getNewCard() {

	// tworzymy karte przez wylosowanie jej numeru i symbolu z posrod liczb 2-14, 1-4

	// 2 3 4 5 6 7 8 9 10 J Q K A - 13
	//spades, hearts, diamonds, clubs (♠ ♥ ♦ ♣) - 4

	$randCard = mt_rand(2,14);
	$randSymbol = mt_rand(1,4);

	//echo $card = $randCard . ' ' . $randSymbol;

	$card->color = $randCard;
	$card->symbol = $randSymbol;

	return $card;

	/*

	// przyklad prezentacji danych


	$card = "";
	$symbol = "";

	switch ($randCard) {
		case "11":
			$card =  ' J ';
			break;
	    case "12":
	        $card =  ' K ';
	        break;
	    case "13":
	        $card =  ' Q ';
	        break;
		case "14":
			$card =  ' A ';
			break;
		default:
			$card = $randCard;
	}


	switch ($randSymbol) {
		case "1":
			$symbol =  ' wino ';
			break;
	    case "2":
	        $symbol =  ' serce ';
	        break;
	    case "3":
	        $symbol =  ' pik ';
	        break;
		case "4":
			$symbol =  ' żołądź ';
			break;
	}

	echo $response = $card . ' ' . $symbol;
}
	*/
