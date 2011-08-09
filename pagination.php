<?
include "connect_db.php";

/*******************************************************************************
* Classe de Paginação
*
* Autor: Leandro  Correa dos Santos (nukelinux) <leandro.admo@gmail.com>
*
*
* exemplo de uso:
* instanciar a classe
* $pg = new pagina();
* recebe parâmetros get para paginação
* $pg->pg = $_GET['pg'];
* $pg->page = $_GET['page'];
* indica quantos registros devem ser mostrados em cada página
* $pg->fim = 5;
* esse select é utlizado para contar o número de registros desejados, por isso
* ele busca apenas o id da tabela. Pode-se adaptar para utilização da função
* count(), o que acredito deixar o script mais rápido...
* $pg->sql = "select id from tabela ";
* O método parte1 realizará o cálculo necessário para o funcionamento correto
* do paginador, atribuindo valores às variáveis $this->inicio e $this->fim,
* necessárias para a busca dos dados
* $pg->parte1();
* aqui vc deve realizar a busca dos dados que serão exibidos, aproveitando o
* resultado dos cálculos do paginador
* $res = mysql_query("select * from tabela limit $this->inicio,$this->fim");
*  a forma de mostar os resultados fica a seu critério :)
* O método parte2 exibe os números das páginas (ex : 1 2 3 próxima >> ).
* Está bem simples, sem estilos ou efeitos para facilitar a customização
* $pg->parte2();
*******************************************************************************/

class pagina
{
	var $pg, $page, $sql, $total, $url, $tp, $numreg, $inicio, $fim;

	function parte1()
	{
		if(!$this->pg){
			$this->pg = 1;
		}
		if(!$this->page){
			$this->page = 1;
		}
		try{
			$this->total = mysql_query($this->sql);
			$this->numreg = mysql_num_rows($this->total);
		}catch(Exception $e){
			echo 'exceção: ', $e->getMessage(), "\n";
		}
		if($this->numreg >= 1)
		{
			try{
				$this->tp = ceil($this->numreg/$this->fim);
				$this->inicio = $this->page - 1;
				$this->inicio = $this->inicio * $this->fim;
			}catch(Exception $E){
				echo 'exceção: ', $E->getMessage(), "\n";
			}
		}
	}

	function parte2()
	{
		//se a url do paginador não for definida, o padrão é a própria página
		if(!$this->url)
		{
			$this->url = $PHP_SELF;
		}
		for($x = 1;$x <= $this->tp;$x++)
		{
			if($this->page == $x)
			{
				echo " <a href='#'>$x</a> ";
			}
			else
			{
				echo " <a href='$this->url?page=$x'>$x</a> ";
			}
		}
	}
}



$pg = new pagina();

//recebe parâmetros get para paginação
$pg->pg = (isset($_GET['pg'])?$_GET['pg']:0);
$pg->page = (isset($_GET['page'])?$_GET['page']:0);

//indica quantos registros devem ser mostrados em cada página
$pg->fim = 10;

/*esse select é utlizado para contar o número de registros desejados, por isso
  ele busca apenas o id da tabela. Pode-se adaptar para utilização da função
  count(), o que acredito deixar o script mais rápido...*/
$pg->sql = "select id from usuarios ";

/*O método parte1 realizará o cálculo necessário para o funcionamento correto
do paginador, atribuindo valores às variáveis $this->inicio e $this->fim,
necessárias para a busca dos dados*/

$pg->parte1();

/*aqui vc deve realizar a busca dos dados que serão exibidos, aproveitando o
resultado dos cálculos do paginador*/
$res = mysql_query("select * from usuarios limit $this->inicio,$this->fim");

/*a forma de mostar os resultados fica a seu critério :)
O método parte2 exibe os números das páginas (ex : 1 2 3 próxima >> ).
Está bem simples, sem estilos ou efeitos para facilitar a customização*/
$pg->parte2();

mysql_close($conexao);

?>





