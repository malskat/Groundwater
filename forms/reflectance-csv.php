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
         		<h2>
         			Unispec - Reflectance
					<small>Individual - <?=$_GET['individualCode']?></small>
				</h2>
	        </div>
	      </div>
	    </div>

	    <?
	    	require_once '../data/campaign_data.php';
	    	$campaignData = new Campaign();
	    	$campaigns = $campaignData->getCampaigns(-1);
	    ?>

	     <div class="container">
	  		<div class="row">
	  			<div class="col-xs-12 col-lg-12">
		  			<div class="panel panel-primary">
			        	<div class="panel-heading">
						   <h3 class="panel-title">Unispec Reflectance Updates By CSV</h3>
						</div>
				        <div class="panel-body">
				        	<div class="col-xs-8 col-lg-8">
					        	<form class="form-horizontal" role="form" name="form_eco_fisio_csv_data" enctype="multipart/form-data" action="../services/reflectanceSubmissionData.php" onsubmit="return validateForm();"  method="post">

					        		<input type="hidden" value="<?=$_GET['individualCode']?>" name="individualCode">
					        		<input type="hidden" value="excel" name="submissionType" >

									<div class="form-group spacer">
				  						<label class="col-lg-3 control-label">Individual Code</label>
				  						<div class="col-lg-6">
				  							<p class="form-control-static"><?=$_GET['individualCode']?></p>
				  					 	</div>
				  					</div>


					        		<!-- campaigns -->
									<div id="campaignsInputGroup" class="form-group">
										<label for="inputCampaigns" class="col-lg-3 control-label">Campaign*</label>
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

					  				<div id="fileInputGroup" class="form-group">
					  					<label for="inputGenus" class="col-lg-3 control-label">File*</label>
					  					<div class="col-lg-6">
					  						<input type="file" class="form-control" id="file" name="file[]" multiple placeholder="">
					  				 	</div>
					  				</div>

					  				<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
										<div class="text-center">
											<button onclick="location.href='../lists/reflectance-list.php?individualCode=<?=$_GET['individualCode']?>'" type="button" class="btn btn-xs">Cancel</button>
											<button class="btn btn-xs btn-primary" type="submit">Submit</button>
										</div>
									</div>
					  			</form>
					  		</div>
					  		<div class="col-xs-4 col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<p><span class="label label-default">Info</span></p>
										<p>To update reflectance indexes provided by Unispec.</p>
										<p>Only .csv files are accepted.</p>
										<p>The submitted files must follow the structure created by the Unispec:<strong>wavelength</strong>, <strong>reflectance value</strong> and <strong>reflectance white reference</strong>.</p>
										<p><strong>Note</strong>: this service automaticaly updates the individual eco-physiology values (WI, PRI, CHL, CHL NDI and NDVI), through the reflectance values provided.</p>
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
	    		var file = $('#file').val();
	    		var hasErrors = false;

	    		if(campaign == "none" ) {
	    			hasErrors = true;
	    			$('#campaignsInputGroup').addClass('has-error');
	    		} else {
	    			$('#campaignsInputGroup').removeClass('has-error');
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