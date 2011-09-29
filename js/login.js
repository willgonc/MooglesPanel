function initLogin (){
    function _logar (){
        if (requerido(email.val()) && requerido(senha.val())){
            exibeMsgFormElem(email, '', 'erro');
            exibeMsgFormElem(senha, '', 'erro');
            if (validaEmail(email.val())){
                $('.load').show();
                $.post(
                    'logging.php',
                    {'email': email.val(), 'senha': senha.val()},
                    function (d){
                        if (d){
                            window.location = 'summary.php';
                            $('.load').hide();
                        }else{
                            $('#msgRespota').html('<div class="msg-login" style="color: red">Usu&aacute;rio ou senha incorretos!</span>');
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
    }
    var email = $('input[name=email]');
    var senha = $('input[name=senha]');
    email.focus();
    $('input[name=email], input[name=senha]').keypress(function (e){
        if (e.keyCode == 13)
            _logar();
    });
    $('#btn-submit-login').bind('click', function (){
        _logar();
    });
}

