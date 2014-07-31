<?php

require_once '../config/constants.php';
require_once '../data/ecofisio_data.php';
require_once '../data/individual_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: /forms/login.php?response=-1');
	die;
} 


if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form') {
	if(isset($_POST["individualCode"]) && $_POST["individualCode"] != "" && isset($_POST["samplingDate"]) && $_POST["samplingDate"] != "" && 
	   	isset($_POST["sampling_campaign_id"]) && $_POST["sampling_campaign_id"] != "") {

		unset($_POST["submissionType"]);

		$ecoFisioData = new EcoFisio();

		if($_POST["operationType"] == 'insert'){
			unset($_POST["operationType"]);
			$reply = $ecoFisioData->insert($_POST);
		}else {
			unset($_POST["operationType"]);
			$reply = $ecoFisioData->update($_POST);
		}

		if($reply['_success_'] == 1){
			header('Location: /forms/ecofisio.php?individualCode=' . $_POST["individualCode"] . '&sampling_campaign_id=' . $_POST["sampling_campaign_id"] . '&response=901');
		} else {
			header('Location: /forms/ecofisio.php?individualCode=' . $_POST["individualCode"] . '&sampling_campaign_id=' . $_POST["sampling_campaign_id"] . '&response=903');
		}

	} else {
		header('Location: /forms/ecofisio.php?response=902');
	}




} else if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {

	if(isset($_POST["sampling_campaign_id"]) &&  $_POST["sampling_campaign_id"] != "" 
	   && isset($_POST["ecoBlock"]) &&  $_POST["ecoBlock"] != "") {

		try {

			$extensionParts = explode(".", $_FILES["file"]["name"]);
		  	$extension = end($extensionParts);

		  	if($extension != 'csv'){
				header('Location: /forms/ecofisio-csv.php?response=-3');
		  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
				header('Location: /forms/ecofisio-csv.php?response=-4');
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
				        	if (array_search("samplingdate", array_map('strtolower', $data))) {
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
			        				$ecoFisioRecord["file"] = $_FILES["file"]["name"];
									$reply = $ecoFisioData->insert($ecoFisioRecord);

				        		} else {
									//actualizacao de eco-fisiologia
				        			$reply = $ecoFisioData->update($ecoFisioRecord);
				        		}

				        		if ($reply['_success_'] == 1) {
			        				$operated++;
			        			}


				        	} else {
				        		$errorString .= "» Line " . $row . ", individualCode '" . $data[0] . "' doesnt exist; <br />";
				        	}

				        }

				        $row++;
				    }
				    
				    fclose($handle);

				    
			  		//mudar o ficheiro para a pasta de ficheiros processados
					if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true){

						if($errorString != ''){
							header('Location: /forms/ecofisio-csv.php?response=13&reason=' . $errorString);
						} else {
							header('Location: /forms/ecofisio-csv.php?response=12&inserted=' . $operated);	
						}

					} else {
		  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
						header('Location: /forms/ecofisio-csv.php?response=-5');
					}
				}


	  		}
		} catch (Exception $e) {
			unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
	  		header('Location: /forms/ecofisio-csv.php?response=-7&reason=' . $e);
		}

	} else {
		header('Location: /forms/ecofisio-csv.php?response=902');
	}
}