\<?php
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

  	<?php
  		//dados necessarios para o formulario
  		include "../data/site_data.php"; 
  		include "../data/season_data.php"; 

  		$siteData = new Site();
		$sites = $siteData->getSites(-1);

		$seasonData = new Season();
		$seasons = $seasonData->getSeasons(-1);

  		if(isset ($_GET["campaign_id"])){
  			include "../data/campaign_data.php"; 

  			$campaignData = new Campaign();
			$campaign = $campaignData->getCampaignBy("sampling_campaign_id = " . $_GET["campaign_id"], -1);
  		}

  		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  		if (false === strpos($backUrl, 'campaign-list')) {
			$backUrl = '../lists/campaign-list.php';
  		} 
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	       		<h1>Campaign</h1>
	      	</div>
	    </div>
	</div>

	<!-- formulario -->
	<div class="container">
      <div class="row">
		<div class="col-xs-12 col-lg-12">
	        <div class="panel panel-primary">
	        	<div class="panel-heading">
				   <h3 class="panel-title"><?=((isset($campaign) && is_array($campaign) && count($campaign) > 0) ? "Edit Campaign" : "Insert Campaign")?></h3>
				</div>
		        <div class="panel-body">
		        	<div class="col-xs-8 col-lg-8">
		        		<form class="form-horizontal" role="form" name="form_campaign_data" action="../services/campaignSubmissionData.php" onsubmit="return validateForm();" method="post">

							<?= (isset($campaign) ?'<input type="hidden" value="' . $campaign[0]->sampling_campaign_id . '" name="sampling_campaign_id" >' : '')?>

							<div id="designationInputGroup" class="form-group">
								<label for="designation" class="col-lg-2 control-label">Title*</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" id="designation" name="designation" placeholder="Campaign Title" value=<?= (isset($campaign) ? '"' . $campaign[0]->designation . '"' : "") ?>>
							 	</div>
							</div>

							<!-- season -->
							<div id="seasonInputGroup" class="form-group">
								<label for="inputGenus" class="col-lg-2 control-label">Season*</label>
								<div class="col-lg-6">
									<select id="season_id" name="season_id" class="form-control input-sm">
										<?php
											if (!isset($campaign[0]->site_id)){
												echo '<option value="none">Choose one</option>';
											}

										  	foreach($seasons as $season){
										  		if(isset($season->season_id)) {
										  			echo '<option ' . ($campaign[0]->season_id == $season->season_id ? 'selected' : '') . ' value="' . $season->season_id . '">' . $season->code . '</option>';
										  		}
										  	}
										?>	
              						</select>								
								</div>
							</div>


							<!-- site -->
							<div id="siteInputGroup" class="form-group">
								<label for="inputSite" class="col-lg-2 control-label">Site*</label>
								<div class="col-lg-6">
									<select id="site_id" name="site_id" class="form-control input-sm">
										<?
											if (!isset($campaign[0]->site_id)){
												echo '<option value="none">Choose one</option>';
											}

										  	foreach($sites as $site){
										  		if(isset($site->site_id)) {
										  			echo '<option ' . ($campaign[0]->site_id == $site->site_id ? 'selected' : '') . ' value="' . $site->site_id . '">' . $site->title . '</option>';
										  		}
										  	}
										?>	
              						</select>
              					</div>
							</div>

							<div id="startDateInputGroup" class="form-group">
								<label for="inputCode" class="col-lg-2 control-label">Begin*</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="startDate" name="startDate" class="input-medium" readonly value= <?= (isset($campaign) ? '"' . $campaign[0]->startDate . '"' : "") ?>>
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

							<div id="endDateInputGroup" class="form-group">
								<label for="inputCode" class="col-lg-2 control-label">End*</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div class="input-prepend bfh-datepicker-toggle" data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="endDate" name="endDate" class="input-medium" readonly value=<?= (isset($campaign) ? '"' . $campaign[0]->endDate . '"' : "") ?>>
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

							<div class="form-group">
								<label for="methodology" class="col-lg-2 control-label">Methodology</label>
								<div class="col-lg-6">
									<textarea name="methodology" class="form-control" rows="4"><?= (isset($campaign) ? $campaign[0]->methodology : "") ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="description" class="col-lg-2 control-label">Description</label>
								<div class="col-lg-6">
									<textarea name="description" class="form-control" rows="4"><?= (isset($campaign) ? $campaign[0]->description : "") ?></textarea>
								</div>
							</div>


							<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
								<div class="text-center">
									<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
									<button class="btn btn-xs btn-primary" type="submit"><?=(isset($campaign) ? "Change" : "Submit")?></button>
								</div>
							</div>

						</form>
		        	</div>

		        	<div class="col-xs-4 col-lg-4">
				        <div class="panel panel-default">
					        <div class="panel-body">
					        	<p><span class="label label-default">Info</span></p>
					        	<p>Insert and update Sampling Campaigns info through this form.</p>
					        	<p>Sampling Campaigns are important to identify different Individual samples.</p>
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
    		var designation = $('#designation').val();
    		var startDate = $('#startDate').val();
    		var endDate = $('#endDate').val();
    		var site = $('#site_id').val();
    		var season = $('#season_id').val();
    		var hasErrors = false;


    		if(designation == "" ) {
    			hasErrors = true;
    			$('#designationInputGroup').addClass('has-error');
    		} else {
    			$('#designationInputGroup').removeClass('has-error');
    		}

			if(startDate == ""){
    			hasErrors = true;
				$('#startDateInputGroup').addClass('has-error');
			} else {
    			$('#startDateInputGroup').removeClass('has-error');
    		}

    		if(endDate == "" ) {
    			hasErrors = true;
    			$('#endDateInputGroup').addClass('has-error');
    		} else {
    			$('#endDateInputGroup').removeClass('has-error');
    		}

    		if(site == "none" ) {
    			hasErrors = true;
    			$('#siteInputGroup').addClass('has-error');
    		} else {
    			$('#siteInputGroup').removeClass('has-error');
    		}

    		if(season == "none" ) {
    			hasErrors = true;
    			$('#seasonInputGroup').addClass('has-error');
    		} else {
    			$('#seasonInputGroup').removeClass('has-error');
    		}


    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit could happen!</strong>Attention. Missing parameters!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>