<?php

	require_once '../config/constants.php';
	require_once PROJECT_PATH . 'data/individual_data.php';
	require_once PROJECT_PATH . 'data/ecofisio_data.php';
	require_once PROJECT_PATH . 'checkBiologyst.php';

	if (!$_BIOLOGYST_LOGGED) {
		header('Location: ' . PROJECT_URL . 'forms/login.php?response=-1');
		die;
	} 

	if(isset($_POST["sampling_campaign_id"]) &&  $_POST["sampling_campaign_id"] != "" && isset($_POST["individualCode"]) &&  $_POST["individualCode"] != "") {

		//validar se existe individuo
		$individualData = new Individual();
		if (count($individualData->getIndividualBy($whereClause = ' individualCode = "' . $_POST["individualCode"] . '"' , $page = -1)) > 0 ) {

			$ecofisioData = new EcoFisio();

			if (count($ecofisioData->getEcoFisioBy("ef.individualCode = '" . $_POST["individualCode"] . "' and ef.sampling_campaign_id = '" . $_POST["sampling_campaign_id"] . "'", $orderBy = '', $page = -1))){

				if(isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {			

					try {

						$errorResume = '';
						$fileOperated = 0;

						for ($fileIndex = 0; $fileIndex < count($_FILES["file"]["name"]); $fileIndex++) {

							$extensionParts = explode(".", $_FILES["file"]["name"][$fileIndex]);
						  	$extension = end($extensionParts);

						  	if($extension != 'csv'){
						  		$errorResume .= '<br />» File ' . $_FILES["file"]["name"][$fileIndex] . ', File must be csv;';
						  	} else if (file_exists(PROJECT_PROCESSED_FILES . $_FILES["file"]["name"][$fileIndex])){
						  		$errorResume .= '<br />» File ' . $_FILES["file"]["name"][$fileIndex] . ', File already processed;';
						  	} else {
								
						  		move_uploaded_file($_FILES["file"]["tmp_name"][$fileIndex], PROJECT_DOCS_CENTER . $_FILES["file"]["name"][$fileIndex]);


						  		//inserir os individuos
						  		if (($handle = fopen(PROJECT_DOCS_CENTER . $_FILES["file"]["name"][$fileIndex], "r")) !== FALSE) {
						  			

									require_once PROJECT_PATH . 'data/reflectance_data.php'; 
									$reflectanceData = new Reflectance();
									$waveLengthReference = $reflectanceData->getReferenceWaveLength();
						  			$row = 1;

						        	$reflectanceRecord = array();
						        	$reflectanceRecord["individualCode"] = $_POST["individualCode"];
						        	$reflectanceRecord["sampling_campaign_id"] = $_POST["sampling_campaign_id"];
						        	$reflectanceRecord["file"] = $_FILES["file"]["name"][$fileIndex];

								    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

								    	$waveLength = trim($data[0]);
								    	if(in_array($waveLength, $waveLengthReference)) {
								        	$reflectanceRecord["c_" . substr($waveLength, 0, -2)] = $data[1];
								        	$reflectanceRecord["c_" . substr($waveLength, 0, -2) . "w"] = $data[2];
								    	}

								        $row++;
								    }


							       $reply = $reflectanceData->insert($reflectanceRecord);
								    
								    fclose($handle);
								    
							  		//mudar o ficheiro para a pasta de ficheiros processados
									if(rename(PROJECT_DOCS_CENTER . $_FILES["file"]["name"][$fileIndex], PROJECT_PROCESSED_FILES . $_FILES["file"]["name"][$fileIndex]) === true) {


										if($reply['_success_'] != 1){

											$errorResume .= '<br />» File ' . $_FILES["file"]["name"][$fileIndex] . ', Error inserting reflectance;';

										} else {

											//actualizar os valores de eco_fisio
											$replyCall = $reflectanceData->updateEcoFisioRefletanceValues($_POST["individualCode"], $_POST["sampling_campaign_id"]); 
											if ($replyCall == 1) {
												$fileOperated++;
											} else {
												$errorResume .= '<br />» File ' . $_FILES["file"]["name"][$fileIndex] . ', Eco Fisio indices were not updated;';
											}
										}

									} else {
						  				unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"][$fileIndex]);
										$errorResume .= '<br />» File ' . $_FILES["file"]["name"][$fileIndex] . ', Could not move file to final directory;';
									}
								}
							}
				  		}


				  		//validacao do sucesso da operacao
				  		if ($fileOperated > 0) {

				  			if ($errorResume != '') {
								header('Location: /lists/reflectance-list.php?individualCode=' . $_POST["individualCode"] . '&response=1001&inserted=' . $fileOperated . '&reason=' . $errorResume);
				  			} else {
								header('Location: /lists/reflectance-list.php?individualCode=' . $_POST["individualCode"] . '&response=12&inserted=' . $fileOperated);
				  			}
				  		} else {
							header('Location: /forms/reflectance-csv.php?individualCode=' . $_POST["individualCode"] . '&response=-7&reason=' . $errorResume);
						}	

				  		
					} catch (Exception $e) {
						unlink(PROJECT_DOCS_CENTER . $_FILES["file"]["name"][$fileIndex]);
				  		header('Location: /forms/reflectance-csv.php?individualCode=' . $_POST["individualCode"] . '&response=-7&reason=' . $e);
					}
					

				} else if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'form') {

					if (isset($_POST["c_529"]) && $_POST["c_529"] != "" && isset($_POST["c_529w"]) && $_POST["c_529w"] != "" &&
					    isset($_POST["c_569"]) && $_POST["c_569"] != "" && isset($_POST["c_569w"]) && $_POST["c_569w"] != "" &&
					    isset($_POST["c_680"]) && $_POST["c_680"] != "" && isset($_POST["c_680w"]) && $_POST["c_680w"] != "" &&
					    isset($_POST["c_700"]) && $_POST["c_700"] != "" && isset($_POST["c_700w"]) && $_POST["c_700w"] != "" &&
					    isset($_POST["c_706"]) && $_POST["c_706"] != "" && isset($_POST["c_706w"]) && $_POST["c_706w"] != "" &&
					    isset($_POST["c_749"]) && $_POST["c_749"] != "" && isset($_POST["c_749w"]) && $_POST["c_749w"] != "" &&
					    isset($_POST["c_898"]) && $_POST["c_898"] != "" && isset($_POST["c_898w"]) && $_POST["c_898w"] != "" &&
					    isset($_POST["c_971"]) && $_POST["c_971"] != "" && isset($_POST["c_971w"]) && $_POST["c_971w"] != "" ) {

						unset($_POST["submissionType"]);
						
						require_once PROJECT_PATH . 'data/reflectance_data.php'; 
						$reflectanceData = new Reflectance();

						if(!isset($_POST["individual_reflectance_id"])){
							$_POST["file"] = "CMS";
							$reply = $reflectanceData->insert($_POST);
							$urlComplement = 'id=' . $reply['_id_'];
						}else {
							$reply = $reflectanceData->update($_POST);
							$urlComplement = 'id=' . $_POST["individual_reflectance_id"];
						}

						if($reply['_success_'] == 1){

							//actualizar os valores de eco_fisio
							$replyCall = $reflectanceData->updateEcoFisioRefletanceValues($_POST["individualCode"], $_POST["sampling_campaign_id"]); 
							if ($replyCall == 1) {
								header('Location: /forms/reflectance.php?' . $urlComplement . '&response=1001');
							} else {
								header('Location: /forms/reflectance.php?' . $urlComplement . '&response=1004.');
							}
						} else {
							header('Location: /forms/reflectance.php?' . $urlComplement . '&response=1003');
						}

					}
				} else {
					header('Location: /forms/reflectance.php?response=-6');
				}

			} else {

				if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {
					header('Location: /forms/reflectance-csv.php?individualCode=' . $_POST["individualCode"] . '&response=1005');
				} else {
					header('Location: /forms/reflectance.php?individualCode=' . $_POST["individualCode"] . '&response=1005');
				}
			}


		} else {

			if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {
				header('Location: /forms/reflectance-csv.php?individualCode=' . $_POST["individualCode"] . '&response=1006');
			} else {
				header('Location: /forms/reflectance.php?individualCode=' . $_POST["individualCode"] . '&response=1006');
			}
		}

	} else {

		if (isset($_POST["submissionType"]) && $_POST["submissionType"] == 'excel') {
			header('Location: /forms/reflectance-csv.php?individualCode= ' . $_POST["individualCode"] . '&response=1002');
		} else {
			header('Location: /forms/reflectance.php?individualCode= ' . $_POST["individualCode"] . '&response=1002');
		}
	}

	