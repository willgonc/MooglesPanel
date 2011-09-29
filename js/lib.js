/*
 *  Valida email
 */

function validaEmail(email){
    var reEmail = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
    if (reEmail.test(email))
        return true;
    else if (email != null && email != "")
        return false;
    else
        return false;
}

function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}

function requerido(str){
    if (str == '' || str == undefined || str == null || str.length == 0)
        return false;
    else
        return true;
}

function exibeMsgFormElem(elem, msg, estado){
    $('.msg-login').remove();
    elem.parent().append('<div class="msg-login" style="color: red">' + msg + '</div>');
}

