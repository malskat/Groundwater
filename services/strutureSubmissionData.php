<?php

require_once '../config/constants.php';
require_once '../data/struture_data.php';

if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){

	if (isset($_POST["individualCode"]) && $_POST["individualCode"] != "" && isset($_POST["samplingDate"]) && $_POST["samplingDate"] != "" ) {

		unset($_POST["submissionType"]);

		$strutureData = new Struture();	

		if(!isset($_POST["struture_id"])) {
			$reply = $strutureData->insert($_POST);
		} else {
			$reply = $strutureData->update($_POST);
		}
		
		if($reply['_success_'] == 1) {
			header('Location: /forms/struture.php?success=1&individualCode=' . $_POST["individualCode"]);
		} else {
			header('Location: /forms/struture.php?success=-3&reason=Não houve alteração nenhuma!&individualCode=' . $_POST["individualCode"]);
		}

		
	} else {
		header('Location: /forms/struture.php?success=-1&reason=Faltam parametros à estrutura!&individualCode=' . $_POST["individualCode"]);
	}
} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {

	try {

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: /forms/struture-csv.php?success=-1&reason=Ficheiro tem de ser csv!');
	  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
			header('Location: /forms/struture-csv.php?success=-1&reason=Ficheiro ja foi processado!');
	  	} else {
			
			//movimentacao do ficheiro da pasta temporaria para a pasta final
	  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);


	  		//inserir os individuos
	  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {


				require_once '../data/individual_data.php';
	  			
		  		$individualData = new Individual();
	  			$strutureData = new Struture();
	  			$row = 1;
	  			$operated = 0;
	  			$errorString = '';
	  			$hasCoordinates = false;
			    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			        
		       		//inserir na BD
			        if ($row == 1) {
			        	if (array_search("coordinateX", $data)) {
							$hasCoordinates = true;
			        	}
			        } else {
			        	if (count($individualData->getIndividualBy($whereClause = ' individualCode = "' . $data[0] . '"' , $page = -1)) > 0 ) {

			        		$strutureRecord = array();
			        		$strutureRecord["individualCode"] = $data[0];
			        		$strutureRecord["samplingDate"] = $data[1];
			        		$strutureRecord["diameter1"] = ($data[2] != "" ? $data[2] : 'NULL');
			        		$strutureRecord["diameter2"] = ($data[3] != "" ? $data[3] : 'NULL');
			        		$strutureRecord["height"] = ($data[4] != "" ? $data[4] : 'NULL');
			        		$strutureRecord["perimeter"] = ($data[5] != "" ? $data[5] : 'NULL');

			        		$strutureExists = $strutureData->getObjectsBy(' individualCode = "' . $data[0] . '"', -1);

			        		if (count($strutureExists) == 0) {
			        			//insercao de struture
								$reply = $strutureData->insert($strutureRecord);

			        		} else {
								//actualizacao de struture
								$strutureRecord['struture_id'] = $strutureExists[0]->struture_id;
			        			$reply = $strutureData->update($strutureRecord);
			        		}

			        		if ($reply['_success_'] == 1) {
		        				$operated++;
		        			}

		        			if ($hasCoordinates && $data[6] != "" && $data[7] != "") {
		        				//actualizar individuo
		        				$individualToUpdate = array();
		        				$individualToUpdate['individualCode'] = $data[0];
		        				$individualToUpdate['coordinateX'] = ($data[6] != "" ? $data[6] : '-1');
		        				$individualToUpdate['coordinateY'] = ($data[7] != "" ? $data[7] : '-1');

		        				$success = $individualData->update($individualToUpdate);

		        				if ($success['_success_'] != 1) {
			        				$errorString .= "» Linha " . $row . ", individualCode " . $data[0] . " não foi possível actualizar as coordenadas; <br />";
			        			}

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
						header('Location: /forms/struture-csv.php?success=-2&reason=' . $errorString);
					} else {
						header('Location: /forms/struture-csv.php?success=1&inserted=' . $operated);	
					}

				} else {
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: /forms/struture-csv.php?success=-1&reason=ficheiro não passou para a directoria final!');
				}
			}


  		}
	} catch (Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: /forms/struture-csv.php?success=-1&reason=' . $e);
	}
} else {
	header('Location: /forms/species.php?success=-1&reason=Tipo de submissão não suportado!');
}