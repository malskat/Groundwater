<?php

require_once '../config/constants.php';
require_once '../data/species_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: /forms/login.php?success=-1&reason=There is no user logged in. Please log in to continue.');
	die;
} 


if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){

	if(isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["genus"]) && $_POST["genus"] != ""
		 && isset($_POST["species"]) && $_POST["species"] != ""  && isset($_POST["type"]) && $_POST["type"] != ""){

		unset($_POST["submissionType"]);

		$speciesData = new Species();

		$urlComplement = '';

		if (!isset($_POST["species_id"])) {
			$reply = $speciesData->insert($_POST);
			$urlComplement = '&species_id=' . $reply['_id_'];
		} else {
			$reply = $speciesData->update($_POST);
			$urlComplement = '&species_id=' . $_POST["species_id"];
		}


		if ($reply['_success_'] == 1) {
			header('Location: /forms/species.php?success=1' . $urlComplement);
		} else {
			header('Location: /forms/species.php?success=-3&reason=There was no change!' . $urlComplement);
		}

		
	} else {
		header('Location: /forms/species.php?success=-1&reason=Missing arguments!');
	}

} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {

	try {

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: /forms/species-csv.php?success=-1&reason=File must be csv format!');
	  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
			header('Location: /forms/species-csv.php?success=-1&reason=File already processed!');
	  	} else {
			
			//movimentacao do ficheiro da pasta temporaria para a pasta final
	  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);


	  		//inserir os individuos
	  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {
	  			
	  			$speciesData = new Species();
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
			        	$toInsert["file"] = $_FILES["file"]["name"];


			        	$reply = $speciesData->insert($toInsert);
			        	
						if ($reply['_success_'] == 1) {
							$inserted++;
						}
			        }

			        $row++;
			    }
			    
			    fclose($handle);

			    
		  		//mudar o ficheiro para a pasta de ficheiros processados
				if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true){

					if($errorString != ''){
						header('Location: /forms/species-csv.php?success=-2&reason=' . $errorString);
					} else {
						header('Location: /forms/species-csv.php?success=1&inserted=' . $inserted);	
					}

				} else {
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: /forms/species-list.php?success=-1&reason=Could not move file to final directory!');
				}
			}


  		}
	} catch (Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: /forms/species-list.php?success=-1&reason=' . $e);
	}
} else {
	header('Location: /forms/species-csv.php?success=-1&reason=Submission not allowed!');
}