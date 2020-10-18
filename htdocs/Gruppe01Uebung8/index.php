<?php
    session_start();
    if(!isset($_SESSION['move'])){
        $_SESSION['move'] = false;
    }
    if(!isset($_SESSION['shoot'])){
        $_SESSION['shoot'] = false;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Schatz,Wumpus,Labyrinth,Brot,Pfeil">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Der Schatz und der Wumpus, Alfredos Schatz im Labyrinth, Minigame">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Der Schatz und der Wumpus</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body onload="gameInit();">
        <h2 id="text-ueberschrift">Herzlich Willkommen bei Der Schatz und der Wumpus</h2>
        <div id="text"></div>
        <div id="text-spiel"></div>
        <div id="text-spiel-aktuell"></div>
        <div class="end-game-msg"><button id="btn-restart" name="restart" onclick="gameEnd(this.name);">Neustarten</button><span id="msg"></span></div>
        <div id="inventar-container">
            <span id="brotkrumen"></span>
            <span id="pfeile"></span>
        </div>
        <div id="button-container">
            <div id="start-button-container">
                <button id="btn-start" onclick="startGame();">Start</button>
                <button id="btn-end" name="end" onclick="gameEnd(this.name);">Ende</button>
            </div>

            <div id="richtung-button-container">
                <button name="westen" onclick="direction(this.name);">Westen</button>
                <button name="norden" onclick="direction(this.name);">Norden</button>
                <button name="sueden" onclick="direction(this.name);">S&uuml;den</button>
                <button name="osten" onclick="direction(this.name);">Osten</button>
            </div>
            <div id="action-button-container">
                <button id="btn-bewegen" name="move" onclick="action(this.name);">Bewegen</button>
                <button id="btn-schiessen" name="shoot" onclick="action(this.name);">Schie&szlig;en</button>
                <button id="btn-brot-legen" name="legen" onclick="brotAction(this.name);">Brotkrume<br>legen</button>
                <button id="btn-brot-nehmen" name="nehmen" onclick="brotAction(this.name);">Brotkrume<br>nehmen</button>
            </div>
        </div>
        
        <script src="./javascript.js"></script>
        <script src="./constants.js"></script>
    </body>
</html>