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
    <script src="../js/bootstrap-formhelpers-datepicker.js"></script>
    <script src="../js/bootstrap-formhelpers-datepicker.pt_PT.js"></script>
    
    <link href="../css/bootstrap-formhelpers.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">	
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">


  </head>

  <body>

  	<? 

  		$subtitle = "";
  		$backUrl = "";
  		$plotSoil = array();
  		$plot_id = 0;
		$plotIdentification = "";

  		if(isset($_GET["plot"])) {

  			$plot_id = $_GET["plot"];

	  		//campanhas
  			include "../data/campaign_data.php"; 
  			$campaignData = new Campaign();
    		$campaigns = $campaignData->getCampaigns(-1);
			
			//info do plot
			include "../data/plot_data.php"; 

  			$plotData = new Plot();
			$plot = $plotData->getPlotBy("plot_id = " . $_GET["plot"], -1);

			$plot_id = $plot[0]->plot_id;
			$plotIdentification = 'for ' . $plot[0]->title . " - " . $plot[0]->code;
			$backUrl = '../lists/plotsoil-list.php?plot=' . $plot[0]->plot_id;

  		} else if(isset ($_GET["id"])) {

  			include "../data/plotsoil_data.php"; 

  			$plotSoilData = new PlotSoil();
			$plotSoil = $plotSoilData->getPlotSoilBy("plot_soil_id = " . $_GET["id"], $page = -1 , $withTotals = -1);
			
			$plotIdentification = $plotSoil[0]->siteTitle . " - " . $plotSoil[0]->plotCode;
			$plot_id = $plotSoil[0]->plot_id;
			$subtitle = 'for ' . $plotSoil[0]->siteTitle . ' ' .  $plotSoil[0]->plotCode . " in " . $plotSoil[0]->campaignDesignation;
			$backUrl = '../lists/plotsoil-list.php?plot=' . $plotSoil[0]->plot_id;
  		}

  		//pode vir tanto da lista de samples de um plot como da listagem de soil samples de uma amostragem especifico

	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	       		<h2>
	       			Plot Soil Sample
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
					   <h3 class="panel-title"><?=((count($plotSoil) > 0) ? "Edit Plot Soil Sample" : "Insert Plot Soil Sample")?></h3>
					</div>
			        <div class="panel-body">
			        	<div class="col-xs-8 col-lg-8">
				        	<form class="form-horizontal" role="form" name="form_plot_data" action="../services/plotsoilSubmissionData.php" onsubmit="return validateForm();" method="post">

								<input type="hidden" value="form" name="submissionType" >

								<?= (count($plotSoil) > 0  ?'<input type="hidden" value="' . $plotSoil[0]->plot_soil_id . '" name="plot_soil_id" >' : '')?>
								<input type="hidden" value="<?=$plot_id?>" name="plot_id" >

								<div class="form-group">
			  						<label class="col-lg-3 control-label">Plot</label>
			  						<div class="col-lg-4">
			  							<p class="form-control-static"><?=$plotIdentification?></p>
			  					 	</div>
			  					</div>

			  					<? 
				  					if (count($plotSoil) > 0) {
				  						echo '<input type="hidden" value="' . $plotSoil[0]->sampling_campaign_id . '" name="sampling_campaign_id" >';
				  						echo '<div class="form-group">
						  						<label class="col-lg-3 control-label">Campaign</label>
						  						<div class="col-lg-4">
						  							<p class="form-control-static">'. $plotSoil[0]->campaignDesignation . '</p>
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
										    <input type="text" id="measureDate" name="measureDate" class="input-medium" readonly value= <?= (count($plotSoil) > 0 ? '"' . $plotSoil[0]->measureDate . '"' : "") ?>>
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


								<div id="codeInputGroup" class="form-group">
									<label for="inputCode" class="col-lg-3 control-label">Soil Code*</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="soilCode" name="soilCode" placeholder="Soil code" value=<?= (count($plotSoil) ? '"' . $plotSoil[0]->soilCode . '"' : "") ?>>
								 	</div>
								</div>

								<div id="18o10InputGroup" class="form-group">
									<label for="inputSoil18o10" class="col-lg-3 control-label">Soil 18o 10cm</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="soil_18o_10" name="soil_18o_10" placeholder="" value=<?= (count($plotSoil) ?  $plotSoil[0]->soil_18o_10 : "") ?>>
								 	</div>
								</div>

								<div id="18o30InputGroup"  class="form-group">
									<label for="inputSoil18o30" class="col-lg-3 control-label">Soil 18o 30cm</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="soil_18o_30" name="soil_18o_30" placeholder="" value=<?= (count($plotSoil) ? $plotSoil[0]->soil_18o_30 : "") ?>>
								 	</div>
								</div>

								<div id="18o50InputGroup"  class="form-group">
									<label for="inputSoil18o50" class="col-lg-3 control-label">Soil 18o 50cm</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="soil_18o_50" name="soil_18o_50" placeholder="" value=<?= (count($plotSoil) ? $plotSoil[0]->soil_18o_50 : "") ?>>
								 	</div>
								</div>

								<div id="soilWaterContentInputGroup"  class="form-group">
									<label for="inputsoilWaterContent" class="col-lg-3 control-label">Soil Water Content</label>
									<div class="col-lg-5">
										<input type="text" class="form-control" id="soilWaterContent" name="soilWaterContent" placeholder="" value=<?= (count($plotSoil) ? $plotSoil[0]->soilWaterContent : "") ?>>
								 	</div>
								</div>

								<?
			  						if(count($plotSoil) > 0) {
			  							echo '<div class="form-group">
						  						<label class="col-lg-3 control-label">Creation Date</label>
						  						<div class="col-lg-4">
						  							<p class="form-control-static">' . $plotSoil[0]->creation_date . '</p>
						  					 	</div>
						  					</div>';
						  				}

				  				?>


								<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
									<div class="text-center">
										<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
										<button class="btn btn-xs btn-primary" type="submit"><?=(count($plotSoil) > 0 ? "Change" : "Submit")?></button>
									</div>
								</div>

							</form>
						</div>

						<div class="col-xs-4 col-lg-4">
				        	<div class="panel panel-default">
						        <div class="panel-body">
						        	<p><span class="label label-default">Info</span></p>
						        	<p>To insert and update Soil samples for specific Plots.</p>
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
    		var soilCode = $('#soilCode').val();
    		var soil_18o_10 = $('#soil_18o_10').val();
    		var measureDate = $('#measureDate').val();
    		var hasErrors = false;
    		
    		if(measureDate == ""){
    			hasErrors = true;
				$('#measureDateInputGroup').addClass('has-error');
			} else {
    			$('#measureDateInputGroup').removeClass('has-error');
    		}


    		if(soilCode == "" ) {
    			hasErrors = true;
    			$('#codeInputGroup').addClass('has-error');
    		} else {
    			$('#codeInputGroup').removeClass('has-error');
    		}


    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Attention:</strong> Missing parameters on this Soil Sample!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>