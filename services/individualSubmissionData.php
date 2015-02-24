<?php

require_once '../config/constants.php';
require_once '../data/individual_data.php';
require_once '../data/site_data.php';
require_once '../data/plot_data.php';
require_once '../data/species_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: ' . PROJECT_URL . 'forms/login.php?response=-1');
	die;
} 



if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form') {

	if (isset($_POST["individualCode"]) && $_POST["individualCode"] != "" && isset($_POST["coordinateX"]) && $_POST["coordinateX"] != ""
		&& isset($_POST["coordinateY"]) && $_POST["coordinateY"] != "" && isset($_POST["plot_id"]) && $_POST["plot_id"] != ""
		 && isset($_POST["species_id"]) && $_POST["species_id"] != "") {

		unset($_POST["submissionType"]);

		try {

			$individualData = new Individual();

			if ($_POST["operationType"] == 'insert') {
				unset($_POST["operationType"]);
				$reply = $individualData->insert($_POST);
			} else {
				unset($_POST["operationType"]);
				$reply = $individualData->update($_POST);
			}


			$urlComplement = '&individualCode=' . $_POST["individualCode"];

			
			if ($reply['_success_'] == 1) {
				header('Location: /forms/individual.php?response=601' . $urlComplement);
			} else {
				header('Location: /forms/individual.php?response=603' . $urlComplement);
			}


		} catch (Exception $e) {
  			header('Location: /forms/individual.php?response=-7&reason=' . $e->getMessage());
  			die;
		}

	} else {
		header('Location: /forms/individual.php?response=602');
	}

} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel'){

	try {

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: /forms/individual-csv.php?response=-3');
	  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
			header('Location: /forms/individual-csv.php?response=-4');
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
			        
			        if ($row == 1) {

			        	$lowerData = array_map('strtolower', $data);

		       			if (array_search("individualcode", $lowerData) === false || 
		       			    array_search("sitecode", $lowerData) === false || 
	  					    array_search("plotcode", $lowerData) === false || 
	  					    array_search("genus", $lowerData) === false) {

							unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
							header('Location: /forms/individual-csv.php?response=604');
							die;
			        	}

			        } else {

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
		       		
		       							//inserir na BD

				        				$toInsert['plot_id'] = $plot[0]->plot_id;
						        		$toInsert['species_id'] = $species[0]->species_id;
							        	$toInsert['individualCode'] = $data[4];
							        	$toInsert['coordinateX'] = $data[5];
							        	$toInsert['coordinateY'] = $data[6];
							        	$toInsert["file"] = $_FILES["file"]["name"];
							        	
							        	if ($data[7] != 'ND') {
							        		$toInsert['phenologicalType'] = $data[7];
							        	}

							        	$reply = $individualData->insert($toInsert);

										if($reply['_success_'] == 1) {
											$inserted++;
										}

				  					} else {
				        				$errorString .= '» Line ' . $row . ', individualCode ' . $data[4] . ': unkown species; <br />';
				        			}

			        			} else {
			        				$errorString .= '» Line ' . $row . ', individualCode ' . $data[4] . ': unkown plot; <br />';
			        			}

			        			
			        		}else {
			        			$errorString .= '» Line ' . $row . ', individualCode ' . $data[4] . ': unkown site; <br />';
			        		}

			    		} else {
			    			$errorString .= '» Line ' . $row . ', individualCode ' . $data[4] . ': already present in DB; <br />';
			    		}

			        }

			        $row++;
			    }
			    
			    fclose($handle);

		  		//mudar o ficheiro para a pasta de ficheiros processados
				if (rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true) {

					if($errorString != ''){
						header('Location: /forms/individual-csv.php?response=13&reason=' . $errorString . '&inserted=' . $inserted);
					} else {
						header('Location: /forms/individual-csv.php?response=12&inserted=' . $inserted);	
					}

				} else {
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: /forms/individual-csv.php?response=-5');
				}
			}


  		}
	} catch (Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: /forms/individual-csv.php?response=-7&reason=' . $e);
	}

} else {
	header('Location: /forms/individual-csv.php?response=-6');
}
