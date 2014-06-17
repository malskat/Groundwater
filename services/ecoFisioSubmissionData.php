8<?php

require_once '../config/constants.php';
require_once '../data/ecoFisio_data.php';
require_once '../data/individual_data.php';

if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){
	if(isset($_POST["individualCode"]) && $_POST["individualCode"] != "" && isset($_POST["samplingDate"]) && $_POST["samplingDate"] != "" && 
	   	isset($_POST["sampling_campaign_id"]) && $_POST["sampling_campaign_id"] != "") {

		unset($_POST["submissionType"]);

		$ecoFisioData = new EcoFisio();

		if($_POST["operationType"] == 'insert'){
			unset($_POST["operationType"]);
			$reply = $ecoFisioData->insertEcoFisio($_POST);
		}else {
			unset($_POST["operationType"]);
			$reply = $ecoFisioData->updateEcoFisio($_POST);
		}

		if($reply['_success_'] == 1){
			header('Location: /lists/ecoFisio-list.html?individualCode=' . $_POST["individualCode"] . '&success=1');
		} else {
			header('Location: /lists/ecoFisio-list.html?individualCode=' . $_POST["individualCode"] . '&success=-3&reason=Não houve alteração nenhuma!');
		}
	} else {
		header('Location: /forms/ecoFisio.html?success=-1&reason=Faltam parametros!');
	}




} else if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel'){

	if(isset($_POST["sampling_campaign_id"]) &&  $_POST["sampling_campaign_id"] != "" 
	   && isset($_POST["ecoBlock"]) &&  $_POST["ecoBlock"] != ""){

		try {

			$extensionParts = explode(".", $_FILES["file"]["name"]);
		  	$extension = end($extensionParts);

		  	if($extension != 'csv'){
				header('Location: /forms/ecoFisio-csv.html?success=-1&reason=Ficheiro tem de ser csv!');
		  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
				header('Location: /forms/ecoFisio-csv.html?success=-1&reason=Ficheiro ja foi processado!');
		  	} else {
				
				//movimentacao do ficheiro da pasta temporaria para a pasta final
		  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);


		  		//inserir os individuos
		  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {
		  			
		  			$individualData = new Individual();
		  			$ecoFisioData = new EcoFisio();
		  			$row = 1;
		  			$operated = 0;
		  			$errorString = '';
		  			$hasSamplingDate = false;
				    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				        if ($row == 1) {
				        	if (array_search("samplingDate", $data)) {
								$hasSamplingDate = true;
				        	}
				        } else {

				        	if (count($individualData->getIndividualBy($whereClause = ' individualCode = "' . $data[0] . '"' , $page = -1)) > 0 ) {


				        		$ecoFisioRecord = array();
				        		$ecoFisioRecord['sampling_campaign_id'] = $_POST["sampling_campaign_id"];
		        				$ecoFisioRecord['individualCode'] = $data[0];
		        				if ($hasSamplingDate) {
				        			$ecoFisioRecord['samplingDate'] = $data[1];
		        				}
				        		$ecoFisioData->fillEcoAttributes($ecoFisioRecord, $data,  $_POST["ecoBlock"], $hasSamplingDate);
				        		$ecoFisioExists = $ecoFisioData->getEcoFisioBy(' ef.individualCode = "' . $data[0] . '" and ef.sampling_campaign_id = ' . $_POST["sampling_campaign_id"], '', -1);

				        		if (count($ecoFisioExists) == 0) {
				        			//insercao de eco-fisiologia
									$reply = $ecoFisioData->insertEcoFisio($ecoFisioRecord);

				        		} else {
									//actualizacao de eco-fisiologia
				        			$reply = $ecoFisioData->updateEcoFisio($ecoFisioRecord);
				        		}

				        		if ($reply['_success_'] == 1) {
			        				$operated++;
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
							header('Location: /forms/ecoFisio-csv.html?success=-2&reason=' . $errorString);
						} else {
							header('Location: /forms/ecoFisio-csv.html?success=1&inserted=' . $operated);	
						}

					} else {
		  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
						header('Location: /forms/ecoFisio-csv.html?success=-1&reason=ficheiro nao passou para a directoria final');
					}
				}


	  		}
		} catch (Exception $e) {
			unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
	  		header('Location: /forms/ecoFisio-csv.html?success=-1&reason=' . $e);
		}

	} else {
		header('Location: /forms/ecoFisio-csv.html?success=-1&reason=Faltam parametros!');
	}
}