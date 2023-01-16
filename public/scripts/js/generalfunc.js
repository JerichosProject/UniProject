function logout() {
    $.post('/scripts/home.php',{type:'session_logout'},function(data) {
        if(debug) console.log(data);
        if(!isJSON(data)) {error_cannotread();return;}
        data=JSON.parse(data);
        if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
        initaliseHome();
    });
}   