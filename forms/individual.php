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
    <script src="../js/bootstrap-formhelpers-selectbox.js"></script>
    <!-- Bootstrap theme -->
    <link href="../css/bootstrap-formhelpers.css" rel="stylesheet">
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
		include "../data/species_data.php";
		include "../data/plot_data.php";

		$speciesData = new Species(); 
		$species = $speciesData->getSpecies(-1);

		$plotData = new Plot();
		$plots = $plotData->getPlotsSite(-1);

		if(isset ($_GET["individualCode"])){
  			include "../data/individual_data.php"; 
  			$individualData = new Individual();
			$individual = $individualData->getIndividualBy("individualCode = '" . $_GET["individualCode"] . "'", -1);
  		}

  		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  		if (false === strpos($backUrl, 'individual-list')) {
			$backUrl = '../lists/individual-list.php';
  		} 
	?>


  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>


    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	       		<h1>Individual</h1>
	      	</div>
	    </div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-12">
		        <div class="panel panel-primary">
		        	<div class="panel-heading clearfix">
				   		<h3 class="panel-title pull-left"><?= (isset($individual) ? "Edit Individual" : "Insert Individual") ?></h3>
				   		<div class="btn-group pull-right">
							<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
								Samples and Graphs <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
			    				<li role="presentation" class="dropdown-header">Samples</li>
								<li><a href="../lists/ecofisio-list.php?individualCode=<?=$individual[0]->individualCode?>"><strong>Eco-Physiology</strong></a></li>
								<li><a href="../lists/reflectance-list.php?individualCode=<?=$individual[0]->individualCode?>"><strong>Unispec - Reflectance</strong></a></li> 
								<li role="presentation" class="divider"></li>
			    				<li role="presentation" class="dropdown-header">Graphs</li>
								<li><a href="../charts/ecofisio-temporaloverview.php?individualCode=<?=$individual[0]->individualCode?>"><strong>Temporal Overview</strong></a></li>
								<li><a href="../charts/ecofisio-leaf13Cleaf15N.php?individualCode=<?=$individual[0]->individualCode?>"><strong>Leaf 13C and Leaf 15N / Xylem 18O</strong></a></li>
								<li><a href="../charts/ecofisio-leaf13Cpri.php?individualCode=<?=$individual[0]->individualCode?>"><strong>Leaf 13C and PRI / Xylem 18O</strong></a></li>
								<li><a href="../charts/ecofisio-leaf15NleafCN.php?individualCode=<?=$individual[0]->individualCode?>"><strong>Leaf 15N and Leaf CN / Xylem 18O</strong></a></li>
								<li><a href="../charts/ecofisio-wi-ndvi.php?individualCode=<?=$individual[0]->individualCode?>"><strong>WI and NDVI / Xylem 18O</strong></a></li>
								<li><a href="../charts/ecofisio-pri-chl-ndi.php?individualCode=<?=$individual[0]->individualCode?>"><strong>PRI and CHL_NDI / Xylem 18O</strong></a></li>
							</ul>
						</div>
					</div>
			        <div class="panel-body">
						<div class="col-xs-8 col-lg-8">
				        	<form class="form-horizontal" role="form" name="form_siteindividual_data" action="../services/individualSubmissionData.php" onsubmit="return validateForm();" method="post">

						        <input type="hidden" value="form" name="submissionType">
						     	<input type="hidden" value=<?= (isset($individual) ? '"edit"' : '"insert"')?> name="operationType" >

						     	<?
						     		if (!isset($individual)) {

								    	echo '<div id="individualCodeInputGroup" class="form-group">
										      	<label for="inputCode" class="col-lg-3 control-label">Code*</label>
										      	<div class="col-lg-4">
										        	<input type="text" class="form-control" id="individualCode" name="individualCode" placeholder="Individual Code">
									      		</div>
									    	</div>';

						     		} else {
						     			echo '<input type="hidden" value="' . $individual[0]->individualCode . '" name="individualCode">';
						     			echo '<div class="form-group">
						  						<label class="col-lg-3 control-label">Code</label>
						  						<div class="col-lg-4">
						  							<p class="form-control-static">' . $individual[0]->individualCode . '</p>
						  					 	</div>
						  					</div>';
						     		}
						     	?>


						    	<div class="form-group">
							      	<label for="inputGenus" class="col-lg-3 control-label">Phenological Type</label>
							      	<div class="col-lg-4">
							        	<input type="text" class="form-control" id="phenologicalType" name="phenologicalType" placeholder="" value=<?= (isset($individual) ? '"' . $individual[0]->phenologicalType . '"' : "") ?>>
							      	</div>
						    	</div>

						    	<div id="plotInputGroup" class="form-group">
							      	<label for="inputGenus" class="col-lg-3 control-label">Plot*</label>
							      	<div class="col-lg-4">
							        	<div class="bfh-selectbox">
							          	<input type="hidden" id="plot" name="plot_id" value=<?= (isset($individual) ? $individual[0]->plot_id : "") ?>>
							          	<a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
							            	<span class="bfh-selectbox-option input-medium" data-option=""><?= (isset($individual) ? $individual[0]->siteTitle . ' - ' . $individual[0]->plotCode : " - Choose one -") ?></span>
							            	<b class="caret"></b>
							          	</a>
							          	<div class="bfh-selectbox-options">
							            	<input type="text" class="bfh-selectbox-filter">
							            	<div role="listbox">
							            	<ul role="option">
							              	<? 
							              	foreach($plots as $plot){
							                	echo '<li> <a tabindex="-1" href="#" data-option=' . $plot->plot_id . '>' . $plot->title . " - " . $plot->code . '</a></li>';
							              	}
							            	?>
							            	</ul>
							          	</div>
							          	</div>
							        	</div>
							      	</div>
						        </div>

						        <div id="speciesInputGroup" class="form-group">
							    	<label for="inputGenus" class="col-lg-3 control-label">Species*</label>
							      	<div class="col-lg-4">
							        	<div class="bfh-selectbox">
							          	<input type="hidden" id="species" name="species_id" value=<?= (isset($individual) ? $individual[0]->species_id : "") ?>>
							          	<a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
							            	<span class="bfh-selectbox-option input-medium" data-option=""><?= (isset($individual) ? $individual[0]->genus . ' - ' . $individual[0]->species : " - Choose one -") ?></span>
							            	<b class="caret"></b>
							          	</a>
							          	<div class="bfh-selectbox-options">
							            	<input type="text" class="bfh-selectbox-filter">
							            	<div role="listbox">
							            	<ul role="option">
							              	<? 
							              	foreach($species as $specie){
							                	echo '<li> <a tabindex="-1" href="#" data-option=' . $specie->species_id . '>' . $specie->genus . " - " . $specie->species . '</a></li>';
							              	}
							            	?>
							            	</ul>
							          	</div>
							          	</div>
							        	</div>
							      	</div>
						    	</div>

						    	<div id="coordinateXInputGroup" class="form-group">
							      	<label for="inputGenus" class="col-lg-3 control-label">Coordinate X*</label>
							      	<div class="col-lg-4">
							        	<input type="text" class="form-control" id="coordinateX" name="coordinateX" placeholder="" value=<?= (isset($individual) ? '"' . $individual[0]->coordinateX . '"' : "")?>>
							      	</div>
						    	</div>
						    	<div id="coordinateYInputGroup"  class="form-group">
							      	<label for="inputGenus" class="col-lg-3 control-label">Coordinate Y*</label>
							      	<div class="col-lg-4">
							        	<input type="text" class="form-control" id="coordinateY" name="coordinateY" placeholder="" value=<?= (isset($individual) ? '"' . $individual[0]->coordinateY . '"' : "")?>>
							      	</div>
						    	</div>



						    	<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
									<div class="text-center">
										<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
										<button class="btn btn-xs btn-primary" type="submit"><?=(isset($individual) ? "Change" : "Submit")?></button>
									</div>
								</div>

						  	</form>
						</div>

						<div class="col-xs-4 col-lg-4">
					        <div class="panel panel-default">
						        <div class="panel-body">
						        	<p><span class="label label-default">Info</span></p>
						        	<p>This form is meant to insert and update Individuals general information.</p>	
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
    		var individualCode = $('#individualCode').val();
    		var species = $('#species').val();
    		var plot = $('#plot').val();
    		var coordinateX = $('#coordinateX').val();
    		var coordinateY = $('#coordinateY').val();
    		var hasErrors = false;


    		if(individualCode == "" ) {
    			hasErrors = true;
    			$('#individualCodeInputGroup').addClass('has-error');
    		} else {
    			$('#individualCodeInputGroup').removeClass('has-error');
    		}

			if(species == ""){
    			hasErrors = true;
				$('#speciesInputGroup').addClass('has-error');
			} else {
    			$('#speciesInputGroup').removeClass('has-error');
    		}

    		if(plot == "" ) {
    			hasErrors = true;
    			$('#plotInputGroup').addClass('has-error');
    		} else {
    			$('#plotInputGroup').removeClass('has-error');
    		}

    		if(coordinateX == "" ) {
    			hasErrors = true;
    			$('#coordinateXInputGroup').addClass('has-error');
    		} else {
    			$('#coordinateXInputGroup').removeClass('has-error');
    		}

    		if(coordinateY == "" ) {
    			hasErrors = true;
    			$('#coordinateYInputGroup').addClass('has-error');
    		} else {
    			$('#coordinateYInputGroup').removeClass('has-error');
    		}

    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens!</strong>Atenção. Faltam parâmetros ao indivíduo!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>