<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<?php

require_once "DataBase.php";


Class Pagination extends DataBase
{
    /** Array */
    private $configuration;

    public function __construct()
    {
        parent::__construct();
    }

    public function configure($param)
    {
        $this->configuration['tabela'] = $param['tabela'];
        $this->configuration['quant'] = $param['quant'];
        $this->configuration['inicio'] = 0;
        $this->configuration['colunas'] = $param['colunas'];
        $this->configuration['tituloColunas'] = $param['tituloColunas'];
        $this->configuration['checkbox'] = $param['checkbox'];
        $this->configuration['busca'] = isset($_GET['busca']) ? $_GET['busca'] : null;
        $this->configuration['colunasBusca'] = $param['colunasBusca'];
        
        $pag = isset($_GET['pag']) ?  $_GET['pag'] : 1; 
		$pag = filter_var($pag, FILTER_VALIDATE_INT); 
		
        if (empty($pag))
			$this->configuration['inicio'] = ($pag - 1) * $this->configuration['quant'];
		else
			$this->configuration['inicio'] = 0;
    }

    /** retorna a quantidade de linhas da consulta inteira sem limite */
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
        //echo $sqlQuant;
		$quant = parent::executeQuery($sqlQuant);

		$total = parent::fetchResults($quant);

        return $total['total'];
    }

    /** retorna a consulta que será exibida */
    private function getDataResult()
    {
        echo $this->getQuantResult();
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
        echo $busca .= " LIMIT " . $this->configuration['inicio'] . ", " . $this->configuration['quant'];
        $result = parent::executeQuery($busca);
        return $result;
    }

    public function getHtmlTable()
    {
        $result = $this->getDataResult();
        $table = "<table width='100%' class='tw-ui-listagem'>";
        
        /* cabecalho */
        $table .= "<thead><tr>";


        if ($this->configuration['checkbox'])
            $table .= "<th width='5' align='center'></th>";

        for ($i = 0; $i < count($this->configuration['tituloColunas']); $i++)
        {
            $table .= "<th>" . $this->configuration['tituloColunas'][$i] . "</th>";
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
}

$pagination = new Pagination();
$pagination->configure(
    Array(
        'tabela' => 'usuarios',
        'quant' => 10,
        'colunas' => Array('nome', 'email', 'status'),
        'tituloColunas' => Array('Nome', 'E-mail', 'Status'),
        'checkbox' => true,
        'colunasBusca' => Array('nome')
        )
    );
echo $pagination->getHtmlTable();

?>
</body>
</head>
