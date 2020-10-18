<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo "Raum " . $_SESSION['radioBtn']; ?></title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body onload="login();">
        <h2>Willkommen im Chatraum <?php echo $_SESSION['radioBtn']; ?></h2>
        <div id="abwesend"><?php echo "<h3>Abwesend:</h3><br>" . $_SESSION['person4'] .", " . $_SESSION['person5'] . 
               "<br>" . $_SESSION['person6'] .", " . $_SESSION['person7'] . "<br>" . $_SESSION['person8'] . ", " . $_SESSION['person9'];
             if(!$_SESSION['zweiPersonen']){
                 echo "<br>" .  $_SESSION['person2'];
             } ?>
        </div>
        <div id="chat-container">
            <div id="person1">
                <h2 id="ich"><?php echo $_SESSION['person1']; ?></h2>
                <div id="receiver0"></div>
                <textarea id="0" name="text0" onkeypress="readTypedMsg(this.name);"></textarea>
            </div>
            <div id="person2">
                <h2><?php echo $_SESSION['person2'];  ?></h2>
                <div id="receiver1"></div>
                <textarea id="1" name="text1" onkeypress="readTypedMsg(this.name);"></textarea>
            </div>
            <div id="person3">
                <h2><?php echo $_SESSION['person3'];  ?></h2>
                <div id="receiver2"></div>
                <textarea id="2" name="text2" onkeypress="readTypedMsg(this.name);"></textarea>
            </div>
        </div>
        <button id="logout" onclick="logout();">Logout</button>
        <script src="./Ajax.js"></script>
        <script src="./javascript.js"></script>
    </body>
</html>