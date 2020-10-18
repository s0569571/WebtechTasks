<?php
if(isset($_POST['submit'])){
    if(isset($_POST['spiel_starten'])){
        session_start();
        if(filter_input(INPUT_POST, 'spiel_starten') == "Ja"){
            $beginn = serialize(localtime(time(), true));
            setcookie('beginn', $beginn, time()+3600);
            $_SESSION['siege'] = 0;
            $_SESSION['niederlagen'] = 0;
            $_SESSION['gleichstand'] = 0;
            $_SESSION['spiele'] = 0;
            $_SESSION['gewonnen'] = false;
            $_SESSION['unentschieden'] = false;
            $url = "http://localhost/Gruppe01Uebung3/spielauswahl.php";
            header("Location: $url");
            die();
        } elseif($_POST['spiel_starten'] == "Nein"){
            $schadeMessage = "Schade, vielleicht beim n&auml;chsten Mal";
        }
    }else {
            $wahlErrorMsg = "Bitte w&auml;hlen Sie eine Option aus:<br>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Schnick,Schnack,Schnack,Schnuck,Schere,Stein,Papier,Spiel">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Schnick Schnack Schnuck, Schere Stein Papier">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Schnick-Schnack-Schnuck - Das Spiel !</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body>
        <h2>M&ouml;chten Sie Schnick-Schnack-Schnuck gegen einen Computer spielen ?</h2>
        <div class="antwort-form">
            <form method="POST" action="index.php">
                <?php 
                if(isset($wahlErrorMsg)){
                    echo "<p class=\"error-message\">". $wahlErrorMsg . "</p>";
                }
                ?>
                <div class="button-margin">
                    <input type="radio" name="spiel_starten" value="Ja">
                    <label class="starten-label">Ja</label>
                </div>
                <div class="button-margin">
                    <input type="radio" name="spiel_starten" value="Nein">
                    <label class="starten-label">Nein</label>
                </div>
                <br>

                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
        
        <p class="schade-message">
            <?php
            if(isset($schadeMessage)){
                echo $schadeMessage;
            }
            ?>
        </p>
    </body>
</html>