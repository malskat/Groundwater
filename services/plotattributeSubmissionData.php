<?php

require_once '../config/constants.php';
require_once '../data/plotattribute_data.php';
require_once "../checkBiologyst.php";
require_once "../data/campaign_data.php";
require_once "../data/plot_data.php";
require_once "../data/plotattribute_data.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: ' . PROJECT_URL . 'forms/login.php?response=-1');
	die;
} 

if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form') {
	
	if (isset($_POST["plot_id"]) && $_POST["plot_id"] != "" && isset($_POST["measureDate"]) && $_POST["measureDate"] != "" && 
	   	isset($_POST["sampling_campaign_id"]) && $_POST["sampling_campaign_id"] != "") {

		unset($_POST["submissionType"]);

		$plotAttributeData = new PlotAttribute();

		$urlComplement = '?plot=' . $_POST["plot_id"];

		if (isset($_POST["plot_attribute_id"])) {
			$reply = $plotAttributeData->update($_POST);
			$urlComplement .= '&id=' . $_POST["plot_attribute_id"];
		}else {
			$reply = $plotAttributeData->insert($_POST);
			$urlComplement .= '&id=' . $reply['_id_'];
		}

		if ($reply['_success_'] == 1){
			header('Location: /forms/plotattribute.php' . $urlComplement . '&response=1011');
		} else {
			header('Location: /forms/plotattribute.php' . $urlComplement . '&response=1013');
		}

	} else {
		header('Location: /forms/plotattribute.php' . $urlComplement . '&response=1012');
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
					header('Location: /forms/plotattribute-csv.php?response=-3');
			  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])) {
					header('Location: /forms/plotattribute-csv.php?response=-4');
			  	} else {

			  		//movimentacao do ficheiro da pasta temporaria para a pasta final
			  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);

			  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {

			  			$inserted = 0;
			  			$row = 1;
			  			$errorString = '';
			  			$whereClause = '';

			  			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			  			 	
			  			 	if ($row == 1) {

		       					$lowerData = array_map('strtolower', $data);

					        	if (array_search("sitecode", $lowerData) === false ||
					        	    array_search("plotcode", $lowerData) === false ||
					        	    array_search("groundwater_18o", $lowerData) === false ||
					        	    array_search("pondwater_18o", $lowerData) === false) {

					        		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
									header('Location: /forms/plotattribute-csv.php?response=1015');
									die;
					        	}
					        } else {

					        	$plot = array();

					    		//encontrar Plot e validar se esta ligado ao mesmo site da Campanha
								$plotData = new Plot();
								$whereClause = "s.code = '" . $data[0] . "' and p.code = '" . $data[1] . "'";
								$plot = $plotData->getPlotBy($whereClause, $page = -1, $withTotals = 0);
								
								if (count($plot) == 0 || $plot[0]->site_id != $campaign[0]->site_id) {
						    		$errorString .= "» Line " . $row . ", Plot '" . $data[1] . "' does not belong to the Site Campaign selection; <br />";
								} else {

									//validar se o plot ja tem medicoes para esta campanha
						        	$plotAttributeData = new PlotAttribute();
						        	$whereClause = "pa.sampling_campaign_id = " . $campaign[0]->sampling_campaign_id . " and pa.plot_id = " . $plot[0]->plot_id;
									$plotAttribute = $plotAttributeData->getPlotAttributeBy($whereClause, $page = -1, $withTotals = 0);
									
									if (count($plotAttribute) == 0 ) {

										$plotAttributeRecord = array();
				        				$plotAttributeRecord['sampling_campaign_id'] = $_POST["sampling_campaign_id"];
		        						$plotAttributeRecord['plot_id'] = $plot[0]->plot_id;
		        						$plotAttributeRecord['measureDate'] = $data[2];

		        						if ($data[3] != "") {
		        							$plotAttributeRecord['groundWater_18o'] = $data[3];
		        						}

		        						if ($data[4] != "") {
		        							$plotAttributeRecord['pondWater_18o'] = $data[4];
		        						}

		        						if ($data[5] != "") {
		        							$plotAttributeRecord['gw_level'] = $data[5];
		        						}

		        						$plotAttributeRecord["file"] = $_FILES["file"]["name"];

		        						$reply = array();
		        						$reply = $plotAttributeData->insert($plotAttributeRecord);
										
										if ($reply['_success_'] == 1) {
					        				$inserted++;
					        			}

									} else {
										$errorString .= "» Line " . $row . ",  Plot '" . $data[1] . "' already has Water Info for this campaign; <br />";
									}
								}	
			  			 	}

					        $row++;
			  			 }

			  			 fclose($handle);

			  			//mudar o ficheiro para a pasta de ficheiros processados
						if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true) {

							if($errorString != ''){
								header('Location: /forms/plotattribute-csv.php?response=13' . ($inserted > 0 ? '&inserted=' . $inserted : '') . '&reason=' . $errorString);
							} else {
								header('Location: /forms/plotattribute-csv.php?response=12&inserted=' . $inserted);	
							}

						} else {
			  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
							header('Location: /forms/plotattribute-csv.php?response=-5');
						}

			  		}

			  	}

			} catch (Exception $e) {
				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
		  		header('Location: /forms/plotattribute-csv.php?response=-7&reason=' . $e);
			}


    	} else {
    		header('Location: /forms/plotattribute-csv.php?response=1016');
			die;
    	}

	} else {
		header('Location: /forms/plotattribute-csv.php?response=1014');
	}
}