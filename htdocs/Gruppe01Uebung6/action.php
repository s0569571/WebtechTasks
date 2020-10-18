<?php
    session_start();
    
    $_SESSION['tueren'] = ["ziege", "ziege", "auto"];
    
    $firstGoat;
    
    
function chooseGoat($tuer){
    $suchZiege = true;
    while($suchZiege){
        $randomZiege = rand(0,2);
        $tuerArray = $_SESSION['randomTueren'];
        if(($tuerArray[$randomZiege] == "ziege") && (("tuer" . $randomZiege) != $tuer)){
            echo "tuer" . $randomZiege;
            
            global $firstGoat;
            $firstGoat = $randomZiege;
            $suchZiege = false;
        }
    }
    $_SESSION['goatVisible'] = true;
}

function calculateStatsKeepStrategy(){
    if(isset($_SESSION['keepStrategy'])){
        $keepStrategy = $_SESSION['keepStrategy'];
        if(($keepStrategy['gewinn'] !== 0) || ($keepStrategy['niete'] !== 0)){
            $_SESSION['keepStrategyPercentage'] = ($keepStrategy['gewinn']) / (($keepStrategy['gewinn']) + 
                ($keepStrategy['niete']));
        }else{
            $_SESSION['keepStrategyPercentage'] = 0;
        }
    }else{
        $_SESSION['keepStrategyPercentage'] = 0;
    }
}

function calculateStatsChangeStrategy(){
    if(isset($_SESSION['changeStrategy'])){
        $changeStrategy = $_SESSION['changeStrategy'];
        if(($changeStrategy['gewinn'] !== 0) || ($changeStrategy['niete'] !== 0)){
            $_SESSION['changeStrategyPercentage'] = ($changeStrategy['gewinn']) / (($changeStrategy['gewinn']) + 
                ($changeStrategy['niete']));
        }else{
            $_SESSION['changeStrategyPercentage'] = 0;
        }
        
    }else{
        $_SESSION['changeStrategyPercentage'] = 0;
    }
}


function generateStatsNiete($tuer){
    $_SESSION['ziegen'] = $_SESSION['ziegen'] + 1;
    if($_SESSION['firstChoice'] == $tuer){
        $keepStrategy =  $_SESSION['keepStrategy'];
        $keepStrategy['niete'] = $keepStrategy['niete'] + 1;
        $_SESSION['keepStrategy'] = $keepStrategy;
    }else{
        $changeStrategy = $_SESSION['changeStrategy'];
        $changeStrategy['niete'] = $changeStrategy['niete'] + 1;
        $_SESSION['changeStrategy'] = $changeStrategy;
    }
}


function generateStatsGewinn($tuer){
    $_SESSION['autos'] = $_SESSION['autos'] + 1;
    if($_SESSION['firstChoice'] == $tuer){
        $keepStrategy = $_SESSION['keepStrategy'];
        $keepStrategy['gewinn'] = $keepStrategy['gewinn'] + 1;
        $_SESSION['keepStrategy'] = $keepStrategy;
    }else{
        $changeStrategy = $_SESSION['changeStrategy'];
        $changeStrategy['gewinn'] = $changeStrategy['gewinn'] + 1;
        $_SESSION['changeStrategy'] = $changeStrategy;
    }
}
    

$requestHeader = apache_request_headers();
if(isset($requestHeader['x_requested_with'])){
    if(isset($_POST['choice'])){
        if(isset($_SESSION['goatVisible']) && !$_SESSION['goatVisible']){
            shuffle($_SESSION['tueren']);
            $_SESSION['randomTueren'] = $_SESSION['tueren'];
            $tuer = filter_input(INPUT_POST, 'choice');
            $_SESSION['firstChoice'] = $tuer;
            chooseGoat($tuer);

        }else{
            $tuer = filter_input(INPUT_POST, 'choice');

            global $firstGoat;
            if($tuer == $firstGoat){    
                echo "Diese T&uuml;r kann nicht gew&auml;hlt werden.";
            }else{
                preg_match_all('!\d+!', $tuer, $tuerIndex);
                if($_SESSION['randomTueren'][intval($tuerIndex)] === "auto"){
                    echo 1;
                    generateStatsGewinn($tuer);
                }else{
                    echo 0;
                    generateStatsNiete($tuer);
                }
                $_SESSION['goatVisible'] = false;
                $_SESSION['gespielteRunden'] = $_SESSION['gespielteRunden'] + 1;

                calculateStatsChangeStrategy();
                calculateStatsKeepStrategy();

            }
        }
    }
}
    
    
if(isset($_GET['stats'])){
    $strategy = filter_input(INPUT_GET, 'stats');
    if($strategy == "change"){
        if(isset($_SESSION['changeStrategyPercentage'])){
            echo round($_SESSION['changeStrategyPercentage'] * 100, 2);
        }
    }else if($strategy == "keep"){
        if(isset($_SESSION['keepStrategyPercentage'])){
            echo round($_SESSION['keepStrategyPercentage'] * 100, 2);
        }
    }else if($strategy == "ziegen"){
        if(isset($_SESSION['ziegen'])){
            echo $_SESSION['ziegen'];
        }
    }else if($strategy == "autos"){
        if(isset($_SESSION['autos'])){
            echo $_SESSION['autos'];
        }
    }
}
    
function resetStats(){
    session_unset();
}
    
if(isset($requestHeader['x_requested_with_end'])){
    if(isset($_POST['end'])){
        $end = filter_input(INPUT_POST, 'end');
        if($end == "game"){
            resetStats();
        }
    }
}
    
?>