<?php
    session_start();
    if(isset($_SESSION['siege']) && isset($_SESSION['niederlagen'])){
        if(isset($_COOKIE['beginn']) && isset($_SESSION['endzeitpunkt'])){
            $beginn = unserialize(filter_input(INPUT_COOKIE, 'beginn'));
            $messagePartOne = "Am  $beginn[tm_mday]." . ($beginn['tm_mon'] + 1). "." . ($beginn['tm_year'] + 1900) . 
                    " um $beginn[tm_hour]:$beginn[tm_min]:$beginn[tm_sec] Uhr haben Sie"
                    . " das Spiel gestartet und um ";
            $messagePartTwo = strftime("%H:%M:%S Uhr mit folgendem Ergebnis beendet: <br>", $_SESSION['endzeitpunkt']);
        }

        if($_SESSION['siege'] > $_SESSION['niederlagen']){
            $_SESSION['gewonnen'] = true;
            $messagePartThree = "Mit einem " . $_SESSION['siege'] . " : " . $_SESSION['niederlagen'] . " haben Sie den Computer geschlagen !<br><br>"
                    . "Glueckwunsch !"; //&uml; zeigt nur zwei Punkte an
        } elseif($_SESSION['siege'] < $_SESSION['niederlagen']){
            $_SESSION['gewonnen'] = false;
            $messagePartThree = "Leider haben Sie mit " . $_SESSION['siege'] . " : " . $_SESSION['niederlagen'] . " verloren.";
        } else {
            $_SESSION['gewonnen'] = false;
            $_SESSION['unentschieden'] = true;
            $messagePartThree = "Mit einem " . $_SESSION['siege'] . " : " . $_SESSION['niederlagen'] . " haben Sie sich ein Unentschieden erk&auml;mpft.";
        }
    }
    if(isset($_POST['submit'])){
        header("Location: http://localhost/Gruppe01Uebung3");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Schnick,Schnack,Schnack,Schnuck,Schere,Stein,Papier,Spiel,Auswertung,Gewinner,Sieger">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Schnick Schnack Schnuck, Schere Stein Papier, Spielauswertung, Siegerehrung">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Schnick-Schnack-Schnuck - Spielauswertung</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body>
        <h1 id="auswertung-header">
            <?php
            if(isset($_SESSION['gewonnen']) && isset($_SESSION['unentschieden'])){
                if($_SESSION['gewonnen']){
                    echo "Winner Winner Chicken Dinner !";
                    $backgroundColor = "background-color: green;";
                }elseif(!($_SESSION['gewonnen']) && ($_SESSION['unentschieden'])){
                    echo "Draw !";
                    $backgroundColor = "background-color: yellow;";
                }else{
                    echo "Game Over !";
                    $backgroundColor = "background-color: red;";
                }
            }
            ?>
        </h1>
        <div id="auswertung-container-center">
            <p id="auswertung-paragraph">
                <?php
                echo $messagePartOne;
                echo $messagePartTwo . "<br>";
                echo $messagePartThree . "<br>";
                ?>
            </p>
        </div>

        <form id="auswertung-form" method="POST" action="spielauswertung.php">
            <input id="auswertung-submit" type="submit" name="submit" value="Zurueck zur Startseite"> <!--&uml; zeigt nur zwei Punkte an-->
        </form>
        
        <div id="auswertung-container-bottom" style="<?php if(isset($backgroundColor)){ echo $backgroundColor; }  ?>">
                <h2 id="auswertung-unterschrift">
                <?php
                if(isset($_SESSION['gewonnen']) && isset($_SESSION['unentschieden'])){
                    if($_SESSION['gewonnen']){
                        echo "Gewonnen !";
                    }elseif(!($_SESSION['gewonnen']) && ($_SESSION['unentschieden'])){
                        echo "Unentschieden !";
                    }else{
                        echo "Verloren !";
                    }
                }
                ?>
            </h2>
        </div>
    </body>
</html>