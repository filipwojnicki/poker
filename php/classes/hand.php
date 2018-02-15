<?php

require_once 'card.php';

class Hand {

	function getHand() {

		$hand->card1 = getNewCard();
		$hand->card2 = getNewCard();

		if($this->checkHand($hand) == '1')
			$hand->card1 = getNewCard();

		if($this->checkHand($hand) == '2')
			$hand->card2 = getNewCard();

		return $hand;
	}

	function checkHand($hand){

		$card1num = $hand->card1->color.$hand->card1->symbol;
		$card2num = $hand->card2->color.$hand->card2->symbol;

		if ($card1num == $card2num)
			return '1';

		if ($card2num == $card1num)
			return '2';
	}
}

