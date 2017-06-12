<?php 

namespace UrlAmigavel\Controller;

use DirectoryIterator;

class MinifiFunctions
{
    protected function bufferFiles( $files = array() )
    {
    	//Buffer leitura de arquivos
        $buffer    = null;
        $allBuffer = null;

        foreach ($files as $key) {
            $buffer = file_get_contents($key);
            $allBuffer .= $buffer;
        }

        return $allBuffer;
    }

    protected function deletaArquivos($caminhoPasta = './view/minScripts/')
    {
    	//Chama a classe DirectoryIterator, que mostra arquivos da pasta
    	$dir = new DirectoryIterator($caminhoPasta);
    	
    	//Foreach de todos os arquivos da pasta
		foreach ($dir as $fileinfo) {
			//Pergunta se nnao é dot ( Dot = . ou .. caminho de pastas)
		    if (!$fileinfo->isDot()) {
		    	//nome do arquivo
		        $arquivo = $fileinfo->getFilename();
		        //Regular Expression, valor de data atual
		        $regularExpression = '/^' 
						        		. date("Y")
						        		. '-'  
						        		. date("n")
						        		. '-'  
						        		. date("j") 
						        		. '/';

				//preg_match verifica se o arquivo começa com a data atual
		        if(!preg_match($regularExpression, $arquivo)){
		        	//Se a data for diferente da atual = hoje ela se apaga
		        	unlink($caminhoPasta . $arquivo);
		        }
				//Final preg_match verifica se o arquivo começa com a data de hoje

		    }
			//Final Pergunta se nnao é dot ( Dot = . ou .. caminho de pastas)
		}
    	//Final Foreach de todos os arquivos da pasta

    }

    protected function arquivoTemporario( 
    	$texto, 
    	$tipoArquivo, 
    	$caminhoPasta = './view/minScripts/'
    )
    {
    	//Nome do Arquivo com Data Do Dia + md5( pega o valor do texto e cria ) 
		$nomeArquivo = date("Y-n-j") . '-min-' . sha1($texto) . '.' .$tipoArquivo;

		//Cria Pasta minScripts
		if(!is_dir($caminhoPasta)){
			//Caso a pasta não exista ela é criada 
			mkdir($caminhoPasta, 0777);
		}
		//Final Cria Pasta minScripts

		//Cria o arquivo caso não exista
		if(!file_exists($caminhoPasta . $nomeArquivo)){
			$arquivo = fopen($caminhoPasta . $nomeArquivo, "w");
			fwrite($arquivo, $texto);
			fclose($arquivo);
		}
		//FInal Cria o arquivo caso não exista
		
		//Deleta arquivos minificados que não comecem com o nome da data Atual
		self::deletaArquivos();

		echo $caminhoPasta . $nomeArquivo;
		return;
    }

    //Compressor de CSS
    protected function compressCss($code = array() )
    {
    	//Faz a leitura de todos os codigos da array e retorna tudo junto
        $code = self::bufferFiles($code);

        //Pergunta se é um arquivo vazio
	    if(trim($code) === "") return $code;
	    
	    //PregReplace de varias formas de compressão
	    return preg_replace(
	        array(
	            // Remove comment(s)
	            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
	            // Remove unused white-space(s)
	            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
	            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
	            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
	            // Replace `:0 0 0 0` with `:0`
	            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
	            // Replace `background-position:0` with `background-position:0 0`
	            '#(background-position):0(?=[;\}])#si',
	            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
	            '#(?<=[\s:,\-])0+\.(\d+)#s',
	            // Minify string value
	            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
	            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
	            // Minify HEX color code
	            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
	            // Replace `(border|outline):none` with `(border|outline):0`
	            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
	            // Remove empty selector(s)
	            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
	        ),
	        array(
	            '$1',
	            '$1$2$3$4$5$6$7',
	            '$1',
	            ':0',
	            '$1:0 0',
	            '.$1',
	            '$1$3',
	            '$1$2$4$5',
	            '$1$2$3',
	            '$1:0',
	            '$1$2'
	        ),
	    $code);
    }

}