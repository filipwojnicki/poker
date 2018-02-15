<?php


function isPair($card1, $card2){
	// porwnanie 2 kart czy są równe
	if ($card1->color == $card2->color)
		return true;
	else
		return false;
}

function isFlush($player, $table){

	// flush czyli powtorzenie 5 kolorow (wino, serce itd) w kartach zliczam je poprzez odnalezienie najwiekszej wartosci w zliczonych elementach tablicy

	$symbols = array();

	// player

	$pcard1 = $player->card1->symbol;
	$pcard2 = $player->card2->symbol;

	// table

	$tcard1 = $table->card1->symbol;
	$tcard2 = $table->card2->symbol;
	$tcard3 = $table->card3->symbol;
	$tcard4 = $table->card4->symbol;
	$tcard5 = $table->card5->symbol;

	array_push($symbols, $pcard1);
	array_push($symbols, $pcard2);

	array_push($symbols, $tcard1);
	array_push($symbols, $tcard2);
	array_push($symbols, $tcard3);
	array_push($symbols, $tcard4);
	array_push($symbols, $tcard5);

	// zliczanie elementów tablicy

	$arrLength=count($symbols);
	$elementCount=array();

	for($i=0;$i<$arrLength-1;$i++)
	{
		$key=$symbols[$i];
		if($elementCount[$key]>=1)
			$elementCount[$key]++;
		else
			$elementCount[$key]=1;
	}

	if(max($elementCount) >= 5)
		return true;
	else
		return false;
}

function isStraight($player, $table){

	// player

	$pcard1 = $player->card1->symbol;
	$pcard2 = $player->card2->symbol;

	// table

	$tcard1 = $table->card1->symbol;
	$tcard2 = $table->card2->symbol;
	$tcard3 = $table->card3->symbol;
	$tcard4 = $table->card4->symbol;
	$tcard5 = $table->card5->symbol;

}

function isPoker($player, $table){

	$pokercards1 = array(101,111,121,131,141);
	$pokercards2 = array(102,112,122,132,142);
	$pokercards3 = array(103,113,123,133,143);
	$pokercards4 = array(104,114,124,134,144);

	$pokercards = array(101,102,103,104,111,112,113,114,121,122,123,124,131,132,133,134,141,142,143,144);

	$cards = array();

	$pcard1num =  $player->card1->color.$player->card1->symbol;
	$pcard2num =  $player->card2->color.$player->card2->symbol;

	$tcard1 = $table->card1->color.$table->card1->symbol;
	$tcard2 = $table->card2->color.$table->card2->symbol;
	$tcard3 = $table->card3->color.$table->card3->symbol;
	$tcard4 = $table->card4->color.$table->card4->symbol;
	$tcard5 = $table->card5->color.$table->card5->symbol;

	array_push($cards, $pcard1num);
	array_push($cards, $pcard2num);

	array_push($cards, $tcard1);
	array_push($cards, $tcard2);
	array_push($cards, $tcard3);
	array_push($cards, $tcard4);
	array_push($cards, $tcard5);


	// array_intersect element wspolne dla 2 tablic
	if(count(array_intersect($pokercards1, $cards)) == 5){
		return true;
	}elseif(count(array_intersect($pokercards2, $cards)) == 5){
		return true;
	}elseif(count(array_intersect($pokercards3, $cards)) == 5){
		return true;
	}elseif(count(array_intersect($pokercards4, $cards)) == 5){
		return true;
	}else{
		return false;
	}

}