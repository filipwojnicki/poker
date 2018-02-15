<?php

include 'cardsSet.php';


function checkGame($player, $table){

	//zmienne pomocnicze
	$same1 = 0; // para 1- 1 para 2- 2 karty takie  3- karty takie same 4- karty takie same
	$same2 = 0;

	//uklady
	$pair = 0;		// 1 +
	$twopair = 0;	// 2 +
	$three = 0;		// 3 +
	$straight = 0; // strit  4
	$flush = 0;  // kolor  5 +
	$full = 0; // full 6
	$four = 0; // 7 +
	$straightfull = 0; // strit 1 kolor 8
	$poker = 0; // poker krolewski 9 +

	//player cards
	$pcard1 = $player->card1;
	$pcard2 = $player->card2;

	// table
	$tcard1 = $table->card1;
	$tcard2 = $table->card2;
	$tcard3 = $table->card3;
	$tcard4 = $table->card4;
	$tcard5 = $table->card5;

	// pary gracza

	if(isPair($pcard1,$pcard2) ){
		$pair = 1;
		$same1++;
		$same2++;
	}
		

	if(isPair($pcard1,$tcard1) )
		$same1++;

	if(isPair($pcard1,$tcard2) )
		$same1++;

	if(isPair($pcard1,$tcard3) )
		$same1++;

	if(isPair($pcard1,$tcard4) )
		$same1++;

	if(isPair($pcard1,$tcard5) )
		$same1++;

	if(isPair($pcard2,$tcard1) )
		$same2++;

	if(isPair($pcard2,$tcard2) )
		$same2++;

	if(isPair($pcard2,$tcard3) )
		$same2++;

	if(isPair($pcard2,$tcard4) )
		$same2++;

	if(isPair($pcard2,$tcard5) )
		$same2++;

	if($same1 == 3 || $same2 == 3)
		$four = 1;

	if($same1 == 2 || $same2 == 2)
		$three = 1;

	if($same1 == 1 || $same2 == 1)
		$pair = 1;

	if($same1 == 2 && $same2 == 1 || $same1 == 1 && $same2 == 2)
		$full = 1;

	if($same1 == 1 && $same2 == 1 && !isPair($pcard1,$pcard2))
		$twopair = 1;

	if(isFlush($player, $table)){
		$flush = 1;
		if(isPoker($player, $table)){
			$poker = 1;
		}
	}

	// ocena wg układów

	if ($poker == 1)
		return 'poker';
	elseif ($straightfull == 1)
		return 'straightfull';
	elseif ($four == 1)
		return 'four';
	elseif ($full == 1)
		return 'full';
	elseif ($flush == 1)
		return 'flush';
	elseif ($straight == 1)
		return 'straight';
	elseif ($three == 1)
		return 'three';
	elseif ($twopair == 1)
		return 'twopair';
	elseif ($pair == 1)
		return 'pair';
	else
		return 'high';


}




