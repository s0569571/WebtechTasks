<?php
$chatMitglieder = ["Thomas", "Peter", "Gustav", "Frederike", "Andrea", "Andreas"];

function setAbwesendenPersonen(){
    global $chatMitglieder;
    $_SESSION['person4'] = $chatMitglieder[rand(0,5)];
    $_SESSION['person5'] = $chatMitglieder[rand(0,5)];
    $_SESSION['person6'] = $chatMitglieder[rand(0,5)];
    $_SESSION['person7'] = $chatMitglieder[rand(0,5)];
    $_SESSION['person8'] = $chatMitglieder[rand(0,5)];
    $_SESSION['person9'] = $chatMitglieder[rand(0,5)];
}

if(isset($_POST['submit']) && isset($_POST['person1']) && isset($_POST['raum'])){
    session_start();
    $_SESSION['idPerson1'] = "0";
    $_SESSION['person2'] = $chatMitglieder[rand(0,5)];
    $_SESSION['idPerson2'] = "1";
    $_SESSION['person3'] = $chatMitglieder[rand(0,5)];
    $_SESSION['idPerson3'] = "2";
    $_SESSION['radioBtn'] = filter_input(INPUT_POST, 'raum');
    $_SESSION['person1'] = filter_input(INPUT_POST, 'person1');
    
    //sind zwei weitere Personen im Raum ?
    $_SESSION['zweiPersonen'] = (rand(0,1) == 1);

    setAbwesendenPersonen();
    header("Location: http://localhost/Gruppe01Uebung7/chat.php");
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chat - Login</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body>
        <h1 id="ueberschrift">Welchen Chatraum m&ouml;chten Sie besuchen ?</h1>
        <div id="main-container">
            <form id="form" method="POST" action="index.php">
                <div id="button-container">
                    <input type="radio" name="raum" value="1">
                    <label class="raum-label">Raum 1</label>

                    <input type="radio" name="raum" value="2">
                    <label class="raum-label">Raum 2</label>

                    <input type="radio" name="raum" value="3">
                    <label class="raum-label">Raum 3</label>
                </div>
                <label class="name-label">Name:</label>
                <input type="text" name="person1" id="person1">
                <input type="submit" name="submit" value="Login" onclick="login();">
            </form>
        </div>
        <script src="./javascript.js"></script>
        <script src="./Ajax.js"></script>
    </body>
</html>