
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


function initListUsuarios(){
    $('#deletar').click(function (){
        var check = $('.checkboxListagem:checked?');
        if (check.length >= 1){
            if (confirm(check.length == 1?"Você deseja deletar este usuário":"Você deseja deletar estes usuários")){
                var arrData = [];

                for (var i = 0; i < check.length; i++)
                    arrData[i] = check.eq(i).val();
                
                $.post(
                    'remove_users.php',
                    {
                        usuarios: arrData, 
                        pag: getQueryVariable('pag')?getQueryVariable('pag'):'', 
                        busca: getQueryVariable('busca')?getQueryVariable('busca'):''
                    }, function (d){
                        window.location = d;
                    }
                );
            }
        } else if (check.length == 0){
            alert('Nenhum usuário foi selecionado!');
        }
    });

    $('#ativar').click(function (){
        var check = $('.checkboxListagem:checked?');
        if (check.length >= 1){
            if (confirm(check.length == 1?"Você deseja ativar este usuário":"Você deseja ativar estes usuários")){
                var arrData = [];

                for (var i = 0; i < check.length; i++)
                    arrData[i] = check.eq(i).val();
                
                $.post(
                    'status_users.php',
                    {
                        usuarios: arrData, 
                        pag: getQueryVariable('pag')?getQueryVariable('pag'):'', 
                        busca: getQueryVariable('busca')?getQueryVariable('busca'):'',
                        estado: 1
                    }, function (d){
                        window.location = d;
                    }
                );
            }
        } else if (check.length == 0){
            alert('Nenhum usuário foi selecionado!');
        }
    });

    $('#bloquear').click(function (){
        var check = $('.checkboxListagem:checked?');
        if (check.length >= 1){
            if (confirm(check.length == 1?"Você deseja bloquear este usuário":"Você deseja bloquear estes usuários")){
                var arrData = [];

                for (var i = 0; i < check.length; i++)
                    arrData[i] = check.eq(i).val();
                
                $.post(
                    'status_users.php',
                    {
                        usuarios: arrData, 
                        pag: getQueryVariable('pag')?getQueryVariable('pag'):'', 
                        busca: getQueryVariable('busca')?getQueryVariable('busca'):'',
                        estado: 0
                    }, function (d){
                        window.location = d;
                    }
                );
            }
        } else if (check.length == 0){
            alert('Nenhum usuário foi selecionado!');
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



function initMenu(){
    $('.item-menu').mouseover(function (){
        $(this).children('.submenu').show();
    }).mouseout(function (){
        $(this).children('.submenu').hide();
    });
}
