<?php 

/**
 *	Classe Dispatch, responsavel por ser o despachante. Ele carrega
 *  a classe responsavel pelo o controle
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

class Dispatch {

    /**
     *  Construtor da Classe
     */
    public function __construct() {

        //Se o module não for informado, ele passa a ser considerado o index; 
        $module = (isset($_GET['module'])) ? $_GET['module'] : 'index'; 
        //A mesma coisa para a action 
        $action = (isset($_GET['action'])) ? $_GET['action'] : 'index'; 
        
        //Deixa a string em minusculo 
        $module = strtolower($module); 
        $action = strtolower($action);

        //Cria o nome do arquivo da Action 
        $fileName = 'modules/'.$module.'/'.$action.'.php'; 
        
        //Se o arquivo existir, carrega-o, caso contrário gera erro 
        if (file_exists($fileName)) { 
            //Carrega o arquivo que contem a classe do Command 
            require_once $fileName;
           
            //O nome da classe é a Action seguida da String Command 
            $className = ucfirst($action);
           
            //Carrega a classe e retorna 
            return new $className(); 
        } else { 
            // Não vou me preocupar com o tratamento de erros agora, isso será 
            // abordado nos proximos artigos
            die('Erro 404 - Página não encontrada');
        }
    } 
}

//Cria a Factory
$dispatch = new Dispatch();

?>
