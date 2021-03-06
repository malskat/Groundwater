<?php
	include "../checkBiologyst.php";
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>GWTropiMed Project</title>

    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap alerts -->
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">

  </head>

  <body>

  	<?
		if(isset ($_GET["species_id"])){
			include "../data/species_data.php"; 

			$speciesData = new Species();        
			$specieObj = $speciesData->getSpeciesBy("species_id = " . $_GET["species_id"], -1);

		}


		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
		if (false === strpos($backUrl, 'species-list')) {
			$backUrl = '../lists/species-list.php';
		} 
    ?>

    <!-- incluir menu principal -->
    <?php include "../menu.php"; ?>

    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	     		<h1>Species</h1>
	    	</div>
	    </div>
	</div>

	<div class="container">
  		<div class="row">
  			<div class="col-xs-12 col-lg-12">
		        <div class="panel panel-primary">
		        	<div class="panel-heading">
					   <h3 class="panel-title"><?=((isset($specieObj) && count($specieObj) > 0) ? "Edit Species" : "Insert Species")?></h3>
					</div>
			        <div class="panel-body">
                        <div class="col-xs-8 col-lg-8">
    			        	<form class="form-horizontal" role="form" name="form_site_data" action="../services/speciesSubmissionData.php" onsubmit="return validateForm();" method="post">

                                <input type="hidden" value="form" name="submissionType">
    					        <?= (isset($specieObj) && is_array($specieObj) && count($specieObj)  ?'<input type="hidden" value="' . $specieObj[0]->species_id . '" name="species_id" >' : '')?>

    					        <div id="genusInputGroup" class="form-group">
    					        	<label for="inputGenus" class="col-lg-2 control-label">Genus*</label>
    					        	<div class="col-lg-5">
    					          	<input type="text" class="form-control" id="genus" name="genus" placeholder="Species Genus" value=<?= (isset($specieObj) ? '"' . $specieObj[0]->genus . '"' : "") ?>>
    					        	</div>
    					      	</div>
    					      	<div id="speciesInputGroup" class="form-group">
    					        	<label for="inputSpecie" class="col-lg-2 control-label">Species*</label>
    					        	<div class="col-lg-5">
    					          	<input type="text" class="form-control" id="species" name="species" placeholder="" value=<?= (isset($specieObj) ? '"' . $specieObj[0]->species . '"' : "") ?>>
    					        	</div>
    					      	</div>
    					      	<div id="typeInputGroup" class="form-group">
    					        	<label for="inputType" class="col-lg-2 control-label">Type*</label>
    					        	<div class="col-lg-5">
    					          	<input type="text" class="form-control" id="type" name="type" placeholder="" value=<?= (isset($specieObj) ? '"' . $specieObj[0]->type . '"' : "") ?>>
    					        	</div>
    					      	</div>

    					      	<div id="codeInputGroup" class="form-group">
    					        	<label for="inputCode" class="col-lg-2 control-label">Code*</label>
    					        	<div class="col-lg-5">
    					          	<input type="text" class="form-control" id="code" name="code" placeholder="" value=<?= (isset($specieObj) ? '"' . $specieObj[0]->code . '"' : "") ?>>
    					        	</div>
    					      	</div>

                                <div class="form-group">
                                    <label for="inputFunctionalGroup" class="col-lg-2 control-label">Functional Group</label>
                                    <div class="col-lg-5">
                                    <input type="text" class="form-control" id="functionalGroup" name="functionalGroup" placeholder="" value=<?= (isset($specieObj) ? '"' . $specieObj[0]->functionalGroup . '"' : "") ?>>
                                    </div>
                                </div>


    							<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
    								<div class="text-center">
    									<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
    									<button class="btn btn-xs btn-primary" type="submit"><?=(isset($specieObj) ? "Change" : "Submit")?></button>
    								</div>
    							</div>
                            </form>
                        </div>

                        <div class="col-xs-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p><span class="label label-default">Info</span></p>
                                    <p>To insert and update Individual Species.</p>
                                    <p><strong>All fields with * are mandatory.</strong></p>
                                </div>
                            </div>
                        </div>
			        </div>
			    </div>
			</div>
  		</div>
    </div>

    <?php include "../footer.php";?>

    <script>
    	function validateForm(){
    		var code = $('#code').val();
    		var type = $('#type').val();
    		var genus = $('#genus').val();
    		var species = $('#species').val();
    		var hasErrors = false;


    		if(code == "" ) {
    			hasErrors = true;
    			$('#codeInputGroup').addClass('has-error');
    		} else {
    			$('#codeInputGroup').removeClass('has-error');
    		}

    		if(genus == "" ) {
    			hasErrors = true;
    			$('#genusInputGroup').addClass('has-error');
    		} else {
    			$('#genusInputGroup').removeClass('has-error');
    		}

			if(species == ""){
    			hasErrors = true;
				$('#speciesInputGroup').addClass('has-error');
			} else {
    			$('#speciesInputGroup').removeClass('has-error');
    		}

    		if(type == "" ) {
    			hasErrors = true;
    			$('#typeInputGroup').addClass('has-error');
    		} else {
    			$('#typeInputGroup').removeClass('has-error');
    		}

    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Attention: </strong> Missing parameters to this Species.");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>


  </body>
</html>