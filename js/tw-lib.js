
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


function requerido(str){
    if (str == '' || str == undefined || str == null || str.length == 0)
        return false;
    else
        return true;
}

function exibeMsgFormElem(elem, msg, estado){
    elem.parent().children('.tw-msg-' + estado).remove();
    elem.parent().append('<div class="tw-msg-' + estado + '">' + msg + '</div>');
}




/*var reEmail1 = /^[\w!#$%&'*+\/=?^`{|}~-]+(\.[\w!#$%&'*+\/=?^`{|}~-]+)*@(([\w-]+\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
var reEmail2 = /^[\w-]+(\.[\w-]+)*@(([\w-]{2,63}\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
var reEmail3 = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
var reEmail = reEmail3;

function doEmail(pStr, pFmt)
{
    eval("reEmail = reEmail" + pFmt);
    if (reEmail.test(pStr)) {
        alert(pStr + " é um endereço de e-mail válido.");
    } else if (pStr != null && pStr != "") {
        alert(pStr + " NÃO é um endereço de e-mail válido.");
    }
} // doEmail



doEmail(this.txtEmail.value, this.selEmail.value); 
*/





function initLogin (){
    var email = $('input[name=email]');
    var senha = $('input[name=senha]');

    $('#btn-submit-login').bind('click', function (){
        if (requerido(email.val()) && requerido(senha.val())){
            exibeMsgFormElem(email, '', 'erro');
            exibeMsgFormElem(senha, '', 'erro');
            if (validaEmail(email.val())){
                $('.load').show();
                $.post(
                    'logar.php',
                    {'email': email.val(), 'senha': senha.val()},
                    function (d){
                        if (d){
                            window.location = 'resumo.php';
                            $('.load').hide();
                        }else{
                            $('#msgRespota').html('Usu&aacute;rio ou senha incorretos!');
                            $('.load').hide();
                        }
                    }
                );
            } else {
                exibeMsgFormElem(email, 'Este n&atilde;o &eacute; um email v&aacute;lido', 'erro');
            }
        } else { 
            if (!requerido(email.val()))
                exibeMsgFormElem(email, 'Preencha este campo!', 'erro');
            if (!requerido(senha.val()))
                exibeMsgFormElem(senha, 'Preencha este campo!', 'erro');
        }
    });
}
