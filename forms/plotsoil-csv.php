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
    <script src="../js/fileinput.min.js" type="text/javascript"></script>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap alerts -->
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">
    <link href="../css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

  </head>

	<body>

		<?php
			$backUrl = '../lists/plot-list.php';
		?>
	    
	  	<!-- incluir menu principal -->
	    <?php include "../menu.php"; ?>

	    <div class="container">
	      <div class="row">
	      	<div class="page-header">
	         	<h2>
	         		Plot Soil Info
	         	</h2>
	        </div>
	      </div>
	    </div>

	    <?
	    	include '../data/campaign_data.php';
	    	$campaignData = new Campaign();
	    	$campaigns = $campaignData->getCampaigns(-1);
	    ?>

	     <div class="container">
	  		<div class="row">
	  			<div class="col-xs-12 col-lg-12">
		  			<div class="panel panel-primary">
			        	<div class="panel-heading">
						   <h2 class="panel-title">
						   		CSV Load of Plot Soil Info
						   </h2>
						</div>
				        <div class="panel-body">
				        	<div class="col-xs-8 col-lg-8">
					        	<form class="form-horizontal" role="form" name="form_eco_fisio_csv_data" enctype="multipart/form-data" action="../services/plotsoilSubmissionData.php" onsubmit="return validateForm();"  method="post">

					        		<input type="hidden" value="excel" name="submissionType" >

					        		<? 
					        			if (isset($_GET['plot'])) {
					        				echo '<input type="hidden" value="' . $_GET['plot']  . '" name="plot" >';
					        			}
					        		?>

					        		<!-- campaigns -->
									<div id="campaignsInputGroup" class="form-group spacer">
										<label for="inputCampaigns" class="col-lg-2 control-label">Campaign*</label>
										<div class="col-lg-8">
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
					  					<label for="inputGenus" class="col-lg-2 control-label">File*</label>
					  					<div class="col-lg-10">
					  						<input type="file" class="form-control" id="file" name="file" placeholder="">
					  				 	</div>
					  				</div>

					  				<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
										<div class="text-center">
											<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
											<button class="btn btn-xs btn-primary" type="submit">Submit</button>
										</div>
									</div>
					  			</form>
					  		</div>
					  		<div class="col-xs-4 col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<p><span class="label label-default">Info</span></p>
										<p>This service updates Plot Soil Info, <strong>to one campaign</strong>, for <strong>one or multiple Plots</strong>, <strong> in one Site</strong>.</p>
										<p>Only .csv files that match the structured rules are accepted.</p>
										<p>Files must follow this structure: <strong>siteCode</strong> (for better file identification and organization), <strong>plotCode</strong>, <strong>measureDate</strong> (not mandatory), <strong>hole</strong> (code to identify the hole within this plot sample, like <em>Soil1</em> or <em>Soil2</em>), <strong>depth</strong> (range from 1 to 3, being 1 equivalent to 10 cm, the only mandatory), <strong>value</strong> and <strong>soilWaterContent</strong> (only one value per hole).</p>
										<p>Remember, there is always a reference file to consult.</p>
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


	    	$("#file").fileinput({'showUpload':false});



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
			        $('#alert-text').html("<strong>Attention:</strong> Missing arguments to this Plot Water Info import!");
	    			return false;
	    		} else {
	    			return true;
	    		}

	    	}
	    </script>

	</body>
</html>