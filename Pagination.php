<?php

require_once "DataBase.php";

Class Pagination extends DataBase
{
	private $colsSearch;
	private $table;
	private $colOrder;
	private $initInterval;
	private $quantExibition;
	private $totalSearch;
	private $consulta;

	public function __construct()
	{
		parent::__construct();

		$this->setColsSearch(Array('nome', 'email'));
		$this->setTable('usuarios');
		$this->setColOrder('nome');
		$this->setInitInterval();
		$this->getQuantExibition();
		$this->searchData();
		$this->getHtml();
	}
	
	public function setColOrder($col)
	{
		$this->colOrder = $col;
	}
	
	/* configura quais as colunas que a busca vai usar */
	public function setColsSearch($arr)
	{
		$this->colsSearch = $arr;
	}
	/* armazena o nome da coluna que será utilizada*/
	public function setTable($table)
	{
		$this->table = $table;
	}
	
	/* Calcula o inicio do intervalo da consulta*/
	private function setInitInterval()
	{
		// Numero da pagina que esta sendo exibida
		$pag = isset($_GET['pag']) ?  $_GET['pag'] : 1; 

		// Valida o numero passado como parametro
		$pag = filter_var($pag, FILTER_VALIDATE_INT); 

		if (empty($pag))
			$this->initInterval = ($pag - 1) * $limite;
		else
			$this->initInterval = 0;
	}
	

	/* faz a consulta */
	private function searchData()
	{
		$sqlQuant = "SELECT COUNT(*) as total FROM " . $this->table;
		$sqlBusca = "SELECT * FROM " . $this->table;
		

		$search = $this->getSearch();
		if ($search && count($this->colsSearch) > 0)
		{
			$sqlQuant .= " WHERE ";
			$sqlBusca .= " WHERE ";
			
			for ($i = 0; $i < count($this->colsSearch); $i++)
			{
				$sqlQuant .= "" . $this->colsSearch[$i] . " LIKE '%$search%' ";
				$sqlBusca .= "" . $this->colsSearch[$i] . " LIKE '%$search%' ";
				if (($i + 1) < count($this->colsSearch))
				{
					$sqlQuant .= " OR ";
					$sqlBusca .= " OR ";
				}
			}
			$sqlBusca .= " ORDER BY $this->colOrder LIMIT $this->initInterval, $this->quantExibition ";
		}
		
		echo $sqlQuant.'<br />';
		echo $sqlBusca.'<br />';

		$buscaTotal = parent::executeQuery($sqlQuant);
		$this->consulta = parent::executeQuery($sqlBusca);

		$total = parent::fetchResults($buscaTotal);
		$this->totalSearch = $total['total'];
	}

	private function getHtml()
	{
		while ($texto = parent::fetchResults($this->consulta)) {
			//extract($texto);

			echo '<table><tr>
				<td width="40%">'.$texto['nome'].'</td>
				<td width="50%">'.$texto['email'].'</td>
			</tr></table>';
		}
	}

	private function getSearch()
	{
		return isset($_GET['busca']) ? $_GET['busca'] : null;
	}

	private function getQuantExibition()
	{
		$this->quantExibition = isset($_GET['quant']) ? $_GET['quant'] : 2;
	}
}

new Pagination();
?>
