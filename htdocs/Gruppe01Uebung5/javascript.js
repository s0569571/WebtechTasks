function caller(){
    var msgController = new MessageController();
    if(typeof checkName("name") === 'string'){
        msgController.writeMsg(checkName("name"));
    }
    if(typeof checkPLZ("postleitzahl") === 'string'){
        msgController.writeMsg(checkPLZ("postleitzahl"));
    }
    if(typeof checkStadt("stadt") === 'string'){ 
        msgController.writeMsg(checkStadt("stadt"));
    }
    if(typeof checkStrasse("strasse") === 'string'){
        msgController.writeMsg(checkStrasse("strasse"));
    }
    if(typeof checkHausnummer("hausnummer") === 'string'){
        msgController.writeMsg(checkHausnummer("hausnummer"));
    }
    if(typeof checkIBAN("iban") === 'string'){
        msgController.writeMsg(checkIBAN("iban"));
    }
    if(typeof checkGeldbetrag("geldbetrag") === 'string'){
        msgController.writeMsg(checkGeldbetrag("geldbetrag"));
    }
    
    if((checkName("name") === true) && (checkPLZ("postleitzahl") === true) && 
            (checkStadt("stadt") === true) && 
           (checkStrasse("strasse") === true) && 
           (checkHausnummer("hausnummer") === true) &&
           (checkIBAN("iban") === true) && (checkGeldbetrag("geldbetrag") === true)){
       msgController.clearMsg();
    }
    
}

function checkName(name){
    var name_array = document.getElementById(name).value.trim().split(' ');
    var vorname = name_array[0];
    var nachname = name_array[1];
        
    if(((vorname === undefined) || (vorname.length < 1)) || ((nachname === undefined) || (nachname.length < 1))){
        return "Bitte gueltigen Vor- und Nachnamen, getrennt von einem Leerzeichen, eingeben.";
    }else if(vorname.length > 30){
        return "Vorname ist zu lang.";
    }else if(nachname.length > 30){
        return "Nachname ist zu lang.";
    }else{
        return checkNameMitPattern(vorname, nachname);
    }
}

