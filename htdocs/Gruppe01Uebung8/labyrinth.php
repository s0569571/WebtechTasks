<?php
declare(strict_types=1);
require_once './cell.php';
require_once './player.php';
require_once './wumpusClass.php';

$player = null;
$wumpus = null;
$labyrinth = null;
$cols = 10;
$rows = 10;
$current;

$stack = null;

function removeWalls(Cell $current, Cell $next){
    $xCoordinate = $current->getX() - $next->getX();
    if($xCoordinate === 1){
        $current->removeWall(3);
        $next->removeWall(1);
    }else if($xCoordinate === -1){
        $current->removeWall(1);
        $next->removeWall(3);
    }
    
    $yCoordinate = $current->getY() - $next->getY();
    if($yCoordinate === 1){
        $current->removeWall(0);
        $next->removeWall(2);
    }else if($yCoordinate === -1){
        $current->removeWall(2);
        $next->removeWall(0);
    }
}

function createAllCells(){
    global $cols;
    global $rows;
    global $labyrinth;
    for($i = 0; $i < $cols; $i++){
        for($row = 0; $row < $rows; $row++){
            $cell = new Cell($row, $i);
            $labyrinth[] = $cell;
        }
    }
    $startfeld = $labyrinth[index(0, 0)];
    $startfeld->setStartfeld();
    $schatzfeld = $labyrinth[index((rand(0,$cols-1)), (rand(2,$rows-1)))];
    $schatzfeld->setSchatz(true);
}

function mazeGenerator(){
    global $current;
    global $labyrinth;
    $current = $labyrinth[0];
    
    do{
        $current->setVisited(true);
        //Schritt 1
        //2.2 Choose one of the unvisited neighbours
        $next = $current->checkNeighbors();

        if($next !== null){
            $next->setVisited(true);

            global $stack;
            //2.1 Push the current cell to the stack
            $stack[] = $current;

            //Schritt 3 Remove the wall between the current cell and the chosen cell
            removeWalls($current, $next);

            //Schritt 4 Mark the chosen cell as visited and push it to the stack
            $current = $next;
        }else if(count($stack) > 0){
            $current = array_pop($stack);
        }
    }while(count($stack) > 0);
}

function index($x, $y){
    global $cols;
    global $rows;
    if(($x < 0) || ($y < 0) || ($x > ($cols-1)) || ($y > ($rows-1))){
        return -1;
    }
    return $x + $y * $cols;
}

function createPlayer(){
    global $player;
    $player = new Player(0, 0);
}

function createWumpus(){
    global $cols;
    global $rows;
    global $wumpus;
    $x = rand(0, ($cols-1));
    $y = rand(3, ($rows-1));
    $wumpus = new Wumpus($x, $y);
}

function setUp(){
    createAllCells();
    
    mazeGenerator();
    
    createPlayer();
    
    createWumpus();
}
?>