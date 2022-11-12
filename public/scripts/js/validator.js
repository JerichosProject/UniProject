function isJSON(string) {
    if($.isPlainObject(string)) return true;
    return (string.substring(0,1)=='{'?true:false);
}

function isJSONSuccess(string) {
    if(!isJSON(string)) return false;
    if(string.result==undefined||string.result!=1) return false;
    return true;
}

function isDataValid(string) {
    if(!isJSON(string)) return false;
    if(!isJSONSuccess(string)) return false;
    if(string.data==undefined) return false;
    return true;
}
function isJSONDataValid(string) {
    if(!isDataValid(string)) return false;
    string=string.data;
    if(!$.isArray(string)&&!$.isPlainObject(string)) return false;
    return true;
}