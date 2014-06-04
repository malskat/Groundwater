<?php

require_once '../config/constants.php';
require_once '../data/individual_data.php';
require_once '../data/site_data.php';
require_once '../data/plot_data.php';
require_once '../data/species_data.php';


if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){

	if(isset($_POST["individualCode"]) && $_POST["individualCode"] != "" && isset($_POST["coordinateX"]) && $_POST["coordinateX"] != ""
		&& isset($_POST["coordinateY"]) && $_POST["coordinateY"] != "" && isset($_POST["plot_id"]) && $_POST["plot_id"] != ""
		 && isset($_POST["species_id"]) && $_POST["species_id"] != ""){

		unset($_POST["submissionType"]);

		$individualData = new Individual();

		if($_POST["operationType"] == 'insert'){
			unset($_POST["operationType"]);
			$success = $individualData->insertIndividual($_POST);
		}else {
			unset($_POST["operationType"]);
			$success = $individualData->updateIndividual($_POST);
		}
		
		if($success == 1){
			header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=1');
		} else {
			header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=-3&reason=Não houve alteração nenhuma!');
		}
	} else {
		header('Location: ' . PROJECT_URL . 'forms/individual.html?success=-1&reason=Faltam parametros!');
	}

} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel'){

	try {

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: ' . PROJECT_URL . 'forms/individual-csv.html?success=-1&reason=Ficheiro tem de ser csv!');
	  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
			header('Location: ' . PROJECT_URL . 'forms/individual-csv.html?success=-1&reason=Ficheiro ja foi processado!');
	  	} else {
			//mover o ficheiro da pasta temporaria
	  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);

	  		//inserir os individuos
	  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {

	  			
	  			$individualData = new Individual();
				$siteData = new Site();
				$plotData = new Plot();
				$speciesData = new Species();
	  			$row = 1;
	  			$errorString = '';
	  			$inserted = 0;
			    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			        
		       		//inserir na BD
			        if ($row > 1) {

			    		//validar se o individuo ja esta inserido
			    		$individual = $individualData->getIndividualBy(" individualCode = '" . $data[4] . "'", $page = -1);
			    		if (count($individual) == 0) {

			        		$toInsert = array();
			        		$site = $siteData->getSiteBy("code = '". $data[0]."'", -1);
			        		if (count($site) == 1) {

			        			$plot = $plotData->getPlotBy("s.site_id = " . $site[0]->site_id . " and upper(p.code) = upper('" . $data[1] . "')", -1);
			        			if (count($plot) == 1) {

			        				$species = $speciesData->getSpeciesBy("upper(genus) = upper('". $data[2]."') and upper(species) = upper('" . $data[3] . "')", -1);
				        			
				        			if (count($species) == 1) {

				        				$toInsert['plot_id'] = $plot[0]->plot_id;
						        		$toInsert['species_id'] = $species[0]->species_id;
							        	$toInsert['individualCode'] = $data[4];
							        	$toInsert['coordinateX'] = $data[5];
							        	$toInsert['coordinateY'] = $data[6];
							        	
							        	if ($data[7] != 'ND') {
							        		$toInsert['phenologicalType'] = $data[7];
							        	}

										if($individualData->insertIndividual($toInsert) == 1) {
											$inserted++;
										}

				  					} else {
				        				$errorString .= '» Linha ' . $row . ', individualCode ' . $data[4] . ': espécie não foi encontrada; <br />';
				        			}

			        			} else {
			        				$errorString .= '» Linha ' . $row . ', individualCode ' . $data[4] . ': plot não foi encontrado; <br />';
			        			}

			        			
			        		}else {
			        			$errorString .= '» Linha ' . $row . ', individualCode ' . $data[4] . ': local não foi encontrado; <br />';
			        		}

			    		} else {
			    			$errorString .= '» Linha ' . $row . ', individualCode ' . $data[4] . ': já existe na BD; <br />';
			    		}

			        }

			        $row++;
			    }
			    
			    fclose($handle);

		  		//mudar o ficheiro para a pasta de ficheiros processados
				if (rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true) {

					if($errorString != ''){
						header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=-2&reason=' . $errorString);
					} else {
						header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=1&inserted=' . $inserted);	
					}

				} else {
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=-1&reason=ficheiro nao passou para a directoria final!');
				}
			}


  		}
	} catch (Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=-1&reason=' . $e);
	}

} else {
	header('Location: ' . PROJECT_URL . 'lists/individual-list.html?success=-1&reason=N&atilde;o estamos preparados para mais nenhum tipo de carregamento de informa&ccedil;&atilde;o, a n&atilde;o ser por formul&aacute;rio ou excel.');
}
