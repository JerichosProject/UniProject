function logout() {
    $.post('/scripts/home.php',{type:'session_logout'},function(data) {
        if(debug) console.log(data);
        if(!isJSON(data)) {error_cannotread();return;}
        data=JSON.parse(data);
        if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
        window.location.href="/home";
        // initaliseHome();
    });
}

function updateURL(url) {
    var newurl = window.location.protocol + "//" + window.location.host + '/' + url;
    window.history.pushState({path:newurl},'',newurl);
}
window.addEventListener('popstate', function(event) {
    getWindowPane();
}, false);