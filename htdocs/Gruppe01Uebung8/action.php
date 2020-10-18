<?php
require_once './cell.php';
require_once './labyrinth.php';
require_once './player.php';
require_once './constants.php';
session_start();

function istWumpusDa($tmpPlayer){
    $tmpWumpus = $_SESSION['wumpus'];

    if(($tmpWumpus->getX() == $tmpPlayer->getX()) && 
            ($tmpWumpus->getY() == $tmpPlayer->getY()) &&
            $tmpWumpus->lebtWumpus()){
        return true;
    }else{
        return false;
    }
}

function istWumpusNorden($tmpWumpus, $tmpPlayer){
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $tmpPlayer->getX();
    $playerY = $tmpPlayer->getY();
    $tmpLab = $_SESSION['labyrinth'];
    $tmpCell = $tmpLab[index($playerX, $playerY)];

    if(($wumpusX == $playerX) && ($wumpusY == ($playerY - 1)) &&
           (!$tmpCell->hasWallOben()) ){
        return true;
    }else{
        return false;
    }
}

function istWumpusOsten($tmpWumpus, $tmpPlayer){
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $tmpPlayer->getX();
    $playerY = $tmpPlayer->getY();
    $tmpLab = $_SESSION['labyrinth'];
    $tmpCell = $tmpLab[index($playerX, $playerY)];

    if(($wumpusX == ($playerX + 1)) && ($wumpusY == $playerY) &&
           (!$tmpCell->hasWallRechts()) ){
        return true;
    }else{
        return false;
    }
}

function istWumpusSueden($tmpWumpus, $tmpPlayer){
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $tmpPlayer->getX();
    $playerY = $tmpPlayer->getY();
    $tmpLab = $_SESSION['labyrinth'];
    $tmpCell = $tmpLab[index($playerX, $playerY)];

    if(($wumpusX == $playerX) && ($wumpusY == ($playerY + 1)) &&
           (!$tmpCell->hasWallUnten()) ){
        return true;
    }else{
        return false;
    }
}

function istWumpusWesten($tmpWumpus, $tmpPlayer){
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $tmpPlayer->getX();
    $playerY = $tmpPlayer->getY();
    $tmpLab = $_SESSION['labyrinth'];
    $tmpCell = $tmpLab[index($playerX, $playerY)];

    if(($wumpusX == ($playerX - 1)) && ($wumpusY == $playerY) &&
           (!$tmpCell->hasWallLinks()) ){
        return true;
    }else{
        return false;
    }
}

function istWumpusNahe(){
    $tmpWumpus = $_SESSION['wumpus'];
    $tmpPlayer = $_SESSION['player'];
    if(istWumpusNorden($tmpWumpus, $tmpPlayer) || 
           istWumpusOsten($tmpWumpus, $tmpPlayer) ||
           istWumpusSueden($tmpWumpus, $tmpPlayer) ||
           istWumpusWesten($tmpWumpus, $tmpPlayer)){
        return true;
    }else{
        return false;
    }
}

function checkWin($response, $tmpCell, $tmpPlayer){
    if(($tmpCell->isStartfeld()) && ($tmpPlayer->hasSchatz())){
        if($response !== null){
            $response = $response . "," . GEWINNER;
        }else{
            $response = GEWINNER;
        }
    }
    return $response;
}

function checkFeigling($response, $tmpCell, $tmpPlayer){
    if(($tmpCell->isStartfeld()) && (!$tmpPlayer->hasSchatz())){
        if($response !== null){
            $response = $response . "," . FEIGLING;
        }else{
            $response = FEIGLING;
        }
    }
    return $response;
}

function checkSchatzGefunden($response, $tmpCell, $tmpLab, $tmpPlayer){
    if($tmpCell->isSchatz()){
        $tmpLab[index($tmpCell->getX(), $tmpCell->getY())]->takeSchatz();
        $_SESSION['labyrinth'] = $tmpLab;
        $tmpPlayer->takeSchatz();
        $_SESSION['player'] = $tmpPlayer;
        if($response !== null){
            $response = $response . "," . SCHATZ_GEFUNDEN;
        }else{
            $response = SCHATZ_GEFUNDEN;
        }
    }
    return $response;
}

function checkBrot($response, $tmpCell){
    if($tmpCell->hasBrotkrumen()){
        if($response !== null){
            $response = $response . "," . BROT_GEFUNDEN;
        }else{
            $response = BROT_GEFUNDEN;
        }
    }
    return $response;
}

function checkWumpusDa($response, $tmpPlayer){
    if(istWumpusDa($tmpPlayer)){
        if($response !== null){
            $response = $response . "," . SPIELER_TOT;
        }else{
            $response = SPIELER_TOT;
        }
    }
    return $response;
}

