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
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">


  </head>

  <body>

  	<? 
  		include "../data/site_data.php"; 

		$plotIdentification = "";
		$plot_id = 0;

  		$plotAttribute = array();

		if( isset($_GET["id"]) ){
  			include "../data/plotattribute_data.php"; 

  			$plotAttributeData = new PlotAttribute();
			$plotAttribute = $plotAttributeData->getPlotAttributeBy(" plot_attribute_id = " . $_GET["id"], -1);

			$plot_id = $plotAttribute[0]->plot_id;
			$plotIdentification = "for " . $plotAttribute[0]->siteTitle . " - " . $plotAttribute[0]->plotCode;
			$backUrl = '../lists/plotattribute-list.php?plot=' . $plotAttribute[0]->plot_id;

  		} else if (isset($_GET["plot"])) {

  			//campanhas
  			include "../data/campaign_data.php"; 
  			$campaignData = new Campaign();
    		$campaigns = $campaignData->getCampaigns(-1);
			
			//info do plot
			include "../data/plot_data.php"; 

  			$plotData = new Plot();
			$plot = $plotData->getPlotBy("plot_id = " . $_GET["plot"], -1);

			$plot_id = $plot[0]->plot_id;
			$plotIdentification = "for " . $plot[0]->title . " - " . $plot[0]->code;
			$backUrl = '../lists/plotattribute-list.php?plot=' . $plot[0]->plot_id;
  		}



	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	       		<h2>Plot Water Info
					<small><?=$plotIdentification?></small>
				</h2>
	      	</div>
	     </div> 
	</div>

     <div class="container">	
    	<div class="row">
    		<div class="col-xs-12 col-lg-12">
		        <div class="panel panel-primary">
		        	<div class="panel-heading">
					   <h3 class="panel-title"><?=( count($plotAttribute) > 0 ? "Edit Plot Sample" : "Insert Plot Sample")?></h3>
					</div>
			        <div class="panel-body">
			        	<div class="col-xs-8 col-lg-8">
				        	<form class="form-horizontal" role="form" name="form_plot_data" action="../services/plotattributeSubmissionData.php" onsubmit="return validateForm();" method="post">

								<input type="hidden" value="form" name="submissionType">
								<input type="hidden" value="<?=$plot_id?>" name="plot_id" >

								<?= (count($plotAttribute) > 0  ?'<input type="hidden" value="' . $plotAttribute[0]->plot_attribute_id . '" name="plot_attribute_id" >' : '')?>

								<div class="form-group">
			  						<label class="col-lg-3 control-label">Plot</label>
			  						<div class="col-lg-4">
			  							<p class="form-control-static"><?=$plotIdentification?></p>
			  					 	</div>
			  					</div>


			  					<? 
				  					if (count($plotAttribute) > 0 ) {
				  						echo '<input type="hidden" value="' . $plotAttribute[0]->sampling_campaign_id . '" name="sampling_campaign_id" >';
				  						echo '<div class="form-group">
						  						<label class="col-lg-3 control-label">Campaign</label>
						  						<div class="col-lg-4">
						  							<p class="form-control-static">'. $plotAttribute[0]->campaignDesignation . '</p>
						  					 	</div>
						  					</div>'; 
					  				} else {
					  					echo '<div id="campaignsInputGroup" class="form-group">
												<label for="inputCampaigns" class="col-lg-3 control-label">Campaign*</label>
												<div class="col-lg-5">
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


								<div id="measureDateInputGroup" class="form-group">
									<label for="inputMeasureDate" class="col-lg-3 control-label">Measure Date*</label>
									<div class="col-lg-5">
										<div class="bfh-datepicker">
										  <div data-toggle="bfh-datepicker">
										    <span class="add-on"><i class="icon-calendar"></i></span>
										    <input type="text" id="measureDate" name="measureDate" class="input-medium" readonly value= <?= (count($plotAttribute) > 0 ? '"' . $plotAttribute[0]->measureDate . '"' : "") ?>>
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

								<div id="coordinateXInputGroup" class="form-group">
									<label for="inputCoordenateX" class="col-lg-3 control-label">Ground Water 18o</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="groundWater_18o" name="groundWater_18o" placeholder="" value=<?= (count($plotAttribute) > 0 ? '"' . $plotAttribute[0]->groundWater_18o . '"' : "") ?>>
								 	</div>
								</div>

								<div id="coordinateYInputGroup"  class="form-group">
									<label for="inputCoordinateY" class="col-lg-3 control-label">Pond Water 18o</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="pondWater_18o" name="pondWater_18o" placeholder="" value=<?= (count($plotAttribute) > 0 ? '"' . $plotAttribute[0]->pondWater_18o . '"' : "") ?>>
								 	</div>
								</div>
								
								<div id="coordinateYInputGroup"  class="form-group">
									<label for="inputCoordinateY" class="col-lg-3 control-label">Ground Water Level</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="gw_level" name="gw_level" placeholder="" value=<?= (count($plotAttribute) > 0 ? '"' . $plotAttribute[0]->gw_level . '"' : "") ?>>
								 	</div>
								</div>



								<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
									<div class="text-center">
										<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
										<button class="btn btn-xs btn-primary" type="submit"><?=(count($plotAttribute) > 0 ? "Change" : "Submit")?></button>
									</div>
								</div>

							</form>
						</div>

						<div class="col-xs-4 col-lg-4">
				        	<div class="panel panel-default">
						        <div class="panel-body">
						        	<p><span class="label label-default">Info</span></p>
						        	<p>To manage particular Plot Samples information.</p>
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
    		var measureDate = $('#measureDate').val();
    		
    		if(measureDate == ""){
    			hasErrors = true;
				$('#measureDateInputGroup').addClass('has-error');
			} else {
    			$('#measureDateInputGroup').removeClass('has-error');
    		}

    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Attention:</strong> Missing parameters on this Plot Sample!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>