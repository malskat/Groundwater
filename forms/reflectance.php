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

    <title>Projecto Ground Water</title>

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
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

  </head>

	<body>


	  	<?
	  		$individualCode = '';
	  		$campaigns = array();
	  		if(isset($_GET["id"])){
	  			require_once PROJECT_PATH . "data/reflectance_data.php"; 
	  		
	  			$reflectanceData = new Reflectance();
				$reflectance = $reflectanceData->getReflectanceBy(" ir.individual_reflectance_id = '" . $_GET["id"] . "'", $orderBy = '', $page = -1);
				$individualCode = $reflectance[0]->individualCode;
	  		} else if ($_GET["individualCode"]) {
	  			require_once "../data/campaign_data.php"; 

				$individualCode = $_GET['individualCode'];
	  			$campaignData = new Campaign();
	    		$campaigns = $campaignData->getCampaigns(-1);
	  		}
	  	?>
    
	  	<!-- incluir menu principal -->
	    <?php include "../menu.php"; ?>

	    <div class="container">
	      <div class="row">
	      	<div class="page-header">
         		<h1>Unispec - Reflectance</h1>
				<h5>Individual - <?=$individualCode?></h5>
	        </div>
	      </div>
	    </div>

	    <div class="container">
	      <div class="row">
	        <div class="col-xs-12 col-lg-12">
	          <div class="panel panel-primary">
	            <div class="panel-heading">
	              <h3 class="panel-title"><?= (isset($reflectance) ? "Sample Edition" : "Sample Insert") ?></h3>
	            </div>
	            <div class="panel-body">
					<div class="col-xs-8 col-lg-8">
						<form class="form-horizontal" role="form" name="form_reflectance_data" action="../services/reflectanceSubmissionData.php" onsubmit="return validateForm();" method="post">

							<input type="hidden" value="<?=$individualCode?>" name="individualCode">
							<input type="hidden" value="form" name="submissionType">

							<div class="form-group">
		  						<label class="col-lg-4 control-label">Individual Code</label>
		  						<div class="col-lg-4">
		  							<p class="form-control-static"><?=$individualCode?></p>
		  					 	</div>
		  					</div>

		  					<? 
		  					if (isset($reflectance)) {
		  						echo '<input type="hidden" value="' . $reflectance[0]->sampling_campaign_id . '" name="sampling_campaign_id" >';
		  						echo '<input type="hidden" value="' . $reflectance[0]->individual_reflectance_id . '" name="individual_reflectance_id" >';
		  						echo '<div class="form-group">
				  						<label class="col-lg-4 control-label">Campaign</label>
				  						<div class="col-lg-4">
				  							<p class="form-control-static">'. $reflectance[0]->campaignDesignation . '</p>
				  					 	</div>
				  					</div>';

				  				echo '<div class="form-group">
				  						<label class="col-lg-4 control-label">File</label>
				  						<div class="col-lg-4">
				  							<p class="form-control-static">'. $reflectance[0]->file . '</p>
				  					 	</div>
				  					</div>';  
			  				} else {
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

							<div id="c_529InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">529.6*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_529" name="c_529" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_529 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_529wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">529.6w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_529w" name="c_529w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_529w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_569InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">569.8*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_569" name="c_569" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_569 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_569wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">569.8w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_569w" name="c_569w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_569w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_680InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">680.0*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_680" name="c_680" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_680 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_680wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">680.0w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_680w" name="c_680w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_680w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_700InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">700.0*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_700" name="c_700" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_700 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_700wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">700.0w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_700w" name="c_700w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_700w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_706InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">706.6*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_706" name="c_706" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_706 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_706wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">706.6w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_706w" name="c_706w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_706w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_749InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">749.8*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_749" name="c_749" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_749 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_749wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">749.8w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_749w" name="c_749w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_749w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_898InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">898.8*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_898" name="c_898" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_898 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_898wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">898.8w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_898w" name="c_898w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_898w . '"' : "")?> >
		  					 	</div>
		  					</div>

							<div id="c_971InputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">971.3*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_971" name="c_971" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_971 . '"' : "")?> >
		  					 	</div>
		  					</div>

		  					<div id="c_971wInputGroup" class="form-group">
		  						<label for="inputCode" class="col-lg-4 control-label">971.3w*</label>
		  						<div class="col-lg-4">
		  							<input type="text" class="form-control" id="c_971w" name="c_971w" value=<?= (isset($reflectance) ? '"' . $reflectance[0]->c_971w . '"' : "")?> >
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
		  							<button onclick="location.href='../lists/reflectance-list.php?individualCode=<?=$individualCode?>'" type="button" class="btn btn-xs">Cancel</button>
		  							<button class="btn btn-xs btn-primary" type="submit"><?=(isset($ecoFisio) ? "Change" : "Submit")?></button>
		  						</div>
		  					</div>
	  					</form>
	  				</div>

	            	<div class="col-xs-4 col-lg-4">
				        <div class="panel panel-default">
					        <div class="panel-body">
					        	<p><span class="label label-default">Info</span></p>
					        	<p>This form provides unispec reflectance update, for an individual, in one campaign.</p>
						    	<p><strong>All fields with * are mandatory.</strong></p>
					        </div>
				        </div>
			   		</div>
		   		</div>
          	</div>
        </div>
      </div>
  	</div>

  	 <script>
    	function validateForm(){
    		var c_529 = $('#c_529').val();
    		var c_529w = $('#c_529w').val();
    		
    		var c_569 = $('#c_569').val();
    		var c_569w = $('#c_569w').val();
    		var c_680 = $('#c_680').val();
    		var c_680w = $('#c_680w').val();

    		var c_700 = $('#c_700').val();
    		var c_700w = $('#c_700w').val();
    		var c_706 = $('#c_706').val();
    		var c_706w = $('#c_706w').val();
    		var c_749 = $('#c_749').val();
    		var c_749w = $('#c_749w').val();

    		var c_898 = $('#c_898').val();
    		var c_898w = $('#c_898w').val();

    		var c_971 = $('#c_971').val();
    		var c_971w = $('#c_971w').val();


    		var hasErrors = false;

			if(c_529 == ""){
    			hasErrors = true;
				$('#c_529InputGroup').addClass('has-error');
			} else {
    			$('#c_529InputGroup').removeClass('has-error');
    		}

    		if(c_529w == ""){
    			hasErrors = true;
				$('#c_529wInputGroup').addClass('has-error');
			} else {
    			$('#c_529wInputGroup').removeClass('has-error');
    		}

    		if(c_569 == ""){
    			hasErrors = true;
				$('#c_569InputGroup').addClass('has-error');
			} else {
    			$('#c_569InputGroup').removeClass('has-error');
    		}

    		if(c_569w == ""){
    			hasErrors = true;
				$('#c_569wInputGroup').addClass('has-error');
			} else {
    			$('#c_569wInputGroup').removeClass('has-error');
    		}

    		if(c_680 == ""){
    			hasErrors = true;
				$('#c_680InputGroup').addClass('has-error');
			} else {
    			$('#c_680InputGroup').removeClass('has-error');
    		}

    		if(c_680w == ""){
    			hasErrors = true;
				$('#c_680wInputGroup').addClass('has-error');
			} else {
    			$('#c_680wInputGroup').removeClass('has-error');
    		}

    		if(c_700 == ""){
    			hasErrors = true;
				$('#c_700InputGroup').addClass('has-error');
			} else {
    			$('#c_700InputGroup').removeClass('has-error');
    		}

    		if(c_700w == ""){
    			hasErrors = true;
				$('#c_700wInputGroup').addClass('has-error');
			} else {
    			$('#c_700wInputGroup').removeClass('has-error');
    		}

    		if(c_706 == ""){
    			hasErrors = true;
				$('#c_706InputGroup').addClass('has-error');
			} else {
    			$('#c_706InputGroup').removeClass('has-error');
    		}

    		if(c_706w == ""){
    			hasErrors = true;
				$('#c_706wInputGroup').addClass('has-error');
			} else {
    			$('#c_706wInputGroup').removeClass('has-error');
    		}

    		if(c_749 == ""){
    			hasErrors = true;
				$('#c_749InputGroup').addClass('has-error');
			} else {
    			$('#c_749InputGroup').removeClass('has-error');
    		}

    		if(c_749w == ""){
    			hasErrors = true;
				$('#c_749wInputGroup').addClass('has-error');
			} else {
    			$('#c_749wInputGroup').removeClass('has-error');
    		}

    		if(c_898 == ""){
    			hasErrors = true;
				$('#c_898InputGroup').addClass('has-error');
			} else {
    			$('#c_898InputGroup').removeClass('has-error');
    		}

    		if(c_898w == ""){
    			hasErrors = true;
				$('#c_898wInputGroup').addClass('has-error');
			} else {
    			$('#c_898wInputGroup').removeClass('has-error');
    		}

    		if(c_971 == ""){
    			hasErrors = true;
				$('#c_971InputGroup').addClass('has-error');
			} else {
    			$('#c_971InputGroup').removeClass('has-error');
    		}

    		if(c_971w == ""){
    			hasErrors = true;
				$('#c_971wInputGroup').addClass('has-error');
			} else {
    			$('#c_971wInputGroup').removeClass('has-error');
    		}

    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens!</strong>Atention. Missing arguments to Unispec Reflectance!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

	</body>
</html>