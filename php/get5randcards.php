<?php
header("Content-Type: application/json; charset=UTF-8");
error_reporting(0);

require 'classes/card.php';

$rand5->card1 = getNewCard();
$rand5->card2 = getNewCard();
$rand5->card3 = getNewCard();
$rand5->card4 = getNewCard();
$rand5->card5 = getNewCard();


echo json_encode($rand5);