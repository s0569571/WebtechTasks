function Ajax(url,myHandler= null) {
    var here= this;             
    this.url= url;
    this.myHandler= myHandler;
    this.method= "POST";            
    this.responseText= null;
    this.request= Ajax.prototype.newXHR();  
    this.request.onreadystatechange= function(){
        here.receivedText();
        if(myHandler!==null) {
            here.myHandler(here.request);
        }
    };
};
Ajax.prototype.disconnect= function() {
    this.request= null;
};

Ajax.prototype.newXHR= function() {
    var req= null;
    if (typeof XMLHttpRequest !== "undefined") {
        req= new XMLHttpRequest(); 
    } else {
        if (typeof ActiveXObject !== "undefined") {
            req= new ActiveXObject("Microsoft.XMLHTTP");
            if (!req) {
                req= new ActiveXObject("Msxml2.XMLHTTP");
            }
        } else {
            Ajax.prototype.ErrorHandler("cant create XMLHttpRequest-Object");
        }
    }
    return req;
};
Ajax.prototype.codeParams= function(params) {
    var str= "";
    var amper= false;
    for(var p in params) {
        if(amper) {
            str+= "&";
        }
        str+= encodeURI(p)+"="+encodeURI(params[p]);
        amper= true;
    }
    return str;
};
Ajax.prototype.ErrorHandler= function(errMsg,doThrow= true) {
    if(typeof writeln !== "undefined") {
        writeln(errMsg);
    } else {
        console.log(errMsg);
    }
    if(doThrow) {
        throw errMsg;
    }
};
Ajax.prototype.onError= function(obj,err= '') {
    var str  = "Ajax communication error "+err+"\n";
    str += "URL="+obj.url+"\n";
    if (typeof obj.request !== "undefined") {
        str += "XHR-state="+obj.request.readyState+"\n";
        str += "HTTP-status code="+obj.request.status+"\n";
        str += "Headers=\n***\n"+obj.request.getAllResponseHeaders()+"***";
    }
    Ajax.prototype.ErrorHandler(str);
};
Ajax.prototype.receivedText= function() {
    if(this.request.readyState!==4) {
        return;
    }
    if (this.request.status!==200) {
        if(this.request.status===404) {
            Ajax.prototype.ErrorHandler("404 Not Found: "+this.url);
        } else {
            this.onError(this);
        }
    }
};
Ajax.prototype.sendRequest= function(url, params= null, method= "POST"){
    try {
        this.responseText= null;
        this.request.open(method,url,false);
        this.request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        this.request.setRequestHeader("x_requested_with","42");
        if(typeof params==="object") {
            this.request.send(this.codeParams(params));
        } else {
            this.request.send();
        }
    } catch (err) {
        Ajax.prototype.ErrorHandler(err);
    }
};  
Ajax.prototype.send= function(msg= null) {
    this.sendRequest(this.url, msg, this.method,false);
};
Ajax.prototype.receive= function(filter= null) {
    var received= {};
    var text= this.request.responseText;
    if(text===null) {
        Ajax.prototype.ErrorHandler("no text received");
    }
    try {
        var PHPabort= (text[0]!=='{')||(text[text.length-1]!=='}');
        if(PHPabort) {
            PHPabort= (text.indexOf("Stack trace")!==-1);
            if (!PHPabort) {
                var first= text.indexOf('{');
                var last= text.lastIndexOf('}');
                var prefix= text.substring(0,first);
                var postfix= ''+text.substring(last+1);
                if(prefix!=='') {
                    Ajax.prototype.ErrorHandler('prefix='+prefix, false);
                }
                if(postfix!=='') {
                    Ajax.prototype.ErrorHandler('postfix='+prefix, false);
                }
                text= text.substring(first,last+1);
            }
        }
        if((text==='')||(text===null)||PHPabort) {
            if(text!=='') {
                Ajax.prototype.ErrorHandler(text);
            }
            received= null;
            Ajax.prototype.ErrorHandler("received empty message - abort");
        }
        if(filter===null) {
            received= JSON.parse(text);
        } else {
            var obj= JSON.parse(text);
            for (var elem in filter) {
                if(obj[elem]===undefined) {
                    Ajax.prototype.ErrorHandler("missed received value: "+elem,false);
                } else {
                    received[elem]= obj[elem];
                    delete obj[elem];
                }
            }
            for (var elem in obj) {
                Ajax.prototype.ErrorHandler("wrong received value: "+elem,false);
            }
        }
    } catch (err) {
        Ajax.prototype.ErrorHandler(err);
    }
    return received;
};