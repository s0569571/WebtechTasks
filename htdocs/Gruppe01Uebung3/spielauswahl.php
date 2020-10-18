<?php 
    session_start();
    if(isset($_POST['submit'])){
        if(isset($_COOKIE['beginn'])){
            setcookie('beginn', filter_input(INPUT_COOKIE, 'beginn'), time()+3600);
        }
        $_SESSION['einsatzComputer'] = null;
        if(isset($_POST['wahl_des_spielers'])){
            $_SESSION['eingabe'] = filter_input(INPUT_POST, 'wahl_des_spielers');
            header('Location: http://localhost/Gruppe01Uebung3/ergebnis.php');
            die();
        }else{
            $wahlErrorMsg = "Bitte w&auml;hlen Sie eine Option aus:<br>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Schnick,Schnack,Schnack,Schnuck,Schere,Stein,Papier,Spiel,Auswahl,Wahl">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Schnick Schnack Schnuck, Schere Stein Papier, Auswahl">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Schnick Schnack Schnuck - Auswahl</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body>
        <h2>Treffen Sie eine Wahl</h2>
        <div class="antwort-form antwort-form-auswahl">
            <form method="POST" action="spielauswahl.php">
                
                <?php 
                if(isset($wahlErrorMsg)){
                    echo "<p class=\"error-message\">". $wahlErrorMsg . "</p>";
                } 
                ?>
                <input type="radio" name="wahl_des_spielers" value="Schere">
                <label class="auswahl-label">Schere</label>
                
                <input type="radio" name="wahl_des_spielers" value="Stein">
                <label class="auswahl-label">Stein</label>
                
                <input type="radio" name="wahl_des_spielers" value="Papier">
                <label class="auswahl-label">Papier</label>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
        
        <div class="runden-container">
            <fieldset class="runden-anzahl">
                <legend align="left" class="runden-legende">
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
