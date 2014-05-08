<?php

require_once '../config/constants.php';
require_once '../data/site_climate_data.php';
	
if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form'){

	unset($_POST["submissionType"]);
	$success = insertSiteClimateData($_POST);
	
	if($success == 1){
		header('Location: ' . PROJECT_URL . 'index.html?success=1');
	}

	
}else if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel'){
	if ($_FILES["file"]["error"] > 0){
		header('Location: ' . PROJECT_URL . 'index.html?success=-1&reason=' . $_FILES["file"]["error"]);
  	}else{

  		try{
		  	/*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		 	echo "Type: " . $_FILES["file"]["type"] . "<br>";
		  	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		  	echo "Stored in: " . $_FILES["file"]["tmp_name"]; */
		  	$extensionParts = explode(".", $_FILES["file"]["name"]);
		  	$extension = end($extensionParts);

		  	if($extension != 'csv'){
				header('Location: ' . PROJECT_URL . 'index.html?success=-1&reason=Ficheiro tem de ser csv');
		  	} else if (file_exists(PROJECT_DOCS_CENTER . $_FILES["file"]["name"])){
				header('Location: ' . PROJECT_URL . 'index.html?success=-1&reason=Ficheiro ja foi processado');
		  	}else{

		  		//mover o ficheiro da pasta temporaria
		  		move_uploaded_file($_FILES["file"]["tmp_name"], PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);

		  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], "r")) !== FALSE) {
		  			
		  			$row = 1;
			        $toInsert = array('site_id' => $_POST['site_id']);
			        $labels = array('site_id');
				    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				        
			       		$numFields = count($data);
				        for ($c=0; $c < $numFields; $c++) {
				        	
				        	if($row == 1){
				        		$labels[] = $data[$c];
				        	}else{
				        		$toInsert [$labels[($c + 1)]] = $data[$c];
				        	}
				        }

				        //inserir na BD
				        if ($row > 1){
							$success = insertSiteClimateData($toInsert);
				        }


				        $row++;
				    }
				    
				    /*echo "<pre>";
				    var_dump($labels, $toInsert);*/
				    fclose($handle);
				}

				//mudar o ficheiro para a pasta final
				if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"]) === true){
					header('Location: ' . PROJECT_URL . 'index.html?success=1');	
				}else{
	  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
					header('Location: ' . PROJECT_URL . 'index.html?success=-1&reason=ficheiro nao passou para a directoria final');
				}


		  	}
	  	}catch(Exception $e){
	  		unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"]);
	  		header('Location: ' . PROJECT_URL . 'index.html?success=-1&reason=' . $e);
	  	}
	}
}else{
	echo 'N&atilde;o estamos preparados para mais nenhum tipo de carregamento de informa&ccedil;&atilde;o, a n&atilde;o ser por formul&aacute;rio ou excel.';
}

