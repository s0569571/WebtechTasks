<?php

class Wumpus{
    private $lebt;
    private $x;
    private $y;
    
    public function __construct($x, $y) {
        $this->lebt = true;
        $this->x = $x;
        $this->y = $y;
    }
    
    public function setPosition($x, $y){
        $this->x = $x;
        $this->y = $y;
    }
    
    public function stirb(){
        $this->lebt = false;
    }
    
    public function lebtWumpus(){
        return $this->lebt;
    }
    
    public function getX(){
        return $this->x;
    }
    
    public function getY(){
        return $this->y;
    }
}
?>