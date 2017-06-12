<?php
	//AutoLoad
	require_once __DIR__ . '/vendor/autoload.php';

	//NameSpace
	use UrlAmigavel\RunAppController as RunAppController;
	use UrlAmigavel\Controller\HelpersController as Helper;

	//Include Scripts Run-Url-Amigavel e Helpers
	$urlAmigavel = new RunAppController;
	$helper		 = new Helper;
	
	//include Caminho de Rotas
	require_once __DIR__ . '/src/route.php';
	require_once __DIR__ . DIRECTORY_SEPARATOR . "{$route}";