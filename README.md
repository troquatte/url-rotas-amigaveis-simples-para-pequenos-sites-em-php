# Gerador de Url e Rotas Amigáveis 
Forma simples e rápida para gerar url amigáveis, com simples gerenciador de rotas.
Proposta do código é ajudar desenvolvedores criar sites com url amigáveis ajudando na performance e velocidade de seu site.
O código está sendo testado e otimizado. 
 
**Etapas de desenvolvimento**
* **Rotas:** fácil sistema de rotas - ok
* **Url Amigável:** url amigável para web sites - ok
* **Minificador Css:** facilidade na hora de minificar CSS com a função $helper->min_css - ok  
 
* **Minificador Js:** facilidade na hora de minificar JS com a função $helper->min_js - Não desenvolvido  
* **Minificador Imagem:** facilidade na hora de minificar IMAGENS com a função $helper->min_img - Não desenvolvido
 
# Instalação
Basta baixar e começar a utilizar seguindo o passo a passo a baixo:
 
## Iniciando
Assim que terminar o download, teremos as seguintes pastas:
 
##Arquivos da pasta: url-rotas-amigaveis-simples-para-pequenos-sites-em-php
 
| Arquivos  					| Utilidade 										|
| ------------- 				| ----------- |
| <b>Pasta:</b> app 			| Configurações da aplicação 						|
| <b>Pasta:</b> vendor 			| Nessa pasta temos o vendor do autoload ( psr-4 ) 	|
| <b>Pasta:</b> view 			| Templates do site 								|
| <b>Arquivo:</b> .htaccess 	| Configurações para o servidor 					|
| <b>Arquivo:</b> index.php 	| Inicialização da aplicação 						|
 
 
## Onde devo colocar meus arquivos front-end?
Deixe todos os seus arquivos front-end na pasta <b>"/view"</b>!<br>
É na pasta <b>"/view"</b> que nossas rotas iram buscar os arquivos para renderização.<br>
<b>OBS.:</b> em seu html sempre que for chamar um arquivo ( css, js, img, etc.. ), coloque "view" antes, exp.:
 
Css => 'view/css/meuCodigo.css'
```
<link rel="stylesheet" type="text/css" href="view/css/meuCodigo.css">
```
 
js => 'view/js/meuCodigo.js'
```
<script type="text/javascript" src="view/js/meuCodigo.js"></script>
```
 
imagem => 'view/img/minhaImagem.jpg'
```
<img src="view/img/minhaImagem.jpg" alt="">
```
<b>Assim funciona para todos os arquivos!</b>
 
## Criando uma rota
Dentro da <b>Pasta:</b> app / temos o arquivo chamado route.php, que contem o seguinte código:
 
```
//Rotas
$route = 
	$urlAmigavel->routes(
 
		//*******************
		//Array Rota
		[
		
		
			//*******************
			//Rota '/'
			[
				//Rota
				'prefix' => '/', 
				//nomeDoArquivo
				'archive'    => 'index.php'
			],
			//End Rota '/'
			//*******************
		
 
		]
		//And Array Rotas
		//*******************
	
	);
```
 
Para criarmos uma rota é simples, basta criar uma array igual ao trecho de código a baixo:
 
```
//Rota '/'
[
	//Rota
	'prefix' => '/', 
	//nomeDoArquivo
	'archive'    => 'index.php'
],
//End Rota '/'
 
//Rota '/minha-nova-rota'
[
	//Rota
	'prefix' => '/minha-nova-rota', 
	//nomeDoArquivo
	'archive'    => 'minha-nova-rota.php'
],
//End Rota '/minha-nova-rota'
```
 
Entendendo o código
 
<b>Prefix:</b> ele é nossa rota, onde será digitado no navegador, exp.: http://www.meusite.com.br/minha-nova-rota
```
'prefix' => '/minha-nova-rota'
```
 
<b>Archive:</b> É o arquivo que será buscado na hora que acessar a rota, 
exp.: quando acessar a rota http://www.meusite.com.br/minha-nova-rota, ele  buscará o arquivo dentro da pasta "/view/minha-nova-rota.php"
```
'archive' => 'minha-nova-rota.php'
```
<b>Lembre-se:</b> sempre que colocar um arquivo na tag <b>'archive' => 'minha-nova-rota.php'</b>, ele buscará dentro da pasta <b>"/view/minha-nova-rota.php"</b>, caso ele não esteja lá, teremos um erro!
 
Depois que você criar a rota para todos os seus arquivos, já pode começar a utilizar em produção!
 
# Funções PHP ou Helpers para performance
Foi adicionado algumas funções para te ajudar nessa jornada!
Elas foram criadas para performar melhor o site.
 
<b>Vamos entender como os minificadores funcionam.</b><br>
Ao utilizar nossos helpers da maneira correta ( vou explicar como utilizar logo a baixo ),
percebe-se que é criado uma pasta chamada <b>"/minScripts"</b> e dentro um arquivo com determinado nome!
 
Assim você altera seu código em suas respectivas pastas e ele o converte passando para <b>"/minScripts"</b>.
 
**Temos ao todo 3 Helpers, veja a seguir:**
* **Minificador Css:** facilidade na hora de minificar CSS com a função $helper->min_css - ok  
 
* **Minificador Js:** facilidade na hora de minificar JS com a função $helper->min_js - Não desenvolvido  
* **Minificador Imagem:** facilidade na hora de minificar IMAGENS com a função $helper->min_img - Não desenvolvido
 
# Utilizando os helpers
<b>Minificador Css: $helper->min_css</b><br>
O que faz o helper min_css?<br>
Ele minifica e uni os arquivos escritos na array em apenas 1 documento e retorna o caminho do arquivo.<br>
 
Veja o trecho do código:
```
<?php 
//Classe Minificadora de Css usada com Array 
	$helper->min_css(
		[
			//Links do css
			'meuCss.css',
			//Final Links do css
		]
	);
//Final Classe Css
?>
```
 
Ele é bem fácil de se utilizar, precisamos apenas colocar os arquivos em uma array.<br>
Agora veja como utilizá-lo:
 
```
<link rel="stylesheet" type="text/css" 
	href="<?php 
		//Classe Minificadora de Css usada com Array 
		$helper->min_css(
			[
				//Links do css
				'view/css/bootstrap.css',
				'view/css/style.css',
				'view/css/style-footer-mobile.css',
				//Final Links do css
			]
		);
		//Final Classe Csse
	?>">
```
 
# Considerações Finais
Teve alguma dúvida? Quer contribuir e melhorar o projeto?
É só entrar em contato!
 
<b>Lembrando:</b>
Forma simples e rápida para gerar url amigáveis, com simples gerenciador de rotas.
Proposta do código é ajudar desenvolvedores criar sites com url amigáveis ajudando na performance e velocidade de seu site.
O código está sendo testado e otimizado. 
 