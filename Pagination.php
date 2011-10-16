<?php

/**
 *	Classe responsável por criar uma tabela de dados e a paginação
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
Class Pagination extends DataBase
{
    /**
     *  Atributo que guarda as informações de configuração
     *  @access private
     *  @name $configuration
     */
    private $configuration;

    /**
     *  Atributo que guarda a quantidade de linhas que serão
     *  exibidas na consulta
     *  @access private
     *  @name $rowsSearch
     */
    private $rowsSearch;

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  Método de inicialização das configurações
     *  @access public
     *  @name configure()
     */
    public function configure($param)
    {
        $this->configuration['tabela'] = $param['tabela'];
        $this->configuration['quant'] = $param['quant'];
        $this->configuration['inicio'] = 0;
        $this->configuration['colunas'] = $param['colunas'];
        $this->configuration['tituloColunas'] = $param['tituloColunas'];
        $this->configuration['colSize'] = $param['colSize'];
        $this->configuration['checkbox'] = $param['checkbox'];
        $this->configuration['busca'] = isset($_GET['busca']) ? $_GET['busca'] : null;
        $this->configuration['colunasBusca'] = $param['colunasBusca'];
        
        $pag = isset($_GET['pag']) ?  $_GET['pag'] : 1; 
		$this->configuration['pag'] = filter_var($pag, FILTER_VALIDATE_INT); 
		
        if (!empty($this->configuration['pag']))
			$this->configuration['inicio'] = ($this->configuration['pag'] - 1) * $this->configuration['quant'];
		else
			$this->configuration['inicio'] = 0;
    }

    /**
     *  Retorna a quantidade de linhas da consulta inteira sem limite 
     *  @access private
     *  @name getQuantResult()
     *  @return integer
     */
    private function getQuantResult()
    {
		$sqlQuant = "SELECT COUNT(*) as total FROM " . $this->configuration['tabela'];
        if ($this->configuration['busca'])
        {
            $sqlQuant .= " WHERE ";
			for ($i = 0; $i < count($this->configuration['colunasBusca']); $i++)
			{
				$sqlQuant .= "" . $this->configuration['colunasBusca'][$i] . " 
                    LIKE '%" . $this->configuration['busca'] . "%' ";
				if (($i + 1) < count($this->configuration['colunasBusca']))
					$sqlQuant .= " OR ";
			}
        }
		$quant = parent::executeQuery($sqlQuant);

		$total = parent::fetchResults($quant);

        return $total['total'];
    }

    /**
     *  Retorna a consulta que será exibida
     *  @access private
     *  @name getDataResult()
     *  @return array
     */
    private function getDataResult()
    {
		$busca = "SELECT * FROM " . $this->configuration['tabela']; 

        if ($this->configuration['busca'])
        {
            $busca .= " WHERE ";
			for ($i = 0; $i < count($this->configuration['colunasBusca']); $i++)
			{
				$busca .= "" . $this->configuration['colunasBusca'][$i] . " 
                    LIKE '%" . $this->configuration['busca'] . "%' ";
				if (($i + 1) < count($this->configuration['colunasBusca']))
					$busca .= " OR ";
			}
        }
        $busca .= " LIMIT " . $this->configuration['inicio'] . ", " . $this->configuration['quant'];
        $result = parent::executeQuery($busca);
        return $result;
    }

    /**
     *  Retorna o html da tabela de dados
     *  @access private
     *  @name getHtmlTable()
     *  @return string
     */
    public function getHtmlTable()
    {
        $result = $this->getDataResult();
        $this->rowsSearch = parent::getRows($result);
        $table = "<table width='100%' class='tw-ui-listagem'>";
        
        /* cabecalho */
        $table .= "<thead><tr>";


        if ($this->configuration['checkbox'])
            $table .= "<th width='5' align='center'></th>";

        for ($i = 0; $i < count($this->configuration['tituloColunas']); $i++)
        {
            $table .= "<th width='" . $this->configuration['colSize'][$i] . "'>" . $this->configuration['tituloColunas'][$i] . "</th>";
        }
        $table .= "</tr></thead><tbody>";

        /* corpo */
        while ($row = parent::fetchResults($result))
        {
            $table .= "<tr>";
            if ($this->configuration['checkbox'])
                $table .= "<td><input type='checkbox' value='".$row['id']."' /></td>";

            for ($j = 0; $j < count($this->configuration['colunas']); $j++)
            {
                $table .= "<td>" . $row[$this->configuration['colunas'][$j]] . "</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</tbody></table>";
        return $table;
    }

    /**
     *  Retorna o nome do arquivo (página) exibido
     *  @access private
     *  @name getThisPage()
     *  @return string
     */
    private function getThisPage()
    {  
        $arr = explode('/', $_SERVER['SCRIPT_NAME']);
        return $arr[count($arr) - 1];
    }

    /**
     *  Retorna o html da paginação
     *  @access private
     *  @name getHtmlPagination()
     *  @return string
     */
    public function getHtmlPagination()
    {
        $pagina = $this->getThisPage();

        $prox = $this->configuration['pag'] + 1;
        $ant = $this->configuration['pag'] - 1;
        $ultima_pag = ceil($this->getQuantResult() / $this->configuration['quant']);
        $penultima = $ultima_pag - 1;       
        $adjacentes = 2;

        if ($this->configuration['pag'] > 1)
            $paginacao = '<a class="prev-paginacao" href="'.$pagina.'?pag='.$ant.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').(isset($_GET['limit'])?'&limit='.$_GET['limit']:'').'"><img src="imagens/arrowleft.png" /></a>';
        else
            $paginacao = '<a href="#" disabled class="prev-paginacao" ><img src="imagens/arrowleftdisabled.png" /></a>';
                                     
        if ($prox <= $ultima_pag && $ultima_pag >= 2) 
            $paginacao .= '<a class="next-paginacao" href="'.$pagina.'?pag='.$prox.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').(isset($_GET['limit'])?'&limit='.$_GET['limit']:'').'"><img src="imagens/arrowright.png" /></a>';
        else
            $paginacao .= '<a href="#" disabled class="next-paginacao"><img src="imagens/arrowrightdisabled.png" /></a>';


        return '<div class="paginacao"><b>' . ($this->configuration['inicio'] + 1) . '</b> a <b>' . ($this->configuration['inicio'] + $this->rowsSearch) . '</b> de <b>' . $this->getQuantResult() . '</b> ' . $paginacao . '</div>';

    }
}

?>
