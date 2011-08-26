<?php

require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

$titulo =       $_POST['titulo'];
$status =       $_POST['status'];
$resumo =       $_POST['resumo'];
$categoria =    $_POST['categoria'];
$texto =        $_POST['texto'];
$data =         $_POST['data'];
$tags =         $_POST['tags'];
$autor =        $_SESSION['data']['usuario'];

/* 
 *  iniciando flag de erro
 */
$flagErro = true;
$msg = '';


if (strRequire($titulo) == false)
{
    $flagErro = false;
    $msg = 'Preencha todos os campos!';
}

if (strRequire($categoria) == false)
{
    $flagErro = false;
    if ($msg == '')
        $msg = 'Nenhuma categoria foi selecionada! ';
}

/*
 *  Validando a url
 */
if (strRequire($thumb) == true)
{
    if (validaUrl($thumb) == false)
    {
        $flagErro = false;
        if ($msg == '')
            $msg = 'Url da imagem do post inv&aacute;lida! ';
    }
}

if (strRequire($tags) == true)
{
    if (validaAlphaNumString($tags) == false)
    {
        $flagErro = false;
        if ($msg == '')
            $msg = 'Url da imagem do post iv&aacute;lida! ';
    }
}


/*
 *  Verificando se já existe um post com este título esta cadastrado
 */
if ($flagErro)
{
    try
    {
        $result = mysql_query("SELECT * FROM posts WHERE titulo='".$titulo."'");
        if ($result)
        {
            if (mysql_num_rows($result) > 0)
            {
                $flagErro = false;
            }
        }
        else
        {
            $flagErro = false;
        }
    }
    catch ( Exception $e )
    {
        $flagErro = false;
    }
}

if (!$flagErro)
{
    if ($msg == '')
        $msg='J&aacute; existe um post com este t&iacute;tulo cadastrado! ';
}


if ($flagErro)
{
    /* 
     *  FORMATANADO A URL
     */
    $nome_url = strtolower( $nome ); // passando para minusculo
    $nome_url = preg_replace( '/\ /', '-', $nome_url ); // trocando espacos por -
    $nome_url = rmCarac( $nome_url ); // removendo caracteres epeciais
    $nome_url = removeAcentos(htmlentities($nome_url, ENT_QUOTES, "UTF-8")); // removendo acentos

    $url = strtolower( $titulo ); // passando para minusculo
    $url = preg_replace( '/\ /', '-', $url ); // trocando espacos por -
    $url = rmCarac( $url ); // removendo caracteres epeciais
    $url = removeAcentos(htmlentities($url, ENT_QUOTES, "UTF-8")); // removendo acentos
    
    $titulo = htmlentities( trim( $titulo ), ENT_QUOTES, "UTF-8" );
    $resumo = htmlentities( trim( $resumo ), ENT_QUOTES, "UTF-8" );

    try{
        // FAZ A INSERCAO NA BASE
        $insert = mysql_query("INSERT INTO posts (titulo, texto, resumo, data, hora, status, thumb, categoria, tags, autor, url) VALUES 
            ('".$titulo."', '".$texto."', '".$resumo."', '".$data."', '".$hora."', '".$status."', '".$thumb."', ".$categoria.", '".$tags."', '".$autor."', '".$url."')");
        
        // VERIFICA SE A INSERCAO FOI FEITA
        if ($insert)
        {
            if ($msg == '')
                $msg='Post adicionado com sucesso!';
        } 
        else
        {
            $flagErro = false;
            if ($msg == '')
                $msg=' Erro ao adicionar o post!';
        }
    } catch(Exception $e){
        $flagErro = false;
        if ($msg == '')
            $msg=' Erro ao adicionar o post!';
    }
}

if ($flagErro == false)
    header("Location: novo_post.php?msg=".urlencode('<p class="errorMsg">'.$msg.'</p>'));
else
    header("Location: editar_post.php?post=".mysql_insert_id()."&msg=".urlencode('<p class="okMsg">'.$msg.'</p>'));

mysql_close($conexao);
?>