function checkWumpusNahe($response){
    if(istWumpusNahe()){
        if($response !== null){
            $response = $response . "," . WUMPUS_NAHE;
        }else{
            $response = WUMPUS_NAHE;
        }
    }
    return $response;
}

/*
 * $response wird mehrfach verwendet, da es ein String ist,
 * der schrittweise zusammengebaut wird
 */
function checkNewField(){
    $response = null;
    $tmpPlayer = $_SESSION['player'];
    $tmpLab = $_SESSION['labyrinth'];
    $tmpCell = $tmpLab[index($tmpPlayer->getX(), $tmpPlayer->getY())];

    $response = checkWin($response, $tmpCell, $tmpPlayer);
    $response = checkFeigling($response, $tmpCell, $tmpPlayer);
    $response = checkSchatzGefunden($response, $tmpCell, $tmpLab, $tmpPlayer);
    $response = checkBrot($response, $tmpCell);
    $response = checkWumpusDa($response, $tmpPlayer);
    $response = checkWumpusNahe($response);

    if($response !== null){
        $response = $response . "," . MOVE_SUCCESS;
    }else{
        $response = MOVE_SUCCESS;
    }
    echo $response;
}

function movePlayerNorth($player, $tmpCell){
    if(!($tmpCell->hasWallOben()) && (($player->getY()) > 0)){
        $player->setY($player->getY() - 1);
        $_SESSION['player'] = $player;
        checkNewField();
    }else{
        echo MOVE_WAND;
    }   
}

function shootNorth($player){
    $tmpLab = $_SESSION['labyrinth'];
    $tmpWumpus = $_SESSION['wumpus'];
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $player->getX();
    $playerY = $player->getY();

    for($i = ($playerY - 1); $i > -1; $i--){
        if($tmpLab[index($playerX, $i)]->hasWallUnten()){
            echo SHOOT_WAND;
            return;
        }else if(($wumpusX == $playerX) && ($wumpusY == $i)){
            $tmpWumpus->stirb();
            $_SESSION['wumpus'] = $tmpWumpus;
            echo WUMPUS_TOT;
            return;
        }
    }
    echo SHOOT_WAND; 
}

function checkNorthDirection($player, $tmpLab){
    $tmpCell = $tmpLab[index($player->getX(), $player->getY())];
    if($_SESSION['move']){
        movePlayerNorth($player, $tmpCell);
        $_SESSION['move'] = false;
    }else if($_SESSION['shoot']){
        if($player->schiessen()){
            shootNorth($player);
            $_SESSION['player'] = $player;
        }else{
            echo KEINE_PFEILE;
        }
        $_SESSION['shoot'] = false;
    }
}

function movePlayerEast($player, $tmpCell){
    if((!$tmpCell->hasWallRechts()) && (($player->getX()+1) < $_SESSION['cols'])){
        $player->setX($player->getX() + 1);
        $_SESSION['player'] = $player;
        checkNewField();
    }else{
        echo MOVE_WAND;
    }   
}

function shootEast($player){
    $tmpLab = $_SESSION['labyrinth'];
    $tmpWumpus = $_SESSION['wumpus'];
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $player->getX();
    $playerY = $player->getY();

    for($i = ($playerX + 1); $i < $_SESSION['cols']; $i++){
        if($tmpLab[index($i, $playerY)]->hasWallLinks()){
            echo SHOOT_WAND;
            return;
        }else if(($wumpusX == $i) && ($wumpusY == $playerY)){
            $tmpWumpus->stirb();
            $_SESSION['wumpus'] = $tmpWumpus;
            echo WUMPUS_TOT;
            return;
        }
    }
    echo SHOOT_WAND;
}

function checkEastDirection($player, $tmpLab){
    $tmpCell = $tmpLab[index($player->getX(), $player->getY())];
    if($_SESSION['move']){
        movePlayerEast($player, $tmpCell);
        $_SESSION['move'] = false;
    }else if($_SESSION['shoot']){
        if($player->schiessen()){
            shootEast($player);
            $_SESSION['player'] = $player;
        }else{
            echo KEINE_PFEILE;
        }
        $_SESSION['shoot'] = false;
    }
}

function movePlayerSouth($player, $tmpCell){
    if(!($tmpCell->hasWallUnten()) && (($player->getY() + 1) < $_SESSION['rows'])){
        $player->setY($player->getY() + 1);
        $_SESSION['player'] = $player;
        checkNewField();
    }else{
        echo MOVE_WAND;
    }   
}

