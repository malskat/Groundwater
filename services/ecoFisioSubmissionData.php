8<?php

require_once '../config/constants.php';
require_once '../data/ecoFisio_data.php';
require_once '../data/individual_data.php';

if(isset($_POST["sampling_campaign_id"]) &&  $_POST["sampling_campaign_id"] != ""){

		try {

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=-1&reason=Ficheiro tem de ser csv!');
	  	} else if (file_exists(PROJECT_DOCS_CENTER . $_FILES["file"]["name"])){
			header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=-1&reason=Ficheiro ja foi processado!');
	  	} else {
			
			//movimentacao do ficheiro da pasta temporaria para a pasta final
	  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);


	  		//inserir os individuos
	  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {
	  			
	  			$individualData = new Individual();
	  			$ecoFisioData = new EcoFisio();
	  			$row = 1;
	  			$inserted = 0;
	  			$errorString = '';
			    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			        
		       		//inserir na BD
			        if ($row > 1){

			        	if (count($individualData->getIndividualBy($whereClause = ' individualCode = "' . $data[0] . '"' , $page = -1)) > 0 ) {

			        		$toInsert = array();

			        		$toInsert['sampling_campaign_id'] = $_POST["sampling_campaign_id"];
	        				$toInsert['individualCode'] = $data[0];
			        		$toInsert['samplingDate'] = $data[1];
				        	$toInsert['leaf_13c'] = $data[2];
				        	$toInsert['twig_18o'] = $data[3];
				        	$toInsert['waterPotencial'] = $data[4];
				        	$toInsert['photosyntheticIndices'] = $data[5];
				        	
							if ( $ecoFisioData->insertEcoFisio($toInsert) == 1) {
								$inserted++;
							}
			        	} else {
			        		$errorString .= "» Linha " . $row . ", individualCode '" . $data[0] . "' não existe; <br />";
			        	}

			        }

			        $row++;
			    }
			    
			    fclose($handle);

			    
		  		//mudar o ficheiro para a pasta de ficheiros processados
				if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true){

					if($errorString != ''){
						header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=-2&reason=' . $errorString);
					} else {
						header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=1&inserted=' . $inserted);	
					}

				} else {
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=-1&reason=ficheiro nao passou para a directoria final');
				}
			}


  		}
	} catch (Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=-1&reason=' . $e);
	}

} else {
	header('Location: ' . PROJECT_URL . 'forms/individualEcoFisio-csv.html?success=-1&reason=Faltam parametros!');
}