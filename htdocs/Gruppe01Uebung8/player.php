<?php

class Player {
    private $pfeile;
    private $brotkrumen;
    private $x;
    private $y;
    private $schatz;
    
    public function __construct($x = null, $y = null) {
        $this->pfeile = 3;
        $this->brotkrumen = 5;
        if($x !== null){
            $this->x = $x;
        }
        if($y !== null){
            $this->y = $y;
        }
        $this->schatz = false;
    }
    
    public function getX(){
        return $this->x;
    }
    
    public function getY(){
        return $this->y;
    }
    
    public function setX($x){
        $this->x = $x;
    }
    
    public function setY($y){
        $this->y = $y;
    }
    
    public function getPfeile(){
        return $this->pfeile;
    }
    
    public function hasSchatz(){
        return $this->schatz;
    }
    
    public function takeSchatz(){
        $this->schatz = true;
    }
    
    public function hasBrotkrume(){
        if($this->brotkrumen > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function placeBrotkrume(){
        if($this->brotkrumen > 0){
            $this->brotkrumen = $this->brotkrumen - 1;
            return true;
        }else{
            return false;
        }
    }
    
    public function takeBrotkrume(){
        $this->brotkrumen = $this->brotkrumen + 1;
    }
    
    public function schiessen(){
        if($this->pfeile > 0){
            $this->pfeile = $this->pfeile - 1;
            return true;
        }else{
            return false;
        }
    }
    
    public function moveTop(){
        if(($this->y - 1) > -1){
            $this->y = $this->y - 1;
        }
    }
    
    public function moveRight(){
        global $cols;
        if(($this->x + 1) < ($cols)){
            $this->x = $this->x + 1;
        }
    }
    
    public function moveBottom(){
        global $rows;
        if(($this->y + 1) < $rows){
            $this->y = $this->y + 1;
        }
    }
    
    public function moveLeft(){
        if(($this->x - 1) > -1){
            $this->x = $this->x - 1;
        }
    }
}
?>