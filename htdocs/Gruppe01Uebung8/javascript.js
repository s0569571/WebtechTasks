function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

function getAjax(){
    var ajax = null;
    if (typeof XMLHttpRequest !== "undefined") {
        ajax= new XMLHttpRequest(); 
    } else {
        if (typeof ActiveXObject !== "undefined") {
            ajax= new ActiveXObject("Microsoft.XMLHTTP");
            if (!ajax) {
                ajax= new ActiveXObject("Msxml2.XMLHTTP");
            }
        } else {
            console.log("Error: cant create XMLHttpRequest-Object");
        }
    }
    return ajax;
}

function sendRequest(params){
    var ajax = getAjax();
    ajax.url = "http://localhost/Gruppe01Uebung8/action.php";  
    var response = null;
    try{
        ajax.open("POST", ajax.url, false);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("x_requested_with", "8");

        ajax.onreadystatechange = function(){
            if((this.readyState === 4) && (this.status === 200)){
                response = this.responseText;
            }else if(this.status !== 200){
                if(this.status === 404){
                    console.log("Error 404: " + ajax.url + " not found");
                }else{
                    ajaxErrorHandler(ajax);
                }
            }
        };
        ajax.send(params);
    }catch(err){
        console.log(err);
    }
    if(response !== null){
        return response;
    }
}

function ajaxErrorHandler(obj, err=''){
    var str  = "Ajax communication error "+err+"\n";
    str += "URL="+obj.url+"\n";
    
    str += "XHR-state="+obj.readyState+"\n";
    str += "HTTP-status code="+obj.status+"\n";
    str += "Headers=\n***\n"+obj.getAllResponseHeaders()+"***";
    
    console.log(str);
}

function scrollDown(){
    window.scrollTo(0,document.body.scrollHeight);
}

function actionAufforderung(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>M&ouml;chtest du dich bewegen oder schie&szlig;en ?";
    scrollDown();
}

function startGame(){
    var btnAction = document.getElementById("action-button-container");
    var btnDirection = document.getElementById("richtung-button-container");
    btnAction.style.visibility = "visible";
    btnDirection.style.visibility = "visible";
    actionAufforderung();
    getInfoPlayer('pfeile');
    scrollDown();
}

function spielbeschreibung(){
    var textElement = document.getElementById("text");
    var text = "Bei diesem Text-Adventure befindest du dich in einer H&ouml;hle, ";
    text += "in der sich der begehrte Schatz vom König Alfredo den achten ";
    text += "befindet. Um diesen begehrten Schatz zu finden, musst du beweisen, dass ";
    text += "du Meister der Labyrinthe bist. Au&szlig;erdem lebt in dieser H&ouml;hle ";
    text += "bereits seit Jahrzehnten ein grauenhaft riechendes Monster, welches unter ";
    text += "dem grauenvollen Namen 'Wumpus' bekannt ist. Da dieses Monster haupts&auml;chlich ";
    text += "schl&auml;ft, musst du dir keine Sorgen darum machen, dass es dich findet. Es sei denn, ";
    text += "du trittst genau in das Feld, in dem sich das Monster befindet. Dann wird es ";
    text += "ohne Gnade auffressen.<br>Um es besiegen zu k&ouml;nnen, musst du dich in ";
    text += "dieser dunklen H&ouml;hle auf deinen Geruchssinn verlassen. Wenn du es ";
    text += "riechst, solltest du es mit deinen Pfeilen erschie&szlig;en. Jedoch ";
    text += "hast du nur drei St&uuml;ck.<br>Mit deinen 5 Brotkrumen kannst du dir ";
    text += "die Orientierung ein wenig erleichtern.<br>Bewege dich bedacht, ";
    text += "hole den Schatz und kehre zum Eingang wieder zur&uuml;ck.<br>";
    text += "<span class='hinweis'>Stelle bitte sicher, dass dein Browser die automatische Wiedergabe ";
    text += "von Audio und Video zul&auml;sst.</span>";
    textElement.innerHTML = text;
    
    scrollDown();
}

function wumpusNaheMsg(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br><span id='important-msg'>Hier riecht es nach einem Wumpus...</span>";
    
    actionAufforderung();
}

