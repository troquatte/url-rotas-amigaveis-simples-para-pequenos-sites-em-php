<?php

namespace UrlAmigavel\Controller;

use UrlAmigavel\Controller\MinifiController as MiniFi;

//Controler Hellper
class HelpersController
{
    //Privado $MiniFi variavel
    private $MiniFi;

    //Construtor
    public function __construct()
    {
        //Valor MinifiController
        $this->MiniFi = new MiniFi;
    }

    //Function Check Url
	public function checkUrl(){

        //Peg ao agaminho do diretorio Atual
        $diretorioAtual = basename(getcwd());
        
        //uri apresentada na aplicacão
        $serverUri = $_SERVER['REQUEST_URI'];

        //$url explode o server Uri por /
        $url            = explode('/', $serverUri);
        //Pega o valor da uri e transforma no falor total da Url
        $valorTotalURl = parse_url($serverUri, PHP_URL_PATH);

        //Url Reverse
        $urlReverse   = array_reverse($url);

        //Procura o nome da $url na array de diretorio atual 
        $search_array = array_search($diretorioAtual, $url);

        //Começa o contador com 0
        //Contando o número de casas da Url
        $countValuesDir = 0;
        foreach ($url as $key) {
            //Pergunta se $key é == diretorio Atual
            if($key == $diretorioAtual){
                    //Se for o DIretorio Atual ele para de contar
                    break;
            }
            //Faz a soma do diretorio atual, pergando a quantidade de casas
            $countValuesDir = $countValuesDir + 1;
        }

        //Pergunta se search_array é invalido
        if(!$search_array){
            //Caso for ele pega o valor da url atual e retorna ela
            $url = $valorTotalURl;
            return $url;
        }

        //Pega o valor da array $url e conta qntidade de casas/dir que ela existe
        //Retornando o valor da casa atual reverse
        $urlReverse = preg_replace("/(.+)$url[$countValuesDir]/", '', $valorTotalURl);

        //Retorna o valor da casa atual reverse
        return $urlReverse;
	}

    //Classe minificadora de css
    public function min_css($css = array())
    {
        //retorna o css minificado em um arquivo determinado 
        return $this->MiniFi->min_css($css);
    }

}