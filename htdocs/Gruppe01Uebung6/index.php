<!DOCTYPE html>
<?php
    session_start();
    
    if(!isset($_SESSION['changeStrategyPercentage'])){
        $_SESSION['changeStrategyPercentage'] = 0;
    }
    if(!isset($_SESSION['keepStrategyPercentage'])){
        $_SESSION['keepStrategyPercentage'] = 0;
    }
    $_SESSION['goatVisible'] = false;
    if(!isset($_SESSION['gespielteRunden'])){
        $_SESSION['gespielteRunden'] = 0;
    }
    if(!isset($_SESSION['aktuelleRunde'])){
        $_SESSION['aktuelleRunde'] = 0;
    }
    if(!isset($_SESSION['ziegen'])){
        $_SESSION['ziegen'] = 0;
    }
    if(!isset($_SESSION['autos'])){
        $_SESSION['autos'] = 0;
    }
    if(!isset($_SESSION['changeStrategy'])){
        $changeStrategy['gewinn'] = 0;
        $changeStrategy['niete'] = 0;
        $_SESSION['changeStrategy'] = $changeStrategy;
    }
    
    if(!isset($_SESSION['keepStrategy'])){
        $keepStrategy['gewinn'] = 0;
        $keepStrategy['niete'] = 0;
        $_SESSION['keepStrategy'] = $keepStrategy;
    }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Ziegenproblem,Spiel,Strategien">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Das Ziegenproblems, Webanwendung, Strategien beim Ziegenproblem">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Das Ziegenproblem</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body onload="gameInit();">
        <h1 id="ueberschrift">Das Ziegenproblem</h1>
        
        <div id="tuer-container">
            <img class="tuer" id="tuer0" alt="door" src="./images/doorQuestion.jpg" height="400" width="200" onclick="tuerOeffnen(this.id);">
            <img class="tuer" id="tuer1" alt="door" src="./images/doorQuestion.jpg" height="400" width="200" onclick="tuerOeffnen(this.id);">
            <img class="tuer" id="tuer2" alt="door" src="./images/doorQuestion.jpg" height="400" width="200" onclick="tuerOeffnen(this.id);">
        </div>
        
        <div id="statistik">
            <h3 class="statistik-header">Statistik</h3>
            Strategiewechsel: <span class="strategie-wechsel"></span><br>
            Selbe Strategie: <span class="selbe-strategie"></span><br>
            Autos: <span class="autos"></span><br>
            Ziegen: <span class="ziegen"></span>
        </div>
        
        <div id="messages">
            
        </div>
        
        <div id="btn-container">
            <button id="btn-neues-spiel" onclick="window.location.reload();">Neues Spiel</button>
            <button id="btn-beenden" onclick="endGame();">Spiel beenden</button>
        </div>
        <script src="./javascript.js"></script>
    </body>
</html>
