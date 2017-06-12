<?php 

namespace UrlAmigavel\Controller;

use UrlAmigavel\Controller\MinifiFunctions;

class MinifiController extends MinifiFunctions
{

    public function min_css($code = array())
    {   
    	//Tipo de Arquivo
    	$tipoArquivo = 'css';

    	//Chama class getCss com valor de array
        $arquivoTemp = self::compressCss($code);
        
        //Retorna o nome do arquivo temporario
    	return self::arquivoTemporario($arquivoTemp, $tipoArquivo);
    }


}