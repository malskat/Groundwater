<?php

require_once '../config/constants.php';
require_once '../data/plotsoil_data.php';
require_once "../checkBiologyst.php";
require_once "../data/campaign_data.php";
require_once "../data/plot_data.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: ' . PROJECT_URL . 'forms/login.php?response=-1');
	die;
} 

if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form') {
	
	if(isset($_POST["soilCode"]) && $_POST["soilCode"] != "" && 
	   isset($_POST["sampling_campaign_id"]) && $_POST["sampling_campaign_id"] != "" &&
	   isset($_POST["measureDate"]) && $_POST["measureDate"] != "") {

		unset($_POST["submissionType"]);

		$plotSoilData = new PlotSoil();


		if(isset($_POST["plot_soil_id"])){
			$reply = $plotSoilData->update($_POST);
			$urlComplement .= 'id=' . $_POST["plot_soil_id"];
		}else {
			$reply = $plotSoilData->insert($_POST);
			$urlComplement .= 'id=' . $reply['_id_'];
		}

		if ($reply['_success_'] == 1) {
			header('Location: /forms/plotsoil.php?' . $urlComplement . '&response=1021');
		} else {
			header('Location: /forms/plotsoil.php?' . $urlComplement . '&response=1023');
		}

	} else {
		header('Location: /forms/plotsoil.php?' . $urlComplement . '&response=1022');
	}

} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {

	if (isset($_POST["sampling_campaign_id"]) &&  $_POST["sampling_campaign_id"] != "") {

		//encontrar a campanha passada
		$campaignData = new Campaign();
    	$campaign = $campaignData->getCampaignBy($whereClause = "sc.sampling_campaign_id = " . $_POST["sampling_campaign_id"], $page = -1, $withTotals = 0);
    	
    	if (count($campaign) > 0 ) {

    		try {

    			$extensionParts = explode(".", $_FILES["file"]["name"]);
			  	$extension = end($extensionParts);

			  	if ($extension != 'csv') {
					header('Location: /forms/plotsoil-csv.php?response=-3');
			  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])) {
					header('Location: /forms/plotsoil-csv.php?response=-4');
			  	} else {

			  		//movimentacao do ficheiro da pasta temporaria para a pasta final
			  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);

			  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {

			  			$row = 1;
			  			$soilsToInsert = array();
			  			$excludedPlots = array();
			  			$authorizedPlots = array();
			  			$errorString = '';
			  			$whereClause = '';
			  			$noMeasureDate = 1;

			  			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

			  				if ($row == 1) {
		       			
		       					$lowerData = array_map('strtolower', $data);

			  					if (array_search("sitecode", $lowerData) === false ||
			  					    array_search("plotcode", $lowerData) === false || 
			  					    array_search("deph", $lowerData) === false || 
			  					    array_search("hole", $lowerData) === false ) {

									unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
									header('Location: /forms/plotsoil-csv.php?response=1026');
									die;
					        	} else if (array_search("measuredate", array_map('strtolower', $data))) {
					        		$noMeasureDate = 0;
					        	}

			  				} else {

			  					$plot = array();

					    		//encontrar Plot e validar se esta ligado ao mesmo site da Campanha
								$plotData = new Plot();
								$whereClause = "s.code = '" . $data[0] . "' and p.code = '" . $data[1] . "'";
								$plot = $plotData->getPlotBy($whereClause, $page = -1, $withTotals = 0);

								if (count($plot) == 0 || $plot[0]->site_id != $campaign[0]->site_id) {
						    		
						    		if (!in_array ($data[1], $excludedPlots)) {
						    			$excludedPlots[] = $data[1];
						    			$errorString .= "» Line " . $row . ", Plot '" . $data[1] . "' does not belong to the Site Campaign selection; <br />";
						    		}
								
								} else {


				  					if (!in_array ($data[1], $authorizedPlots) && !in_array ($data[1], $excludedPlots)) {

										//validar se o plot ja tem medicoes para esta campanha
							        	$plotSoilData = new PlotSoil();
							        	$whereClause = "ps.sampling_campaign_id = " . $campaign[0]->sampling_campaign_id . " and ps.plot_id = " . $plot[0]->plot_id;
										$plotSoil = $plotSoilData->getPlotSoilBy($whereClause, $page = -1, $withTotals = 0);

										if (count($plotSoil) > 0 ) {
											$excludedPlots[] = $data[1];
											$errorString .= "» Line " . $row . ", Plot '" . $data[1] . "' already has Soil Sample to this Campaign; <br />";
										} else {
				  							$authorizedPlots[] = $data[1];
										}

				  					}

				  					if (in_array($data[1], $authorizedPlots)) {

										if (!isset($soilsToInsert[$data[0].$data[1].$data[(3 - $noMeasureDate)]])) {

											$soil = array();
											$soil["soilCode"] = $data[0].$data[1]. '_' . $data[(3 - $noMeasureDate)];
											if ($noMeasureDate === 0) {
												$soil["measureDate"] = $data[2];
											} 

											$soil["plot_id"] = $plot[0]->plot_id;
											$soil["sampling_campaign_id"] = $_POST["sampling_campaign_id"];
											$soil["file"] = $_FILES["file"]["name"];

										} else {
											$soil = $soilsToInsert[$data[0].$data[1].$data[(3 - $noMeasureDate)]];
										}

										switch ($data[(4 - $noMeasureDate)]) {
											case "1" : {
												$soil["soil_18o_10"] = $data[(5 - $noMeasureDate)]; 
												break;
											}
											case "2" : {
												$soil["soil_18o_30"] = $data[(5 - $noMeasureDate)]; 
												break;
											}
											case "3" : {
												$soil["soil_18o_50"] = $data[(5 - $noMeasureDate)]; 
												break;
											}
										}

										if (isset($data[6 - $noMeasureDate]) && $data[(6 - $noMeasureDate)] != "") {
											$soil["soilWaterContent"] = $data[(6 - $noMeasureDate)];
										}

										$soilsToInsert[$data[0].$data[1].$data[(3 - $noMeasureDate)]] = $soil;
				  						
				  					} 
				  				}
							}

			  				$row++;
			  			}

			  			fclose($handle);

			  			//insercao das amostras
			  			
			  			$inserted = 0;
						$plotSoilData = new PlotSoil();

			  			foreach($soilsToInsert as $plotSoil) {

		  					$reply = $plotSoilData->insert($plotSoil);
		  					
		  					if ($reply['_success_'] == 1) {
		  						$inserted++;
		  					} else {
		  						$errorString .= "» Soil " . $plotSoil["soilCode"] . ", was not inserted. Error reported " . $reply["_success_"] . "; <br />";
		  					}
			  				
			  			}

			  			//mudar o ficheiro para a pasta de ficheiros processados
						if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true) {

							if($errorString != ''){
								header('Location: /forms/plotsoil-csv.php?response=13' . ($inserted > 0 ? '&inserted=' . $inserted : '') . '&reason=' . $errorString);
							} else {
								header('Location: /forms/plotsoil-csv.php?response=12&inserted=' . $inserted);	
							}

						} else {
			  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
							header('Location: /forms/plotattribute-csv.php?response=-5');
						}

			  		}

			  	}

    		} catch (Exception $e) {
				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
		  		header('Location: /forms/plotsoil-csv.php?response=-7&reason=' . $e);
    		}

    	} else {
    		header('Location: /forms/plotsoil-csv.php?response=1016');
    	}

	} else {
		header('Location: /forms/plotsoil-csv.php?response=1024');
	}

}