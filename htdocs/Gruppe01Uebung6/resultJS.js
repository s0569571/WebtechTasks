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

function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

function endSession(){
    var params = "end=" + "game";
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "./action.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.setRequestHeader("x_requested_with_end", "8");

    ajax.onreadystatechange = function(){
        if((this.readyState === 4) && (this.status === 200)){
        }
    };
    ajax.send(params);
}

function displayStats(){
    getStats("change");
    getStats("keep");
    getStats("autos");
    getStats("ziegen");
    wait(2000);
    endSession();
}