function shootSouth($player){
    $tmpLab = $_SESSION['labyrinth'];
    $tmpWumpus = $_SESSION['wumpus'];
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $player->getX();
    $playerY = $player->getY();

    for($i = ($playerY + 1); $i < $_SESSION['rows']; $i++){
        if($tmpLab[index($playerX, $i)]->hasWallOben()){
            echo SHOOT_WAND;
            return;
        }else if(($wumpusX == $playerX) && ($wumpusY == $i)){
            $tmpWumpus->stirb();
            $_SESSION['wumpus'] = $tmpWumpus;
            echo WUMPUS_TOT;
            return;
        }
    }
    echo SHOOT_WAND;
}

function checkSouthDirection($player, $tmpLab){
    $tmpCell = $tmpLab[index($player->getX(), $player->getY())];
    if($_SESSION['move']){
        movePlayerSouth($player, $tmpCell);
        $_SESSION['move'] = false;
    }else if($_SESSION['shoot']){

        if($player->schiessen()){
            shootSouth($player);
            $_SESSION['player'] = $player;
        }else{
            echo KEINE_PFEILE;
        }
        $_SESSION['shoot'] = false;
    }
}

function movePlayerWest($player, $tmpCell){
    if(!($tmpCell->hasWallLinks()) && (($player->getX()) > 0)){
        $player->setX($player->getX() - 1);
        $_SESSION['player'] = $player;
        checkNewField();
    }else{
        echo MOVE_WAND;
    }   
}

function shootWest($player){
    $tmpLab = $_SESSION['labyrinth'];
    $tmpWumpus = $_SESSION['wumpus'];
    $wumpusX = $tmpWumpus->getX();
    $wumpusY = $tmpWumpus->getY();
    $playerX = $player->getX();
    $playerY = $player->getY();

    for($i = ($playerX - 1); $i > - 1; $i--){
        if($tmpLab[index($i, $playerY)]->hasWallRechts()){
            echo SHOOT_WAND;
            return;
        }else if(($wumpusX == $i) && ($wumpusY == $playerY)){
            $tmpWumpus->stirb();
            $_SESSION['wumpus'] = $tmpWumpus;
            echo WUMPUS_TOT;
            return;
        }
    }
    echo SHOOT_WAND;
}

function checkWestDirection($player, $tmpLab){
    $tmpCell = $tmpLab[index($player->getX(), $player->getY())];
    if($_SESSION['move']){
        $_SESSION['move'] = false;
        movePlayerWest($player, $tmpCell);
    }else if($_SESSION['shoot']){
        $_SESSION['shoot'] = false;

        if($player->schiessen()){
            shootWest($player);
            $_SESSION['player'] = $player;
        }else{
            echo KEINE_PFEILE;
        }
    }
}

function checkDirection($direction){
    $player = $_SESSION['player'];
    $tmpLab = $_SESSION['labyrinth'];
    if(strcasecmp($direction, "norden") == 0){
        checkNorthDirection($player, $tmpLab);
    }else if(strcasecmp($direction, "osten") == 0){
        checkEastDirection($player, $tmpLab);
    }else if(strcasecmp($direction, "sueden") == 0){
        checkSouthDirection($player, $tmpLab);
    }else if(strcasecmp($direction, "westen") == 0){
        checkWestDirection($player, $tmpLab);
    }
}

function saveBrotPosition($tmpPlayer){
    if(!isset($_SESSION['brote'])){
        $brotPosi[] = "(" . $tmpPlayer->getX() . "/" . $tmpPlayer->getY() . ")";
        $_SESSION['brote'] = $brotPosi;
    }else{
        $brotPosi = $_SESSION['brote'];
        $brotPosi[] = "(" . $tmpPlayer->getX() . "/" . $tmpPlayer->getY() . ")";
        $_SESSION['brote'] = $brotPosi;
    }
}

function putBrotkrume(){
    $tmpLab = $_SESSION['labyrinth'];
    $tmpPlayer = $_SESSION['player'];
    $tmpCell = $tmpLab[index($tmpPlayer->getX(), $tmpPlayer->getY())];
    if(($tmpPlayer->hasBrotkrume()) && 
            (!$tmpCell->hasBrotkrumen())){
        $tmpPlayer->placeBrotkrume();
        $tmpLab[index($tmpPlayer->getX(), $tmpPlayer->getY())]->setBrotkrumen();
        $_SESSION['player'] = $tmpPlayer;
        $_SESSION['labyrinth'] = $tmpLab;
        saveBrotPosition($tmpPlayer);
        echo BROT_GESETZT;
    }else if($tmpPlayer->hasBrotkrume() && $tmpCell->hasBrotkrumen()){
        echo BROT_BEREITS_VORHANDEN;
    }else if(!$tmpPlayer->hasBrotkrume()){
        echo KEIN_BROT_MEHR;
    }
}

