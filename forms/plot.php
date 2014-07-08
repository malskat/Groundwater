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
  		include "../data/site_data.php"; 

		$siteData = new Site();
		$sites = $siteData->getSites();


		if(isset ($_GET["plot_id"])){
  			include "../data/plot_data.php"; 

  			$plotData = new Plot();
			$plot = $plotData->getPlotBy("plot_id = " . $_GET["plot_id"], -1);
  		}

  		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  		if (false === strpos($backUrl, 'plot-list')) {
			$backUrl = '../lists/plot-list.php';
  		} 
	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	       		<h1>Plot</h1>
	      	</div>
	     </div> 
	</div>

     <div class="container">	
    	<div class="row">
    		<div class="col-xs-12 col-lg-12">
		        <div class="panel panel-primary">
		        	<div class="panel-heading">
					   <h3 class="panel-title"><?=((isset($plot) && count($plot) > 0) ? "Edit Plot" : "Insert Plot")?></h3>
					</div>
			        <div class="panel-body">
			        	<div class="col-xs-8 col-lg-8">
				        	<form class="form-horizontal" role="form" name="form_plot_data" action="../services/plotSubmissionData.php" onsubmit="return validateForm();" method="post">

								<input type="hidden" value="form" name="submissionType" >

								<?= (isset($plot) && is_array($plot) && count($plot)  ?'<input type="hidden" value="' . $plot[0]->plot_id . '" name="plot_id" >' : '')?>

								<div id="codeInputGroup" class="form-group">
									<label for="inputCode" class="col-lg-3 control-label">Code*</label>
									<div class="col-lg-4">
										<input type="text" class="form-control" id="code" name="code" placeholder="Plot code" value=<?= (isset($plot) ? '"' . $plot[0]->code . '"' : "") ?>>
								 	</div>
								</div>
								
								<!-- SITE -->
								<div id="siteInputGroup" class="form-group">
									<label for="inputSite" class="col-lg-3 control-label">Site*</label>
									<div class="col-lg-4">
										<select id="site_id" name="site_id" class="form-control input-sm">
											<?
												if (!isset($plot[0]->site_id)){
													echo '<option value="none">Choose one</option>';
												}

											  	foreach($sites as $site){
											  		if(isset($site->site_id)) {
											  			echo '<option ' . ($plot[0]->site_id == $site->site_id ? 'selected' : '') . ' value="' . $site->site_id . '">' . $site->title . '</option>';
											  		}
											  	}
											?>	
	              						</select>
	              					</div>
								</div>

								<!-- TIPO DE PLOT -->
								<div class="form-group">
									<label for="inputPlotType" class="col-lg-3 control-label">Plot type</label>
									<div class="col-lg-4">
										<select id="plotType" name="plotType" class="form-control input-sm">

											<?
											if (!isset($plot[0]->plotType)){
												echo '<option value="none" selected>Choose one</option>';
											}
											?>

											<option <? (isset($plot[0]->plotType) && $plot[0]->plotType == 'ch' ? 'selected' : '') ?>  value="ch">Charca</option>
											<option <? (isset($plot[0]->plotType) && $plot[0]->plotType == 'du' ? 'selected' : '') ?>  value="du">Pond</option>
	              						</select>									    
									</div>
								</div>

								<div id="coordinateXInputGroup" class="form-group">
									<label for="inputCoordenateX" class="col-lg-3 control-label">Coordinate X*</label>
									<div class="col-lg-4">
										<input type="text" class="form-control" id="coordinateX" name="coordinateX" placeholder="" value=<?= (isset($plot) ? '"' . $plot[0]->coordinateX . '"' : "") ?>>
								 	</div>
								</div>
								<div id="coordinateYInputGroup"  class="form-group">
									<label for="inputCoordinateY" class="col-lg-3 control-label">Coordinate Y*</label>
									<div class="col-lg-4">
										<input type="text" class="form-control" id="coordinateY" name="coordinateY" placeholder="" value=<?= (isset($plot) ? '"' . $plot[0]->coordinateY . '"' : "") ?>>
								 	</div>
								</div>



								<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
									<div class="text-center">
										<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
										<button class="btn btn-xs btn-primary" type="submit"><?=(isset($plot) ? "Change" : "Submit")?></button>
									</div>
								</div>

							</form>
						</div>

						<div class="col-xs-4 col-lg-4">
				        	<div class="panel panel-default">
						        <div class="panel-body">
						        	<p><span class="label label-default">Info</span></p>
						        	<p>To insert and update Site Plots.</p>
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
    		var site = $('#site_id').val();
    		var coordinateX = $('#coordinateX').val();
    		var coordinateY = $('#coordinateY').val();
    		var hasErrors = false;

    		if(code == "" ) {
    			hasErrors = true;
    			$('#codeInputGroup').addClass('has-error');
    		} else {
    			$('#codeInputGroup').removeClass('has-error');
    		}

			if(site == "none"){
    			hasErrors = true;
				$('#siteInputGroup').addClass('has-error');
			} else {
    			$('#siteInputGroup').removeClass('has-error');
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
		        $('#alert-text').html("<strong>Shit happens!</strong>Atenção. Faltam parâmetros ao Plot!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>