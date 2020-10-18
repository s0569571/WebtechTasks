function sendMsgToServer(msg){
    var url = "http://localhost/Gruppe01Uebung7/action.php";
    var ajax = new Ajax(url);
    ajax.send(msg);
    var obj = ajax.receive();
    ajax.disconnect();
    
    writeReceivedMsg(obj);
}

/*
 * wenn weniger als drei Personen gleichzeitig chatten, sondern nur zwei in einem Raum
 */
function hideSecondPerson(){
    var person2 = document.getElementById("person2");
    person2.style.visibility = "hidden";
}

function login(){
    var params = {"element": "text0", "msg": "Hier bin ich"};
    sendMsgToServer(params);
}

function logout(){
    var params = {"element": "text0", "msg": "Dann bin ich mal weg", "session": "end"};
    sendMsgToServer(params);
    window.open("http://localhost/Gruppe01Uebung7", "_self");
}

function receiver0(json){
    var receiver = document.getElementById("receiver0");
    if(json.msg != ''){
        var text = "" + receiver.innerHTML;
        receiver.innerHTML = text + "<br>" +
                "<span id='person-hervorheben'>" + json.sender + ":</span>" + "<br>" + json.msg;
    }

}

function receiver1(json){
    var receiver = document.getElementById("receiver1");
    if(json.msg != ''){
        var text = "" + receiver.innerHTML;
        receiver.innerHTML = text + "<br>" +
                "<span id='person-hervorheben'>" + json.sender + ":</span>" + "<br>" + json.msg;
    }
    
}

function receiver2(json){
    var receiver = document.getElementById("receiver2");
    if(json.msg != ''){
        var text = "" + receiver.innerHTML;
        receiver.innerHTML = text + "<br>" +
                "<span id='person-hervorheben'>" + json.sender + ":</span>" + "<br>" + json.msg;
    }
}

function writeReceivedMsg(json){
    if((json.firstElement === '0') || (json.secondElement === '0')){
        receiver0(json);
    }
    if((json.firstElement === '1') || (json.secondElement === '1')){
        if(json.zweiPersonen === true){
            receiver1(json);
        }else{
            hideSecondPerson();
        }
    }
    if((json.firstElement === '2') || (json.secondElement === '2')){
        receiver2(json);
    }
}

function readTypedMsg(name){
    var params = null;
    var timeout = null;
    
    var textarea = document.getElementsByName(name);
    
    textarea[0].addEventListener('keyup', function(){
    
        clearTimeout(timeout);

        timeout = setTimeout(function(){

            params = {"element": name, "msg": textarea[0].value};
            textarea[0].value = "";
            textarea[0].blur();
            sendMsgToServer(params);
        }, 2000);
    });
}