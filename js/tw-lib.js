



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