function bewegenMsg(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>In welche Richtung m&ouml;chtest du dich bewegen ?";
    
    scrollDown();
}

function schiessenMsg(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>In welche Richtung m&ouml;chtest du schie&szlig;en ?";
    
    scrollDown();
}

function schatzGefundenMsg(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du hast soeben den Schatz gefunden und tr&auml;gst ihn bei dir !"
    + "<br>Nun musst du nur noch den Weg hinaus finden !";
    
    actionAufforderung();
}

function playerPositionMsg(coordinates){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du befindest dich nun in der Position " + coordinates + " !";
    
    actionAufforderung();
}

function getCurrentPosition(subject){
    var params = "position=" + subject;
    var response = sendRequest(params);
    if(subject === 'brotGefunden'){
        brotGefunden(response);
    }else if(subject === 'brotGesetzt'){
        brotGesetztMsg(response);
    }else if(subject === 'brote'){
        brotCounter(JSON.parse(response));
    }else if(subject === 'player'){
        playerPositionMsg(response);
    }
}

function brotGefunden(coordinates){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du hast eine Brotkrume gefunden!"
    + "<br>Die Position der Brotkrume: " + coordinates;
    
    scrollDown();
}

function brotBereitsVorhanden(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Hier liegt bereits eine Brotkrume!";
    
    scrollDown();
}

function restart(){
    wait(1500);
    location.reload();
    return false;
}

function brotGesetztMsg(coordinates){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du hast eine Brotkrume an deiner aktuellen Position " + coordinates + " gesetzt!";
    
    getCurrentPosition('brote');
    scrollDown();
}

function checkResponseArray(response){
    response.forEach(function(resp){
        checkResponse(resp);
    });
}

function brotCounter(coordinates){
    var brotCounter = document.getElementById("brotkrumen");
    var text = "Positionen der Brotkrumen:";
    if(coordinates !== null && Array.isArray(coordinates)){
        coordinates.forEach(function(coords){
            text = text + "<br>" + coords;
        });
    }
    brotCounter.innerHTML = text;
    
    scrollDown();
}

function pfeilCounter(pfeile = null){
    var pfeilCounter = document.getElementById("pfeile");
    var text = "<br><br>Anzahl Pfeile:";
    if(pfeile !== null){
        text = text + "<br>" + pfeile;
    }
    pfeilCounter.innerHTML = text;
    
    scrollDown();
}

function brotAufgenommen(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du hast eine Brotkrume aufgenommen";
    
    getCurrentPosition('brote');
    scrollDown();
}

function brotNichtVorhanden(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Hier liegt keine Brotkrume.";
    
    scrollDown();
}

function keinBrotMehrMsg(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du hast kein Brot mehr!"; 
    
    actionAufforderung();
}

function checkResponse(response){
    switch(parseInt(response)){
        case FEIGLING: feiglingOperations(); break;
        case GEWINNER: gewinnerOperations(); break;
        case MOVE_WAND: moveWandOperations(); break;
        case SHOOT_WAND: shootWandOperations(); break;
        case SPIELER_TOT: spielerTotOperations(); break;
        case WUMPUS_TOT: wumpusTotOperations(); break;
        case BROT_GEFUNDEN: getCurrentPosition('brotGefunden'); break;
        case BROT_GESETZT: getCurrentPosition('brotGesetzt'); break;
        case BROT_AUFGENOMMEN: brotAufgenommen(); break;
        case SESSION_UNSET: restart();break;
        case WUMPUS_NAHE: wumpusNaheMsg(); break;
        case BEWEGEN: bewegenMsg(); break;
        case SCHIESSEN: schiessenMsg(); break;
        case KEINE_PFEILE: keinePfeileOperations(); break;
        case MOVE_SUCCESS: getCurrentPosition('player'); break;
        case SCHATZ_GEFUNDEN: schatzGefundenMsg(); break;
        case BROT_BEREITS_VORHANDEN: brotBereitsVorhanden(); break;
        case BROT_NICHT_VORHANDEN: brotNichtVorhanden(); break;
        case KEINE_BROTE_GESETZT: break;
        case KEIN_BROT_MEHR: keinBrotMehrMsg(); break;
        default: break;
    }
}

