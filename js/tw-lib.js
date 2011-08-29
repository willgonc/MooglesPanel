
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
    elem.parent().children('.tw-msg-' + estado).remove();
    elem.parent().append('<div class="tw-msg-' + estado + '">' + msg + '</div>');
}

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
    }
    var email = $('input[name=email]');
    var senha = $('input[name=senha]');
    $('input[name=email], input[name=senha]').keypress(function (e){
        if (e.keyCode == 13)
            _logar();
    });
    $('#btn-submit-login').bind('click', function (){
        _logar();
    });
}


function initListUsuarios(){
    $('#okAcoesListagem').click(function (){
        var valor = $('#acoesListagem').val();
        var check = $('.checkboxListagem:checked');
        var arrData = [];

        for (var i = 0; i < check.length; i++)
            arrData[i] = check.eq(i).val();

        if (valor == 'del'){
            $.post(
                'remove_usuario.php',
                {usuarios: arrData},
                function (d){
                    eval('var d = '+ d);
                    var url = window.location.href;
                    if (d.erro == 1){
                        if (getQueryVariable('msg')){

                            var query = window.location.search.substring(1);
                            var vars = query.split("&");
                            var newUrl = '';
                            for (var i = 0; i < vars.length; i++) {
                                if(vars[i].indexOf('msg') == -1){
                                    newUrl += vars[i]; 
                                }
                            }
                            window.location = url + '&msg=' + escape(d.msg);
                        } else {
                            if (window.location.href.indexOf("?") == -1)
                                window.location = url + '?msg=' + escape(d.msg);
                            else
                                window.location = url + '&msg=' + escape(d.msg);
                        }
                    } else {
                        if (getQueryVariable()){

                        } else {
                            window.location = window.location.href + '&msg=' + d[1];
                        }
                    }  
                }
            );
        } else if (valor == 0) {
            $.post(
                'status_usuario.php',
                {usuarios: arrData, estado: 0},
                function (d){
                    eval('var d = '+ d);
                    var url = window.location.href;
                    if (d.erro == 1){
                        if (getQueryVariable('msg')){

                            var query = window.location.search.substring(1);
                            var vars = query.split("&");
                            var newUrl = '';
                            for (var i = 0; i < vars.length; i++) {
                                if(vars[i].indexOf('msg') == -1){
                                    newUrl += vars[i]; 
                                }
                            }
                            window.location = url + '&msg=' + escape(d.msg);
                        } else {
                            if (window.location.href.indexOf("?") == -1)
                                window.location = url + '?msg=' + escape(d.msg);
                            else
                                window.location = url + '&msg=' + escape(d.msg);
                        }
                    } else {
                        if (getQueryVariable()){

                        } else {
                            window.location = window.location.href + '&msg=' + d[1];
                        }
                    }  
                }
            );
        } else if (valor == 1){
            $.post(
                'status_usuario.php',
                {usuarios: arrData, estado: 1},
                function (d){
                    eval('var d = '+ d);
                    var url = window.location.href;
                    if (d.erro == 1){
                        if (getQueryVariable('msg')){

                            var query = window.location.search.substring(1);
                            var vars = query.split("&");
                            var newUrl = '';
                            for (var i = 0; i < vars.length; i++) {
                                if(vars[i].indexOf('msg') == -1){
                                    newUrl += vars[i]; 
                                }
                            }
                            window.location = url + '&msg=' + escape(d.msg);
                        } else {
                            if (window.location.href.indexOf("?") == -1)
                                window.location = url + '?msg=' + escape(d.msg);
                            else
                                window.location = url + '&msg=' + escape(d.msg);
                        }
                    } else {
                        if (getQueryVariable()){

                        } else {
                            window.location = window.location.href + '&msg=' + d[1];
                        }
                    }  
                }
            );
        }
    });

    $('#checkAll').click(function (){
        if(this.checked == true){
            $(".checkboxListagem").each(function() { 
                this.checked = true; 
            }).parent().parent().css({
                'background':'rgb(230,230,230)'    
            });
        } else {
            $(".checkboxListagem").each(function() { 
                this.checked = false; 
            }).parent().parent().css({
                'background':'rgb(255,255,255)'    
            });
        }
    });

    $(".checkboxListagem").click(function() { 
        if(this.checked == true){
            $(this).parent().parent().css({
                'background':'rgb(230,230,230)'    
            });
        } else {
            $(this).parent().parent().css({
                'background':'rgb(255,255,255)'    
            });
        }
    });

}
