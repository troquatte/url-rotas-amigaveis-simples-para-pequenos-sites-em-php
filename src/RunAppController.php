<?php

namespace UrlAmigavel;

class RunAppController{

	/**
	* @var private string $valorTotalURl 
	* @example Get value current url
	*
	* @var private string $serverUri 
	* @example REQUEST_URI
	*
	* @var private string $pathView 
	* @example Value path = view/
	*/

	private  $valorTotalURl;
	private  $serverUri;
	private  $pathView;

	/**
	* Inicia os dados do construtor
	*
	* @return $this->pathView retorna o caminho = view/
	* @return $this->serverUri retorna o valor da REQUEST_URI ( LINK )
	* @return $this->valorTotalURl retorna o valoar da ( path quebrada PHP_URL_PATH ) para validação
	*/

	public function __construct()
	{
		//retorna o caminho = view/
		$this->pathView		 = 'view/';

		//retorna o valor da REQUEST_URI ( LINK )
		$this->serverUri 	 = $_SERVER['REQUEST_URI'];

		//retorna o valoar da ( path quebrada PHP_URL_PATH ) para validação
		$this->valorTotalURl = parse_url($this->serverUri, PHP_URL_PATH);
	}

	/**
	* 
	* @todo Gera a url para rotiador
	*
	* @return $diretorioAtual = Mostra o diretorio atual com getcwd + basename
	* @return $url  = explode a url
	* @return $search_array = procura na array o valor da base name
	* @return $url -> last = pega o ultimo nome da array
	*/

	public function genereteUrl()
	{
		//$urlReverse   = array_reverse($url);

		//Explode url vindo do $this->serverUri
		$url		    = explode('/', $this->serverUri);
		//Pega o nome do diretorio atual a base name do 
		$diretorioAtual = basename(getcwd());
		//Procura o valor do diretorio atual se tem na array $url
		$search_array = array_search($diretorioAtual, $url);

		//Contador de Valores para achar a dir na array
		$countValuesDir = 0;
		//foreach das keys $url
		foreach ($url as $key) {
			//If achar a key
			if($key == $diretorioAtual){
				//Ele para o foreach
				break;
			}

			//Adiciona um contador
			$countValuesDir = $countValuesDir + 1;
		}
		//End foreach das keys $url

		//Se array search for falso 
		if(!$search_array){
			//Retorna o caminho da url toda
			$url = $this->valorTotalURl;
			//retorna $url para rota
			return $url;
		}

		//Começa a contar os campos apartir da nimeração do $countValuesDir, a partir dai puxa a rota!
		$url = preg_replace("/(.+)$url[$countValuesDir]/", '', $this->valorTotalURl);
		//Retorna a Rota
		return $url;
	}
 	
	/** 
	* @todo pageError404() Erro se não encontrar pagina 404
	*
	* @return http_response_code -> Adiciona no header error 404
	* @return $path -> Valor da Pasta e caminho do erro 404
	*/
	public function pageError404()
	{
		//http_response_code -> Adiciona no header error 404
		http_response_code(404);
		//$path -> Valor da Pasta e caminho do erro 404
		$path = $this->pathView . 'errors/error404.php';

		return $path;
	}

	/** 
	* @todo   routes() Faz o caminho de Rotas
	* @param  $valorArray = valor de uso da rota exemple:
	*			//Array Rota
	*			[
	*
	*				//Rota '/'
	*				[
	*					//Rota
	*					'prefix' => '/', 
	*
	*					[
	*						//Controller
	*						'controller' => '',
	*						//nomeDoArquivo
	*						'archive' => 'index.php'
	*					]
	*				],
	*				//End Rota '/'
	*
	*			]
	*
	* @return http_response_code -> Adiciona no header error 404
	* @return $path -> Valor da Pasta e caminho do erro 404
	*/
 	public function routes($valorArray = array())
 	{
 		$genereteUrl = self::genereteUrl();
 
 		//Foreach dos dados da array $valorArray 
		foreach ($valorArray as $valores) {
			
			//var_dump($this->genereteUrl());
			if(empty($genereteUrl)){
				$genereteUrl = '/';
			}
			//If pega o valor url com e sem "/" no final
			//e compara com o valor do [prefix] da rota
			if($genereteUrl ==  $valores['prefix'] || $genereteUrl ==  $valores['prefix'] . '/') {
				//Pergunta se o Arquivo existe [archive]
				if(file_exists($this->pathView . $valores['archive'])){
					//retorna o arquivo e inclui no index
					return $this->pathView . $valores['archive'];
				}
					//Caso não encontre mostra envia erro 404
					//Pergunta se o arquivo existe 
			 		if(file_exists($this->pageError404())){
						//Include o o valor 404
			 			return $this->pageError404();
			 		}
					//End IF = Pergunta se o arquivo existe
			}
 		}
 		//END If pega o valor url com e sem "/" no final

		//Caso não encontre mostra envia erro 404
		//Pergunta se o arquivo existe 
 		if(file_exists($this->pageError404())){
			//Include o o valor 404
 			return $this->pageError404();
 		}
		//End IF = Pergunta se o arquivo existe

 	}

}