function checkNameMitPattern(vorname, nachname){    

    var vorname_pattern = /^[A-Z]{1}(([-][A-Z])?[a-z]{1,})+$/g;
    var nachname_pattern = /^[A-Z]{1}((['-][A-Z])*[a-z]{1,})+$/g;
        
    if((vorname !== null) && (vorname_pattern.test(vorname) === true)){
        if((nachname !== null) && (nachname_pattern.test(nachname) === true) && (checkNachnameApostroph(nachname) === true)){
            return true;
        }else{
            return "Bitte geben Sie einen gueltigen Nachnamen an.";
        }
    }else{
        return "Bitte geben Sie einen gueltigen Vornamen an.";
    }
}

function checkNachnameApostroph(nachname){
    var nachname_apostroph_counter = (nachname.match(/'/g) || []).length;
    
    if((nachname_apostroph_counter > 1)){

        var nachname_index = nachname.indexOf("'");
        while(nachname_apostroph_counter > 0){
            if(nachname_index !== -1){
                if((nachname.charAt(nachname_index-1)) === (nachname.charAt(nachname_index-1).toLowerCase())){
                    return "Bitte achten Sie auf die Groß- und Kleinschreibung bei Ihrem Nachnamen.";
                }
            }
            nachname_apostroph_counter--;
            nachname_index = nachname.indexOf("'", nachname_index+1);
        }
    }
    return true;
}

function checkPLZ(plz){
    var element_plz = document.getElementById(plz).value.trim();
    
    var plz_pattern = /^\d\d\d\d\d$/g;
    
    if((element_plz === undefined) || (element_plz.length < 1)){
        return "Bitte eine gueltige fuenfstellige Postleitzahl angeben.";
    }
    
    if((element_plz !== null) && (plz_pattern.test(element_plz))){
        return true;
    }else{
        return "Bitte eine gueltige fuenfstellige Postleitzahl angeben.";
    }
}

function checkStadt(stadt){
    var value_stadt = document.getElementById(stadt).value.trim();
    
    var stadt_pattern = /^[A-Z]{1}(([ ][a-zA-Z ])?[a-z]{1,})+$/g;
    
    if((value_stadt === undefined) || (value_stadt.length < 1)){
        return "Bitte eine gueltige Stadt angeben.";
    }
    
    if((value_stadt !== null) && (value_stadt.length < 30)){
        if(stadt_pattern.test(value_stadt)){
            return true;
        }else{
            return "Bitte eine gueltige Stadt angeben.";
        }
    }else{
        return "Name der Stadt ist zu lang.";
    }
}

function checkStrasse(strasse){
    var value_strasse = document.getElementById(strasse).value.trim();
    
    var strasse_pattern = /^[A-Z]{1}(([ ][A-Z ])?[a-z]{1,})+$/g;
    
    if((value_strasse === undefined) || (value_strasse.length < 1)){
        return "Bitte eine gueltige Strasse angeben.";
    }
    
    if((value_strasse !== null) && (value_strasse.length < 30)){
        if(strasse_pattern.test(value_strasse)){
            return true;
        }else{
            return "Bitte eine gueltige Strasse angeben.";
        }
    }else{
        return "Name der Strasse ist zu lang.";
    }
}

function checkHausnummer(hausnummer){
    var value_hausnummer = document.getElementById(hausnummer).value.trim();
    
    var hausnummer_pattern = /^\d{1,}[a-zA-Z]{0,1}$/g;
    
    if((value_hausnummer === undefined) || (value_hausnummer.length < 1)){
        return "Bitte eine gueltige Hausnummer angeben.";
    }
    
    if((value_hausnummer !== null) && (value_hausnummer.length < 15)){
        if(hausnummer_pattern.test(value_hausnummer)){
            return true;
        }else{
            return "Bitte eine gueltige Hausnummer angeben.";
        }
    }else{
        return "Angegebene Hausnummer ist zu lang.";
    }
}

function checkIBAN(iban){
    var value_iban = document.getElementById(iban).value.trim();
    
    var iban_pattern = /^[A-Z]{2}([0-9]\s*){20}$/g;
    
    if((value_iban === undefined) || (value_iban.length < 1)){
        return "Bitte eine gueltige IBAN angeben.";
    }
    
    value_iban = value_iban.replace(/\s/g, '');
    
    if((value_iban !== null) && (value_iban.length === 22)){
        if(iban_pattern.test(value_iban)){
            return true;
        }else{
            return "Bitte eine gueltige IBAN (22 Stellen) angeben.";
        }
    }else{
        return "Bitte eine gueltige IBAN (22 Stellen) angeben.";
    }
}

function checkGeldbetrag(geldbetrag){
    var value_geldbetrag = document.getElementById(geldbetrag).value.trim();
    
    var geldbetrag_pattern = /^[0-9]+(\,[0-9]{1,2})?$/g;
    
    if((value_geldbetrag === undefined) || (value_geldbetrag.length < 1)){
        return "Bitte einen gueltigen Betrag angeben.";
    }
    
    if((value_geldbetrag !== null) && (value_geldbetrag.length < 20)){
        if(geldbetrag_pattern.test(value_geldbetrag)){
            return true;
        }else{
            return "Bitte einen gueltigen Geldbetrag angeben.";
        }
    }else{
        return "Bitte einen gueltigen Geldbetrag angeben. Beachten Sie die Laenge Ihrer Eingabe.";
    }
}

class MessageController {
    constructor(){
        this.message_height = 0;
        this.message_counter = 0;
        this.element_message = document.getElementById("messages");
        this.elementCSSInit();
    }
    
    elementCSSInit(){
        this.element_message.style.position = "relative";
        this.element_message.style.margin = "auto";
        this.element_message.style.width = "60%";
        this.element_message.style.top = "30em";
        this.element_message.style.textAlign = "center";
    }
    
    
    writeMsg(message){
        this.message_counter = this.message_counter + 1;

        if(this.message_counter === 1){
            this.message_height = 3;
            this.element_message.style.borderStyle = "solid";
            this.element_message.style.borderColor = "red";
            this.element_message.style.height = this.message_height + "em";
            this.element_message.innerHTML = message;
        }else if((this.message_counter === 3) || (this.message_counter === 5) || 
                (this.message_counter === 7)){
            this.message_height = this.message_height + 2; 
            this.element_message.style.height = this.message_height + "em";
        }
        if(this.message_counter !== 1){
            this.element_message.innerHTML = this.element_message.innerHTML + "<br>" + message;
        }
    }
    
    clearMsg(){
        this.element_message.innerHTML = '';
        this.element_message.style.borderStyle = "none";
        this.message_height = 0;
        this.element_message.style.height = this.message_height + "em";
    }
}