<?php

require_once '../config/constants.php';
require_once '../data/species_data.php';

if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){

	if(isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["genus"]) && $_POST["genus"] != ""
		 && isset($_POST["species"]) && $_POST["species"] != ""  && isset($_POST["type"]) && $_POST["type"] != ""){

		unset($_POST["submissionType"]);

		if (!isset($_POST["species_id"])) {
			$sucess = insertSpecies($_POST);
		} else {
			$sucess = updateSpecies($_POST);
		}
		if ($sucess == 1) {
			header('Location: ' . PROJECT_URL . 'lists/species-list.html?sucess=1');
		} else {
			header('Location: ' . PROJECT_URL . 'lists/species-list.html?sucess=-3&reason=Nao houve alteracao nenhuma!');
		}

		
	} else {
		header('Location: ' . PROJECT_URL . 'forms/species.html?sucess=-1&reason=Faltam parametros!');
	}

} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {

	try {

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: ' . PROJECT_URL . 'forms/species-csv.html?sucess=-1&reason=Ficheiro tem de ser csv!');
	  	} else if (file_exists(PROJECT_DOCS_CENTER . $_FILES["file"]["name"])){
			header('Location: ' . PROJECT_URL . 'forms/species-csv.html?sucess=-1&reason=Ficheiro ja foi processado!');
	  	} else {
			
			//movimentacao do ficheiro da pasta temporaria para a pasta final
	  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);


	  		//inserir os individuos
	  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {
	  			
	  			$row = 1;
	  			$inserted = 0;
	  			$errorString = '';
			    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			        
		       		//inserir na BD
			        if ($row > 1){

		        		$toInsert = array();

        				$toInsert['genus'] = $data[0];
		        		$toInsert['species'] = $data[1];
			        	$toInsert['type'] = $data[2];
			        	$toInsert['code'] = $data[3];
			        	$toInsert['functionalGroup'] = $data[4];
			        	
						if ( insertSpecies($toInsert) == 1) {
							$inserted++;
						}
			        }

			        $row++;
			    }
			    
			    fclose($handle);
			}

	  		//mudar o ficheiro para a pasta de ficheiros processados
			if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true){

				if($errorString != ''){
					header('Location: ' . PROJECT_URL . 'lists/species-list.html?sucess=-2&reason=' . $errorString);
				} else {
					header('Location: ' . PROJECT_URL . 'lists/species-list.html?sucess=1&inserted=' . $inserted);	
				}

			} else {
  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
				header('Location: ' . PROJECT_URL . 'lists/species-list.html?sucess=-1&reason=ficheiro nao passou para a directoria final');
			}

  		}
	} catch (Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: ' . PROJECT_URL . 'lists/species-list.html?sucess=-1&reason=' . $e);
	}
} else {
	header('Location: ' . PROJECT_URL . 'forms/species.html?sucess=-1&reason=Tipo de submissão não suportado!');
}