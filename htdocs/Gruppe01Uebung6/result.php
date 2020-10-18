<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="author" content="gruppe01">
	<meta name="keywords" content="Ziegenproblem,Ergebnis">
	<meta name="language" content="de,at,ch">
	<meta name="description" content="Ergebnisse des Ziegenproblems">
	<meta name="expires" content="Tue, 12 Mai 2020 12:00:00 GMT +01:00"> 
	<meta name="revisit-after" content="60 days">	
	<meta name="robots" content="index,follow">
        <title>Das Ziegenproblem - Ergebnis</title>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    </head>
    <body onload="displayStats();">
        <h1 id="result-header">Das Ergebnis</h1>
        
        <div id="result-container">
            Gewinnchance beim Wechsel der Strategie: <span class="strategie-wechsel"></span><br>
            Gewinnchance beim Beibehalten der Strategie: <span class="selbe-strategie"></span><br>
            Anzahl der gewonnenen Autos: <span class="autos"></span><br>
            Anzahl der Ziegen: <span class="ziegen"></span>
        </div>
        <script src="./resultJS.js"></script>
    </body>
</html>
