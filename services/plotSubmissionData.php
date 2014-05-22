<?php

require_once '../config/constants.php';
require_once '../data/plot_data.php';
require_once '../data/site_data.php';


if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){
	if(isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["coordinateX"]) && $_POST["coordinateX"] != ""
			&& isset($_POST["coordinateY"]) && $_POST["coordinateY"] != "" && isset($_POST["site_id"]) && $_POST["site_id"] != ""){

		unset($_POST["submissionType"]);

		if($_POST["plotType"] == "none") {
			unset($_POST["plotType"]);
		}

		$plotData = new Plot();

		if(!isset($_POST["plot_id"])){
			$success = $plotData->insertPlot($_POST);
		}else{
			$success = $plotData->updatePlot($_POST);
		}
		
		if($success == 1){
			header('Location: ' . PROJECT_URL . 'lists/plot-list.html?success=1');
		} else {
			header('Location: ' . PROJECT_URL . 'lists/plot-list.html?success=-3&reason=Nao houve alteracao nenhuma!');
		}

		
	}else{
		header('Location: ' . PROJECT_URL . 'forms/plot.html?success=-1&reason=Faltam parametros!');
	}
}
else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel'){

	try{

		$extensionParts = explode(".", $_FILES["file"]["name"]);
	  	$extension = end($extensionParts);

	  	if($extension != 'csv'){
			header('Location: ' . PROJECT_URL . 'forms/plot-csv.html?success=-1&reason=Ficheiro tem de ser csv.');
	  	} else if (file_exists(PROJECT_DOCS_CENTER . $_FILES["file"]["name"])){
			header('Location: ' . PROJECT_URL . 'forms/plot-csv.html?success=-1&reason=Ficheiro ja foi processado.');
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
			        
		       		//inserir na BD
			        if ($row > 1){

		        		$toInsert = array();

		        		$site = $siteData->getSiteBy("code = '". $data[0]."'", -1);
		        		if (count($site) == 1){

	        				echo '<pre>';
	        				$toInsert['site_id'] = $site[0]->site_id;
				        	$toInsert['code'] = $data[1];
				        	$toInsert['coordinateX'] = $data[2];
				        	$toInsert['coordinateY'] = $data[3];

							if($plotData->insertPlot($toInsert) == 1) {
								$inserted++;
							}
		        			
		        		}else{

		        			$errorString .= '» Linha ' . ($row - 1) . ', code ' . $data[1] . ': local não foi encontrado; \n';

		        		}
			        }


			        $row++;
			    }
			    
			    fclose($handle);

		  		//mudar o ficheiro para a pasta de ficheiros processados
				if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true){

					if($errorString != ''){
						header('Location: ' . PROJECT_URL . 'lists/plot-list.html?success=-2&reason='.$errorString);
					}else{
						header('Location: ' . PROJECT_URL . 'lists/plot-list.html?success=1&inserted=' . $inserted);	
					}

				}else{
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: ' . PROJECT_URL . 'lists/plot-list.html?success=-1&reason=ficheiro nao passou para a directoria final!');
				}
			}


	  	}
	}catch(Exception $e){
		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
  		header('Location: ' . PROJECT_URL . 'lists/plot-list.html?success=-1&reason=' . $e);
	}
}