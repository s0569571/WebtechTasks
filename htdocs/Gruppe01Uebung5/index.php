<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Formular,Name,PLZ,Stadt,Strasse,Hausnummer,IBAN,Geldbetrag">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Formular, Formulardaten, Formularauswertung">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Formulare</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body>
        <div id="form-container">
            <form id="formular">
                <div id="name-container">
                    <label for="name">Name</label>
                    <input type="text" id="name">
                </div>
                <div id="plz-container">
                    <label for="postleitzahl">Postleitzahl</label>
                    <input type="text" maxlength="5" id="postleitzahl">
                </div>
                <div id="stadt-container">
                    <label for="stadt">Stadt</label>
                    <input type="text" id="stadt">
                </div>
                <div id="strasse-container">
                    <label for="strasse">Stra&szlig;e</label>
                    <input type="text" id="strasse">
                </div>
                <div id="hausnummer-container">
                    <label for="hausnummer">Hausnummer</label>
                    <input type="text" id="hausnummer">
                </div>
                <div id="iban-container">
                    <label for="iban">IBAN</label>
                    <input type="text" id="iban">
                </div>
                <div id="geldbetrag-container">
                    <label for="geldbetrag">Geldbetrag</label>
                    <input type="text" id="geldbetrag">
                </div>
            </form>
            <button id="btn-senden" onclick="caller()">Senden</button>  <!-- der Button ist ausserhalb des forms,
            da ansonsten bei jedem Klick auf den Button alle Felder zurueckgesetzt werden -->
        </div>
        <div id="messages">
        </div>
        <script src="./javascript.js"></script>
    </body>
</html>