function gameEnd(type){
    var params = "game=" + type;
    var response = sendRequest(params);
    if(type === "restart"){
        restart();
    }else if(type === "end"){
        feiglingOperations();
    }
}

function hideButtons(){
    var buttonBar = document.getElementById("button-container");
    var buttonBarAction = document.getElementById("action-button-container");
    var buttonBarDir = document.getElementById("richtung-button-container");
    buttonBar.style.visibility = "hidden";
    buttonBarAction.style.visibility = "hidden";
    buttonBarDir.style.visibility = "hidden";
}

function loserMessage(){
    hideButtons();
    var loserMsg = document.getElementById("msg");
    var endGameElement = document.getElementsByClassName("end-game-msg");
    var btnRestart = document.getElementById("btn-restart");
    loserMsg.innerHTML = "<br>Verloren!<br>Feigling!";
    endGameElement[0].style.visibility = "visible";
    endGameElement[0].style.backgroundColor = "red";
    btnRestart.style.visibility = "visible";
}

function winnerMessage(){
    hideButtons();
    var winnerMsg = document.getElementById("msg");
    var endGameElement = document.getElementsByClassName("end-game-msg");
    var btnRestart = document.getElementById("btn-restart");
    winnerMsg.innerHTML = "<br>Gewonnen!<br>Hurra! Du bist der Gr&ouml;&szlig;te!";
    endGameElement[0].style.visibility = "visible";
    endGameElement[0].style.backgroundColor = "green";
    btnRestart.style.visibility = "visible";
}

function loserDeadMessage(){
    hideButtons();
    var loserMsg = document.getElementById("msg");
    var endGameElement = document.getElementsByClassName("end-game-msg");
    var btnRestart = document.getElementById("btn-restart");
    loserMsg.innerHTML = "<br>Hmmm – Mampf<br>R.I.P.";
    endGameElement[0].style.visibility = "visible";
    endGameElement[0].style.backgroundColor = "red";
    btnRestart.style.visibility = "visible";
}

function playAudio(audio){
    new Audio('./sounds/' + audio + '.mp3').play();
}

function feiglingOperations(){
    playAudio('feigling');
    loserMessage();
}

function gewinnerOperations(){
    playAudio('derGroesste');
    winnerMessage();
}

function moveWandOperations(){
    playAudio('wallDamage');
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Autsch! Da ist eine Wand!";
    
    actionAufforderung();
}

function keinePfeileOperations(){
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Du hast keine Pfeile mehr!"; 
    
    actionAufforderung();
}

function shootWandOperations(){
    playAudio('arrowWall');
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Klong! Wand getroffen!"; 
    
    getInfoPlayer('pfeile');
    
    actionAufforderung();
}

function spielerTotOperations(){
    playAudio('monsterEatsPlayer');
    loserDeadMessage();
}

function wumpusTotOperations(){
    playAudio('jaul');
    var textSpiel = document.getElementById("text-spiel");
    var newText = document.getElementById("text-spiel-aktuell");
    var text = textSpiel.innerHTML + newText.innerHTML;
    textSpiel.innerHTML = text;
    newText.innerHTML = "<br><br>Jaaauuuulll! Der Wumpus ist tot!"; 
    
    getInfoPlayer('pfeile');
    
    actionAufforderung();
}

function direction(direction){
    var params = "direction=" + direction;
    var response = sendRequest(params);
    if(response.indexOf(',') !== -1){
        var split = response.split(',');
        checkResponseArray(split);
    }else{
        checkResponse(response);
    }
}

function action(action){
    var params = "action=" + action;
    var response = sendRequest(params);
    checkResponse(response);
}

function brotAction(action){
    var params = "brotAction=" + action;
    var response = sendRequest(params);
    checkResponse(response);
}

function getInfoPlayer(info){
    var params = "player=" + info;
    var response = sendRequest(params);
    if(info === 'pfeile'){
        pfeilCounter(response);
    }
}

function gameInit(){
    var params = "game=" + "init";
    var response = sendRequest(params);
    spielbeschreibung();
}