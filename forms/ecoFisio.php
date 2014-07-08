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
    <script src="../js/bootstrap-formhelpers-datepicker.js"></script>
    <script src="../js/bootstrap-formhelpers-datepicker.pt_PT.js"></script>
    <script src="../js/bootstrap-formhelpers-selectbox.js"></script>
    <link href="../css/bootstrap-formhelpers.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap alerts -->
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

  </head>

	<body>


	  	<?
	  		$individualCode = '';
	  		$campaigns = array();
	  		if(isset($_GET["individualCode"]) && isset($_GET["sampling_campaign_id"])){
	  			include "../data/ecofisio_data.php"; 
	  			
	  			$ecoFisioData = new EcoFisio();
				$ecoFisio = $ecoFisioData->getEcoFisioBy(" ef.individualCode = '" . $_GET["individualCode"] . "' and ef.sampling_campaign_id = " . $_GET["sampling_campaign_id"], $orderBy = '', $page = -1);
				$individualCode = $ecoFisio[0]->individualCode;
	  		} else {
				$individualCode = $_GET['individualCode'];
	  			include "../data/campaign_data.php"; 
	  			$campaignData = new Campaign();
	    		$campaigns = $campaignData->getCampaigns(-1);
	  		}
	  	?>
    
	  	<!-- incluir menu principal -->
	    <?php include "../menu.php"; ?>

	    <div class="container">
	      <div class="row">
	      	<div class="page-header">
	         	<h2>
	         		Eco-Physiology
					<small>Individual - <?=$_GET['individualCode']?></small>
				</h2>
	        </div>
	      </div>
	    </div>

	    <div class="container">
	      <div class="row">
	        <div class="col-xs-12 col-lg-12">
	          <div class="panel panel-primary">
	            <div class="panel-heading">
	              <h3 class="panel-title"><?= (isset($ecoFisio) ? "Sample Edition" : "Sample Insert") ?></h3>
	            </div>
	            <div class="panel-body">
					<div class="col-xs-8 col-lg-8">
						<form class="form-horizontal" role="form" name="form_eco_fisio_data" action="../services/ecoFisioSubmissionData.php" onsubmit="return validateForm();" method="post">

							<input type="hidden" value="<?=$individualCode?>" name="individualCode">
							<input type="hidden" value="form" name="submissionType">

							<div class="form-group">
		  						<label class="col-lg-4 control-label">Individual Code</label>
		  						<div class="col-lg-4">
		  							<p class="form-control-static"><?=$individualCode?></p>
		  					 	</div>
		  					</div>

		  					<? 
		  					if (isset($ecoFisio)) {
		  						echo '<input type="hidden" value="' . $ecoFisio[0]->sampling_campaign_id . '" name="sampling_campaign_id" >';
		  						echo '<input type="hidden" value="update" name="operationType" >';
		  						echo '<div class="form-group">
				  						<label class="col-lg-4 control-label">Campaign</label>
				  						<div class="col-lg-4">
				  							<p class="form-control-static">'. $ecoFisio[0]->campaignDesignation . '</p>
				  					 	</div>
				  					</div>'; 
			  				} else {
			  					echo '<input type="hidden" value="insert" name="operationType" >';
			  					echo '<div id="campaignsInputGroup" class="form-group">
										<label for="inputCampaigns" class="col-lg-4 control-label">Campaign*</label>
										<div class="col-lg-4">
											<select id="sampling_campaign_id" name="sampling_campaign_id" class="form-control input-sm">';

							  	foreach($campaigns as $campaign){
							  		if(isset($campaign->sampling_campaign_id)) {
							  			echo '<option value="' . $campaign->sampling_campaign_id . '">' . $campaign->designation . '</option>';
							  		}
							  	}
		              			echo '		</select>								
										</div>
									</div>';
			  				}
		  					?>

		  					<div id="samplingDateInputGroup" class="form-group">
								<label for="inputSamplingDate" class="col-lg-4 control-label">Sample Date*</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="samplingDate" name="samplingDate" class="input-medium" readonly value= <?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->samplingDate . '"' : "") ?>>
									  </div>
									  <div class="bfh-datepicker-calendar">
									    <table class="calendar table table-bordered">
									      <thead>
									        <tr class="months-header">
									          <th class="month" colspan="4">
									            <a class="previous" href="#"><i class="icon-chevron-left"></i></a>
									            <span></span>
									            <a class="next" href="#"><i class="icon-chevron-right"></i></a>
									          </th>
									          <th class="year" colspan="3">
									            <a class="previous" href="#"><i class="icon-chevron-left"></i></a>
									            <span></span>
									            <a class="next" href="#"><i class="icon-chevron-right"></i></a>
									          </th>
									        </tr>
									        <tr class="days-header">
									        </tr>
									      </thead>
									      <tbody>
									      </tbody>
									    </table>
									  </div>
									</div>
								</div>
							</div>

							<div id="leaf_13CInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">Leaf_13C</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="leaf_13C" name="leaf_13C" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->leaf_13C . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="leaf_15NInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">Leaf_15N</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="leaf_15N" name="leaf_15N" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->leaf_15N . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="leafNInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">Leaf_%N</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="leaf_perN" name="leaf_perN" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->leaf_perN . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="leafCInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">Leaf_%C</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="leaf_perC" name="leaf_perC" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->leaf_perC . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="leafCNInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">Leaf_CN</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="leaf_CN" name="leaf_CN" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->leaf_CN . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="xylemWater18InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">Xylem Water 18O</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="xylemWater_18O" name="xylemWater_18O" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->xylemWater_18O . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="wiInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">WI</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="wi" name="wi" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->wi . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="priInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">PRI</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="pri" name="pri" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->pri . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="chlInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">CHL</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="chl" name="chl" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->chl . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="chl_ndiInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">CHL_NDI</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="chl_ndi" name="chl_ndi" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->chl_ndi . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="ndviInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">NDVI</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="ndvi" name="ndvi" value=<?= (isset($ecoFisio) ? '"' . $ecoFisio[0]->ndvi . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<?
		  						if (isset($ecoFisio)) {
		  							echo '<div class="form-group">
					  						<label class="col-lg-4 control-label">Creation Date</label>
					  						<div class="col-lg-4">
					  							<p class="form-control-static">' . $ecoFisio[0]->creation_date . '</p>
					  					 	</div>
					  					</div>';
		  						}
		  					?>
		  					


		  					<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
		  						<div class="text-center">
		  							<button onclick="location.href='../lists/ecofisio-list.php?individualCode=<?=$individualCode?>'" type="button" class="btn btn-xs">Cancel</button>
		  							<button class="btn btn-xs btn-primary" type="submit"><?=(isset($ecoFisio) ? "Change" : "Submit")?></button>
		  						</div>
		  					</div>
	  					</form>
	  				</div>

	            	<div class="col-xs-4 col-lg-4">
				        <div class="panel panel-default">
					        <div class="panel-body">
					        	<p><span class="label label-default">Info</span></p>
					        	<p>This form provides eco-physiology sample update, for an individual, in one campaign.</p>
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
    		var samplingDate = $('#samplingDate').val();
    		var hasErrors = false;

			if(samplingDate == ""){
    			hasErrors = true;
				$('#samplingDateInputGroup').addClass('has-error');
			} else {
    			$('#samplingDateInputGroup').removeClass('has-error');
    		}

    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens!</strong>Atenção. Faltam parâmetros à amostragem!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

	</body>
</html>