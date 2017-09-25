<?php
    $playerNames = array();
    $winners = array();
    $deck = array();
    $totals = array();
    $hands = array();
    $start = microtime(true);
    session_start(); //start or resume a session

    if (!isset($_SESSION['matchCount'])) { //checks whether the session exists
        $_SESSION['matchCount'] = 1;
        $_SESSION['totalElapsedTime'] = 0;
    }
    
    $start = microtime(true);

    session_start(); //start or resume a session
    
    if (!isset($_SESSION['matchCount'])) { //checks whether the session exists
        $_SESSION['matchCount'] = 1;
        $_SESSION['totalElapsedTime'] = 0;
    }
    
    //Populates the playerName array, populates the deck array with 13 cards
    //for each player (0-3), get the hand for that player, push it in to the
    //hands array, display the hand of cards and then display the winner
    function play(){
        global $hands;
        
        populatePlayerNames();
        createDeck();
        for($user=0; $user < 4; $user++){
            $hands[] = getHand($user);
            displayHand($user);
        }
        
        displayWinner();
    }
    
    function elapsedTime(){
        global $start;
         echo "<hr>";
         $elapsedSecs = microtime(true) - $start;
         echo "<h4>This match elapsed time: " . $elapsedSecs . " secs <br/></h4>";
    
         echo "<h4>Matches played:"  . $_SESSION['matchCount'] . "<br /></h4>";
    
         $_SESSION['totalElapsedTime'] += $elapsedSecs;
         
         echo "<h4>Total elapsed time in all matches: " .  $_SESSION['totalElapsedTime'] . "<br /></h4>";
         
         echo "<h4>Average time: " . ( $_SESSION['totalElapsedTime']  / $_SESSION['matchCount']). "</h4>";
         
         $_SESSION['matchCount']++;
    } //elapsedTime
    
    //Push four new player names on to the playerNames array
    function populatePlayerNames(){
        global $playerNames;
        
        $playerNames[] = "Phil";
        $playerNames[] = "Oz";
        $playerNames[] = "Dre";
        $playerNames[] = "Seuss";
        shuffle($playerNames);
    }
    
    //For each suit (0-3), for each card value (1-13),
    //push a string on to the deck that is suite+value
    //I.E. 01 is suite 0 ace, 12 is suite 1, value 2 then
    //shuffle the deck
    function createDeck(){
        global $deck;
        
        for($i = 0; $i < 4; $i++){
            
            for($value = 1; $value <= 13; $value++){
                $deck[] = $i."".$value;
            }
        }
        shuffle($deck);
    }
    
    //Create a new hand array, set the player's total to 0
    //and then, until the total is greater than 35 pop a card off
    //the deck, get the card's value, push it on to the hand array,
    //add the card value to this player's total and then return the
    //hand array
    function getHand($user){
        global $totals, $deck;
        
        $hand = array();
        $totals[$user] = 0;
        while($totals[$user]<35){
            $card = array_pop($deck);
            $value = substr($card,1);
            $hand[] = $card;
            $totals[$user]+=$value;
        }
        return $hand;
    }
    
    //Display a div for the player's picture over the name, then a div for
    //each of the cards and then the player's total
    function displayHand($user){
        global $hands, $playerNames, $totals;
        
        echo "<div class='player'>";
            echo "<div class='playerImage'>";
            echo "<img src='img/photos/".$playerNames[$user].".jpg'/>";
            foreach($hands[$user] as $card){
                displayCard($user,$card);
            }
            echo "</div>";
            
            echo "<p id= pName> Dr. ".$playerNames[$user]." </p>";
        
            echo "<div class='playerScore'>";
            echo "points this hand: ".$totals[$user];

            
            echo "<br>";
            echo "total points: ".$_SESSION[$playerNames[$user]];
            echo "<div class='playerHand'>";

            echo "</div>";
            
        echo "</div>";
    }
    
    //Get the card suite and value, get the string suite name from the suite number,
    //and then display an img (id=person+userNumber) of the proper suite and card
    function displayCard($user, $card){
        global $playerNames;
        
        $i = substr($card,0,1);
        $value = substr($card,1);
        
        switch($i){
            case 0:
                $suite = "hearts";
                break;
            case 1:
                $suite = "clubs";
                break;
            case 2:
                $suite = "spades";
                break;
            case 3:
                $suite = "diamonds";
                break;
        }
        echo "<img id=person$user src='./img/cards/$suite/$value.png' alt='$value of $suite' title='$value of $suite' width='70'/>";
    }
    
    function displayWinner(){
        global $playerNames, $totals, $winners;
        $max = 0;
        $winnings = 0;
        
        for($i=0; $i<4;$i++) {
            if($max <= $totals[$i] && $totals[$i] <=42) {
                $max = $totals[$i];
            }
        }

        for($i=0;$i<4;$i++) {
            if($totals[$i]==$max) {
                $winners[] = $i;
            }
            else {
                $winnings += $totals[$i];
            }
        }
        
        for($i=0;$i<sizeof($winners);$i++) {
            $_SESSION[$playerNames[$winners[$i]]] += $winnings;
            echo "<p id=winners> Dr. ".$playerNames[$winners[$i]]." wins $winnings points!</p>";
        }
    }
?>