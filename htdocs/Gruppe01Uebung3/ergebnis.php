<?php 
    session_start();
    
    //folgendes wird ausgeführt, wenn der Spieler weiter gehen möchte:
    if(isset($_POST['submit'])){
        if(isset($_COOKIE['beginn'])){
            setcookie('beginn', $_COOKIE['beginn'], time()+3600);
        }
        //eingaben zurücksetzen
        $_SESSION['eingabe'] = null;
        $_SESSION['einsatzComputer'] = null;
        //ueberpruefen, ob Spieler gewonnen hat und die Rundenzahl erhöhen
        if($_SESSION['gewonnen']){
            siegOperationen();
        } elseif($_SESSION['unentschieden']){
            gleichstandOperationen();
        } elseif(!$_SESSION['gewonnen']){
            niederlageOperationen();
        }
        
        //Spiel zu Ende ? dann auf die Spielendeseite gehen
        if($_SESSION['spiele'] === 5){
            $_SESSION['endzeitpunkt'] = time();
            header('Location: http://localhost/Gruppe01Uebung3/spielauswertung.php');
            die();
        } else {
            header('Location: http://localhost/Gruppe01Uebung3/spielauswahl.php');
            die();
        }
    }
        
    $eingabe = $_SESSION['eingabe'];
    
    $einsatzOptionen = ['Schere', 'Stein', 'Papier'];
    
    if((is_null($_SESSION['einsatzComputer'])) || !(isset($_SESSION['einsatzComputer']))){
        $_SESSION['einsatzComputer'] = $einsatzOptionen[rand(0,2)];
        $einsatzComputer = $_SESSION['einsatzComputer'];
    } else {
        $einsatzComputer = $_SESSION['einsatzComputer'];
    }
             
?>
<?php
    function siegOperationen(){
        $_SESSION['siege'] = $_SESSION['siege'] + 1;
        $_SESSION['spiele'] = $_SESSION['spiele'] + 1;
    }
    function niederlageOperationen(){
        $_SESSION['spiele'] = $_SESSION['spiele'] + 1;
        $_SESSION['niederlagen'] = $_SESSION['niederlagen'] + 1;
    }
    function gleichstandOperationen(){
        $_SESSION['spiele'] = $_SESSION['spiele'] + 1;
        $_SESSION['gleichstand'] = $_SESSION['gleichstand'] + 1;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Schnick,Schnack,Schnack,Schnuck,Schere,Stein,Papier,Spiel,Resultat,Ergebnis">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Schnick Schnack Schnuck, Schere Stein Papier, Resultat der Runde">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Schnick Schnack Schnuck - Ergebnis</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body>
        <h2 class="ergebnis-header">Ihre Wahl:</h2>
        <p class="ergebnis-msg">
            <?php 
            echo $eingabe;
            ?>
        </p>
        
        <p class="ergebnis-msg">
            <?php 
            echo "Der Computer hat gew&auml;hlt:<br>". $einsatzComputer . "<br>";
            ?>
        </p>
        
        <?php
            function gewonnen(){
                echo "Gewonnen ! <br>";
                $_SESSION['gewonnen'] = true;
                $_SESSION['unentschieden'] = false;
            }
            function verloren(){
                echo "Leider verloren ! <br>";
                $_SESSION['gewonnen'] = false;
                $_SESSION['unentschieden'] = false;
            }
            function unentschieden(){
                echo "Unentschieden ! <br>";
                $_SESSION['gewonnen'] = false;
                $_SESSION['unentschieden'] = true;
            }
        ?>
        <p class="ergebnis-msg">
            <?php
                if($eingabe == $einsatzComputer){
                    unentschieden();
                } elseif(($eingabe == "Schere") && ($einsatzComputer == "Stein")){
                    verloren();
                } elseif(($eingabe == "Schere") && ($einsatzComputer == "Papier")){
                    gewonnen();
                } elseif(($eingabe == "Stein") && ($einsatzComputer == "Schere")){
                    verloren();
                } elseif(($eingabe == "Stein") && ($einsatzComputer == "Papier")){
                    gewonnen();
                } elseif(($eingabe == "Papier") && ($einsatzComputer == "Schere")){
                    verloren();
                } elseif(($eingabe == "Papier") && ($einsatzComputer == "Stein")){
                    gewonnen();
                }
            ?>
        </p>
        
        <div class="antwort-form">
            <form method="POST" action="ergebnis.php">
                <input type="submit" name="submit" value="Weiter">
            </form>
        </div>
        
        <div class="runden-container runden-c-ergebnis">
            <fieldset class="runden-anzahl">
                <legend class="runden-legende">
                    Runde
                </legend>
                <p class="runden-nummer"> 
                    <?php 
                    if(isset($_SESSION['spiele'])){
                        echo ($_SESSION['spiele'] + 1); 
                    }
                    ?>
                </p>
            </fieldset>
        </div>
        
        <div class="spielstand">
            <div class="spielstand-links">
                <p>
                    <?php 
                    if(isset($_SESSION['siege'])){
                        echo "Siege: ". ($_SESSION['siege']);
                    }
                    ?>
                </p>
            </div>
            <div class="spielstand-center">
                <p>
                    <?php
                    if(isset($_SESSION['gleichstand'])){
                        echo "Unentschieden: " . ($_SESSION['gleichstand']);
                    }
                    ?>
                </p>
            </div>
            <div class="spielstand-rechts">
                <p>
                    <?php 
                    if(isset($_SESSION['niederlagen'])){
                        echo "Niederlagen: " . ($_SESSION['niederlagen']);
                    }
                    ?>
                </p>
            </div>
            
        </div>
        
    </body>
</html>
