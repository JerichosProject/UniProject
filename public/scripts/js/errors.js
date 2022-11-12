function error_cannotread() {
    Swal.fire('Error!','Could not decrpt returned data!','error');
}

function error_erroroccured(string) {
    let append='';
    if(isJSON(string)&&string.message!=undefined&&string.message!='') append=string.message;
    Swal.fire('Error!','An error occured, cannot proceed!'+(append!=''?' Message: '+append:''),'error');
}

function error_errordatanotval(string) {
    Swal.fire('Error!','Data cannot be read!','error');
}