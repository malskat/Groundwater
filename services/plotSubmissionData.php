<?php

require_once '../config/constants.php';
require_once '../data/plot_data.php';
require_once '../data/site_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: /forms/login.php?response=-1');
	die;
} 



if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){
	if(isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["coordinateX"]) && $_POST["coordinateX"] != ""
			&& isset($_POST["coordinateY"]) && $_POST["coordinateY"] != "" && isset($_POST["site_id"]) && $_POST["site_id"] != ""){

		unset($_POST["submissionType"]);

		if($_POST["plotType"] == "none") {
			unset($_POST["plotType"]);
		}

		$plotData = new Plot();
		$urlComplement = '';

		if (!isset($_POST["plot_id"])){
			$reply = $plotData->insert($_POST);
			$urlComplement = '&plot_id=' . $reply["_id_"];
		} else {
			$reply = $plotData->update($_POST);
			$urlComplement = '&plot_id=' . $_POST["plot_id"];
		}
		
		if ($reply['_success_'] == 1){
			header('Location: /forms/plot.php?response=401' . $urlComplement);
		} else {
			header('Location: /forms/plot.php?response=403' . $urlComplement);
		}

		
	}else{
		header('Location: /forms/plot.php?response=402');
	}
}
else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel'){

	try{

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: /forms/plot-csv.php?response=-3');
	  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"])){
			header('Location: /forms/plot-csv.php?response=-4');
	  	}else{
			//mover o ficheiro da pasta temporaria
	  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);


	  		//inserir os plots
	  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {
	  			
	  			$plotData = new Plot();
	  			$siteData = new Site();
	  			$row = 1;
	  			$errorString = '';
	  			$inserted = 0;
			    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			        if ($row == 1) {

		       			$lowerData = array_map('strtolower', $data);

			        	if (array_search("sitecode", $lowerData) === false ||
			        	    array_search("plotcode", $lowerData) === false || 
	  					    array_search("coordinatex", $lowerData) === false || 
	  					    array_search("coordinatey", $lowerData) === false) {

							unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
							header('Location: /forms/plot-csv.php?response=405');
							die;
			        	}

			        } else {

		        		$toInsert = array();

		        		$site = $siteData->getSiteBy("code = '". $data[0]."'", -1);
		        		if (count($site) == 1) {

		        			//validar se o plot ja existe na BD
		        			$plot = $plotData->getPlotBy("p.site_id = " . $site[0]->site_id . " and p.code = '" . $data[1] . "'", -1);

		        			if (count($plot) == 0) {

			       				//inserir na BD
		        				$toInsert['site_id'] = $site[0]->site_id;
					        	$toInsert['code'] = $data[1];
					        	$toInsert['coordinateX'] = $data[2];
					        	$toInsert['coordinateY'] = $data[3];

					        	$reply = $plotData->insert($toInsert);

								if ($reply['_success_'] == 1 ) {
									$inserted++;
								}
		        			} else {
		        				$errorString .= '» Line ' . ($row - 1) . ', code ' . $data[1] . ': Plot already inserted; <br />';
		        			}
		        			
		        		} else {

		        			$errorString .= '» Line ' . ($row - 1) . ', code ' . $data[1] . ': unkown site; <br />';

		        		}
			        }


			        $row++;
			    }
			    
			    fclose($handle);

		  		//mudar o ficheiro para a pasta de ficheiros processados
				if (rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true) {

					if ($errorString != '') {
						header('Location: /forms/plot-csv.php?response=13&reason=' . $errorString);
					} else {
						header('Location: /forms/plot-csv.php?response=12&inserted=' . $inserted);	
					}

				} else {
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: /forms/plot-csv.php?response=-5');
				}
			}


	  	}
	} catch(Exception $e) {
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: /lists/plot-list.php?response=-7&reason=' . $e);
	}
}

?>