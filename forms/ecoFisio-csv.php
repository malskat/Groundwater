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
	    
	  	<!-- incluir menu principal -->
	    <?php include "../menu.php"; ?>

	    <div class="container">
	      <div class="row">
	      	<div class="page-header">
	         	<h1>Eco-Physiology</h1>
	        </div>
	      </div>
	    </div>

	    <?
	    	include '../data/campaign_data.php';
	    	$campaignData = new Campaign();
	    	$campaigns = $campaignData->getCampaigns(-1);

	    	include '../data/ecofisio_data.php';
	    	$ecoData = new EcoFisio();
	    	$ecoBlocks = $ecoData->getEcoFisioDataBlocks();
	    ?>

	     <div class="container">
	  		<div class="row">
	  			<div class="col-xs-12 col-lg-12">
		  			<div class="panel panel-primary">
			        	<div class="panel-heading">
						   <h3 class="panel-title">CSV Update of Eco-Physiology (Leaf or Xylem)</h3>
						</div>
				        <div class="panel-body">
				        	<div class="col-xs-8 col-lg-8">
					        	<form class="form-horizontal" role="form" name="form_eco_fisio_csv_data" enctype="multipart/form-data" action="../services/ecoFisioSubmissionData.php" onsubmit="return validateForm();"  method="post">

					        		<input type="hidden" value="excel" name="submissionType" >

					        		<!-- campaigns -->
									<div id="campaignsInputGroup" class="form-group spacer">
										<label for="inputCampaigns" class="col-lg-2 control-label">Campaign*</label>
										<div class="col-lg-6">
											<select id="sampling_campaign_id" name="sampling_campaign_id" class="form-control input-sm">
												<?
													echo '<option selected value="none">Choose one</option>';

												  	foreach($campaigns as $campaign){
												  		if(isset($campaign->sampling_campaign_id)) {
												  			echo '<option value="' . $campaign->sampling_campaign_id . '">' . $campaign->designation	 . '</option>';
												  		}
												  	}
												?>	
		              						</select>								
										</div>
									</div>

									<!-- bloco -->
									<div id="ecoBlockInputGroup" class="form-group">
										<label for="inputEcoBlock" class="col-lg-2 control-label">Block*</label>
										<div class="col-lg-6">
											<select id="ecoBlock" name="ecoBlock" class="form-control input-sm">
												<?
													echo '<option selected value="none">Choose one</option>';

												  	foreach ($ecoBlocks as $block) {
												  		if ($block["show"]) {
												  			echo '<option value="' . $block["code"] . '">' . $block["designation"]	 . '</option>';
												  		}
												  	}
												?>	
		              						</select>								
										</div>
									</div>

					  				<div id="fileInputGroup" class="form-group">
					  					<label for="inputGenus" class="col-lg-2 control-label">File*</label>
					  					<div class="col-lg-6">
					  						<input type="file" class="form-control" id="file" name="file" placeholder="">
					  				 	</div>
					  				</div>

					  				<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
										<div class="text-center">
											<button onclick="location.href='../lists/individual-list.php'" type="button" class="btn btn-xs">Cancel</button>
											<button class="btn btn-xs btn-primary" type="submit">Submit</button>
										</div>
									</div>
					  			</form>
					  		</div>
					  		<div class="col-xs-4 col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<p><span class="label label-default">Info</span></p>
										<p>This service updates individuals eco-physiology samples, from one campaign.</p>
										<p>Eco-Physiology samples must by updated in two major blocks: Leaf and Xylem Water.</p>
										<p>Only .csv files that match the structured rules are accepted.</p>
										<p>Files must follow this structure: <strong>individualCode</strong>, <strong>samplingDate</strong> (only mandatory if it is the first eco-physioloy sample update, for this campaign), <strong>block values</strong> (example: leaf_13C, leaf_15N, leaf_perN, leaf_perC, leaf_CN).</p>
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
	    		var campaign = $('#sampling_campaign_id').val();
	    		var block = $('#ecoBlock').val();
	    		var file = $('#file').val();
	    		var hasErrors = false;

	    		if(campaign == "none" ) {
	    			hasErrors = true;
	    			$('#campaignsInputGroup').addClass('has-error');
	    		} else {
	    			$('#campaignsInputGroup').removeClass('has-error');
	    		}

	    		if(block == "none" ) {
	    			hasErrors = true;
	    			$('#ecoBlockInputGroup').addClass('has-error');
	    		} else {
	    			$('#ecoBlockInputGroup').removeClass('has-error');
	    		}

	    		if(file == "" ) {
	    			hasErrors = true;
	    			$('#fileInputGroup').addClass('has-error');
	    		} else {
	    			$('#fileInputGroup').removeClass('has-error');
	    		}


	    		if (hasErrors){
	    			$('#alert-message').show();
			        $('#alert-message').addClass('danger');
			        $('#alert-text').html("<strong>Shit could happen!</strong>Atention. Missing arguments to submission!");
	    			return false;
	    		} else {
	    			return true;
	    		}

	    	}
	    </script>

	</body>
</html>