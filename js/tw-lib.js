


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

function initCategories(){
    $('#adicionar').click(function (){
        //var nomeCategoria = prompt("Nome da categoria");
        criaModal({
            width: 300, 
            height: 250, 
            conteudo: 'Nome da categoria: <imput type="nome" size="30" />'+
                ''
        });/*
        $.post(
            'save_category.php',
            {
                nome: nomeCategoria
            }, function (d){
                window.location = d;
            }
        );*/
    });
}