function unsetBrotkrume($tmpPlayer){
    $tmpStr = "(" . $tmpPlayer->getX() . "/" . $tmpPlayer->getY() . ")";

    if(isset($_SESSION['brote'])){
        $brotPosi = $_SESSION['brote'];
        foreach($brotPosi AS $key => $brot){
            if($brot == $tmpStr){
                unset($brotPosi[$key]);
            }
        }
        $_SESSION['brote'] = $brotPosi;
    }
}

function takeBrotkrume(){
    $tmpLab = $_SESSION['labyrinth'];
    $tmpPlayer = $_SESSION['player'];
    $tmpCell = $tmpLab[index($tmpPlayer->getX(), $tmpPlayer->getY())];
    if($tmpCell->hasBrotkrumen()){
        $tmpLab[index($tmpPlayer->getX(), $tmpPlayer->getY())]->takeBrotkrumen();
        $tmpPlayer->takeBrotkrume();
        unsetBrotkrume($tmpPlayer);
        echo BROT_AUFGENOMMEN;
    }else{
        echo BROT_NICHT_VORHANDEN;
    }
}

function existBrotPositions(){
    $brotPosi = $_SESSION['brote'];
    $counter = 0;
    foreach($brotPosi AS $brot){
        if(is_string($brot) && ($brot !== null) && (strlen($brot) > 1)){
            $counter = $counter + 1;
        }
    }
    return $counter > 0;
}

function getBrotPositions(){
    if(isset($_SESSION['brote']) && existBrotPositions()){
        echo json_encode($_SESSION['brote']);
    }else{
        echo json_encode(KEINE_BROTE_GESETZT);
    }
}

/*
 * game=init - Aufbau des Labyrinths und des Spielers und Schatz und Eingang
 */
$requestHeader = apache_request_headers();
if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['game'])){
        $value = filter_input(INPUT_POST, 'game');
        if($value == 'init'){
            setUp();
            global $labyrinth;
            if(count($labyrinth) > 0){
                $_SESSION['labyrinth'] = $labyrinth;
            }
            global $wumpus;
            if($wumpus !== null){
                $_SESSION['wumpus'] = $wumpus;
            }
            global $player;
            if($player !== null){
                $_SESSION['player'] = $player;
            }else{
            }
            global $rows;
            $_SESSION['rows'] = $rows;
            global $cols;
            $_SESSION['cols'] = $cols;
        }else if($value == 'end' || $value == 'restart'){
            echo SESSION_UNSET;
            session_unset();
        }
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['action'])){
        $action = filter_input(INPUT_POST, 'action');
        if(($action == "move") && (!$_SESSION['shoot'])){
            $_SESSION['move'] = true;
            echo BEWEGEN;
        }else if($action == "move"){
            $_SESSION['shoot'] = false;
            $_SESSION['move'] = true;
            echo BEWEGEN;
        }
        if(($action == "shoot") && (!$_SESSION['move'])){
            $_SESSION['shoot'] = true;
            echo SCHIESSEN;
        }else if($action == "shoot"){
            $_SESSION['shoot'] = true;
            $_SESSION['move'] = false;
            echo SCHIESSEN;
        }
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['brotAction'])){
        $brotAction = filter_input(INPUT_POST, 'brotAction');
        if($brotAction == "legen"){
            putBrotkrume();
        }else if($brotAction == "nehmen"){
            takeBrotkrume();
        }
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['direction'])){
        $direction = filter_input(INPUT_POST, 'direction');
        checkDirection($direction);
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['wumpus'])){
        $wumpusNahe = filter_input(INPUT_POST, 'wumpus');
        if($wumpusNahe == 'wo'){
            if(istWumpusNahe()){
                echo WUMPUS_NAHE;
            }else{
                echo WUMPUS_NICHT_NAHE;
            }
        }
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['position'])){
        $currentPosi = filter_input(INPUT_POST, 'position');
        if($currentPosi == 'brotGefunden' || $currentPosi == 'player' ||
            $currentPosi == 'brotGesetzt'){
            $tmpPlayer = $_SESSION['player'];
            echo "(" . $tmpPlayer->getX() . "/" . $tmpPlayer->getY() . ")";
        }else if($currentPosi == 'brote'){
            getBrotPositions();
        }
    }
}

if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['player'])){
        $info = filter_input(INPUT_POST, 'player');
        if($info == 'pfeile'){
            $tmpPlayer = $_SESSION['player'];
            echo $tmpPlayer->getPfeile();
        }
    }
}

?>