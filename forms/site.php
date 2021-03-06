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
  		if(isset ($_GET["site_id"])){
  			include "../data/site_data.php"; 
  			
  			$siteData = new Site();
			$site = $siteData->getSiteBy("site_id = " . $_GET["site_id"], -1);
  		}

  		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  		if (false === strpos($backUrl, 'site-list')) {
			$backUrl = '../lists/site-list.php';
  		} 
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
          <h1>Site</h1>
        </div>
      </div>
    </div>

	<div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?= (isset($site) ? "Edit Site" : "Insert Site") ?></h3>
            </div>
            <div class="panel-body">
				<div class="col-xs-8 col-lg-8">
					<form class="form-horizontal" role="form" name="form_site_data" action="../services/siteSubmissionData.php" onsubmit="return validateForm();" method="post">

	  					<?= (isset($site) ?'<input type="hidden" value="' . $site[0]->site_id . '" name="site_id" >' : '')?>

	  					<div id="codeInputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">Code*</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="code" name="code" placeholder="Site Code" value=<?= (isset($site) ? '"' . $site[0]->code . '"' : "")?> >
	  					 	</div>
	  					</div>
	  					<div id="titleInputGroup" class="form-group">
	  						<label for="inputGenus" class="col-lg-3 control-label">Title*</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="title" name="title" value=<?= (isset($site) ? '"' . $site[0]->title . '"' : "")?> >
	  					 	</div>
	  					</div>
	  					<div id="countryInputGroup" class="form-group">
	  						<label for="inputGenus" class="col-lg-3 control-label">Country*</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="country" name="country" value=<?= (isset($site) ? '"' . $site[0]->country . '"' : "")?> >
	  					 	</div>
	  					</div>
	  					<div class="form-group">
	  						<label for="inputGenus" class="col-lg-3 control-label">Coordinate X</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="coordinateX" name="coordinateX" value=<?= (isset($site) ? '"' . $site[0]->coordinateX . '"' : "")?>>
	  					 	</div>
	  					</div>
	  					<div class="form-group">
	  						<label for="inputGenus" class="col-lg-3 control-label">Coordinate Y</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="coordinateY" name="coordinateY" value=<?= (isset($site) ? '"' . $site[0]->coordinateY . '"' : "")?>>
	  					 	</div>
	  					</div>

	  					<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
	  						<div class="text-center">
	  							<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
	  							<button class="btn btn-xs btn-primary" type="submit"><?=(isset($site) ? "Change" : "Submit")?></button>
	  						</div>
	  					</div>
	  				</form>
		   		</div>

            	<div class="col-xs-4 col-lg-4">
			        <div class="panel panel-default">
				        <div class="panel-body">
				        	<p><span class="label label-default">Info</span></p>
				        	<p>Insert and update sampling Sites.</p>
					    	<p><strong>All fiedls with * are mandatory.</strong></p>
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
    		var country = $('#country').val();
    		var title = $('#title').val();
    		var hasErrors = false;


    		if(code == "" ) {
    			hasErrors = true;
    			$('#codeInputGroup').addClass('has-error');
    		} else {
    			$('#codeInputGroup').removeClass('has-error');
    		}


			if(country == ""){
    			hasErrors = true;
				$('#countryInputGroup').addClass('has-error');
			} else {
    			$('#countryInputGroup').removeClass('has-error');
    		}

    		if(title == "" ) {
    			hasErrors = true;
    			$('#titleInputGroup').addClass('has-error');
    		} else {
    			$('#titleInputGroup').removeClass('has-error');
    		}


    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Attention:</strong> Missing parameters to this Site!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>