var wahlMarkieren;
var ersteWahl;

function closeDoors(){
    for(var i = 0; i < 3; i++){
        document.getElementById("tuer" + i).src = "./images/doorQuestion.jpg";
        document.getElementById("tuer" + i).className = "closed";
    }
}


function displayStatsChange(value){
    var strategieWechsel = document.getElementsByClassName("strategie-wechsel");    
    for(var i = 0; i < strategieWechsel.length; i++){
        strategieWechsel[i].innerHTML = value + "%";
    }
}

function displayStatsKeep(value){
    var selbeStrategie = document.getElementsByClassName("selbe-strategie");
    for(var i = 0; i < selbeStrategie.length; i++){
        selbeStrategie[i].innerHTML = value + "%";
    }
}

function displayAutos(value){
    var autos = document.getElementsByClassName("autos");
    for(var i = 0; i < autos.length; i++){
        autos[i].innerHTML = value;
    }
}

function displayZiegen(value){
    var ziegen = document.getElementsByClassName("ziegen");
    for(var i = 0; i < ziegen.length; i++){
        ziegen[i].innerHTML = value;
    }
}

function getStats(value = null){
    if(value !== null){
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "./action.php?stats=" + value, true);

        ajax.onreadystatechange = function(){
            if((this.readyState === 4) && (this.status === 200)){
                if(value === "change"){
                    displayStatsChange(this.responseText);
                }else if(value === "keep"){
                    displayStatsKeep(this.responseText);
                }else if(value === "ziegen"){
                    displayZiegen(this.responseText);
                }else if(value === "autos"){
                    displayAutos(this.responseText);
                }
            }
        };
        ajax.send();
    }
}

function gameInit(){
    closeDoors();
    var msg = document.getElementById("messages");
    msg.style.color = "black";
    msg.innerHTML = "W&auml;hlen Sie eine T&uuml;r aus.";
    getStats("change");
    getStats("keep");
    getStats("autos");
    getStats("ziegen");
}

function endGame(){
    window.open('http://localhost/Gruppe01Uebung6/result.php', '_self');
}

function showGoat(id){
    var tuer = document.getElementById(id);
    tuer.src = "./images/doorGoat.jpg";
    tuer.className = "goat";
}

function printSuccessMessage(success){
    var msg = document.getElementById("messages");
    msg.style.color = "black";
    if(success == 1){
        msg.innerHTML = "<span class='win-msg'>Sie haben gewonnen</span>";
    }else if(success == 0){
        msg.innerHTML = "<span class='lose-msg'>Ooohh, Sie haben <br>leider verloren</span>";
    }
}

function openAll(success){
    var tmpBild;

    if(success == 1){
        tmpBild = document.getElementsByClassName("open");
        tmpBild[0].src = "./images/doorCar.jpg";
        if((document.getElementsByClassName("first")[0] !== null) && 
                (typeof document.getElementsByClassName("first")[0] !== "undefined")){
            document.getElementsByClassName("first")[0].src = "./images/doorGoat.jpg";
        }else if((document.getElementsByClassName("closed")[0] !== null) && 
                (typeof document.getElementsByClassName("closed")[0] !== "undefined")){
            document.getElementsByClassName("closed")[0].src = "./images/doorGoat.jpg";
        }

    }else if(success == 0){
        tmpBild = document.getElementsByClassName("open");
        tmpBild[0].src = "./images/doorGoat.jpg";
        if((document.getElementsByClassName("first")[0] !== null) && 
                (typeof document.getElementsByClassName("first")[0] !== "undefined")){
            
            document.getElementsByClassName("first")[0].src = "./images/doorCar.jpg";
        }else{
            document.getElementsByClassName("closed")[0].src = "./images/doorCar.jpg";
        }
    }
    printSuccessMessage(success);
}

function printErrorMessage(){
    document.getElementById("messages").style.color = "red";
    document.getElementById("messages").innerHTML = "Diese T&uuml;r kann <br> <b>nicht</b> gew&auml;hlt werden !";
}

function checkResponse(resp){
  var tmp = resp;
    if(tmp.includes("kann nicht")){
        printErrorMessage();
    }else if(tmp.includes("tuer") && (tmp.length === 5)){
        showGoat(tmp);
    }else{
        openAll(tmp);
    }
}

function wahlMarkieren(id){
    var setFirst = true;
    var setOpen = true;
    
    if(document.getElementById(id).className == "goat"){
        return false;
    }
    
    for(var i = 0; i < 3; i++){
        if(document.getElementById("tuer" + i).className === "first"){
            setFirst = false;
        }
        if(document.getElementById("tuer" + i).className === "open"){
            setOpen = false;
        }
    }
    if(setFirst){
        document.getElementById(id).className = "first";
    }else if(setOpen){
        document.getElementById(id).className = "open";
    }
    return true;
}

function tuerOeffnen(id){
    if(wahlMarkieren(id)){
        var params = "choice=" + id;
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "./action.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("x_requested_with", "8");

        ajax.onreadystatechange = function(){
            if((this.readyState === 4) && (this.status === 200)){
                checkResponse(this.responseText);
            }
        };
        ajax.send(params);
    }else{
        printErrorMessage();
    }
}