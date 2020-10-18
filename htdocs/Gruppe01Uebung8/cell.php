<?php
declare(strict_types=1);
class Cell {
    private $x;
    private $y;
    private $walls;
    private $visited;
    private $schatz;
    private $brotkrumen;
    private $startfeld;
    
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
        $this->walls = [true, true, true, true];
        $this->brotkrumen = false;
        $this->schatz = false;
        $this->startfeld = false;
        $this->visited = false;
    }
    
    public function isStartfeld(){
        return $this->startfeld;
    }
    
    public function setStartfeld(){
        if(!$this->isStartfeld()){
            $this->startfeld = true;
        }
    }
    
    public function isSchatz(){
        return $this->schatz;
    }
    
    public function setSchatz($bool){
        if(!$this->isSchatz() && $bool){
            $this->schatz = $bool;
        }
    }
    
    public function takeSchatz(){
        if($this->isSchatz()){
            $this->schatz = false;
        }
    }
    
    public function hasBrotkrumen(){
        return $this->brotkrumen;
    }
    
    public function setBrotkrumen(){
        $this->brotkrumen = true;
    }
    
    public function takeBrotkrumen(){
        $this->brotkrumen = false;
    }
    
    public function getX(){
        return $this->x;
    }
    
    public function getY(){
        return $this->y;
    }
    
    public function isWall(){
        return $this->walls;
    }
    
    public function hasWallOben(){
        return $this->walls[0];
    }
    
    public function hasWallRechts(){
        return $this->walls[1];
    }
    
    public function hasWallUnten(){
        return $this->walls[2];
    }
    
    public function hasWallLinks(){
        return $this->walls[3];
    }
    
    public function removeWall(int $wall){
        if(($wall > -1) && ($wall < 4)){
            $this->walls[$wall] = false;
        }
    }
    
    public function setVisited($bool){
        $this->visited = $bool;
    }
    
    public function isVisited(){
        return $this->visited;
    }
    
    private function getExistingNeighbors(){
        global $labyrinth;
        if((index($this->x, ($this->y - 1))) !== -1){
            $neighbors['top'] = $labyrinth[index($this->x, ($this->y - 1))];
        }
        if((index(($this->x + 1), $this->y)) !== -1){
            $neighbors['right'] = $labyrinth[index(($this->x + 1), $this->y)];
        }
        if((index($this->x, ($this->y + 1))) !== -1){
            $neighbors['bottom'] = $labyrinth[index($this->x, ($this->y + 1))];
        }
        if((index(($this->x - 1), $this->y)) !== -1){
            $neighbors['left'] = $labyrinth[index(($this->x - 1), $this->y)];
        }
        return $neighbors;
    }
    
    private function checkTopAndRightNeighbors() :?array{
        $currentNeighbors = $this->getExistingNeighbors();
        $neighbors = null;
        
        if(isset($currentNeighbors['top'])){
            if(!$currentNeighbors['top']->isVisited()){
                $neighbors[] = $currentNeighbors['top'];
            }
        }
        if(isset($currentNeighbors['right'])){
            if(!$currentNeighbors['right']->isVisited()){
                $neighbors[] = $currentNeighbors['right'];
            }
        }
        return $neighbors;
    }
    
    private function checkBottomAndLeftNeighbors() :?array{
        $currentNeighbors = $this->getExistingNeighbors();
        $neighbors = null;
        
        if(isset($currentNeighbors['bottom'])){
            if(!$currentNeighbors['bottom']->isVisited()){
                $neighbors[] = $currentNeighbors['bottom'];
            }
        }
        if(isset($currentNeighbors['left'])){
            if(!$currentNeighbors['left']->isVisited()){
                $neighbors[] = $currentNeighbors['left'];
            }
        }
        return $neighbors;
    }

    public function checkNeighbors() :?Cell{
        $neighbors = null;
        $topAndRight = $this->checkTopAndRightNeighbors();
        $bottomAndLeft = $this->checkBottomAndLeftNeighbors();
        if($topAndRight !== null){
            foreach($topAndRight AS $cell){
                $neighbors[] = $cell;
            }
        }
        if($bottomAndLeft !== null){
            foreach($bottomAndLeft AS $cell){
                $neighbors[] = $cell;
            }
        }
        
        /*
         * Es wird ein Neighbor random ausgewaehlt, der noch nicht besucht wurde und zurückgegeben
         */
        if($neighbors !== null){
            if(count($neighbors) > 0){
                return $neighbors[rand(0, count($neighbors)-1)];
            }
        }
        return $neighbors;
    }
}