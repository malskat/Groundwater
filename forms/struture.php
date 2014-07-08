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
  		$struture = array();
  		if(isset ($_GET["individualCode"])){
  			include "../data/struture_data.php"; 
  			
  			$strutureData = new Struture();
			$struture = $strutureData->getObjectsBy("individualCode = '" . $_GET["individualCode"] . "'", -1);
  		}

  		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  		if (false === strpos($backUrl, 'individual-list')) {
			$backUrl = '../lists/individual-list.php';
  		} 
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
        	<h2>
        		Structure
          		<small>Individual - <?=$_GET['individualCode']?></small>
          	</h2>
        </div>
      </div>
    </div>

	<div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading clearfix">
              <h3 class="panel-title pull-left"><?= (!isset($struture) ? "Edit Structure" : "Insert Structure") ?></h3>
				<?
					if (count($struture) > 0) {
						echo '<div class="pull-right">
								<button onclick="beginDelete(\'action=delete&class=struture&id=' . $struture[0]->struture_id . '&redirect=/lists/individual-list.php\'
								                             ,\'Do you want to remove this individual structure?\');"" type="button" class="btn btn-danger btn-xs">Remove</button>
								</div>';
					}
				?>
            </div>
            <div class="panel-body">
				<div class="col-xs-8 col-lg-8">
					<form class="form-horizontal" role="form" name="form_struture_data" action="../services/strutureSubmissionData.php" onsubmit="return validateForm();" method="post">

						<input type="hidden" value="form" name="submissionType">
	  					<?= (count($struture) > 0 ?'<input type="hidden" value="' . $struture[0]->struture_id . '" name="struture_id" >' : '')?>
	  					<input type="hidden" value="<?=$_GET['individualCode']?>" name="individualCode" >

	  					<div id="samplingDateInputGroup" class="form-group">
							<label for="inputSamplingDate" class="col-lg-3 control-label">Sampling Date*</label>
							<div class="col-lg-4">
								<div class="bfh-datepicker">
								  <div data-toggle="bfh-datepicker">
								    <span class="add-on"><i class="icon-calendar"></i></span>
								    <input type="text" id="samplingDate" name="samplingDate" class="input-medium" readonly value= <?= (count($struture) > 0 ? '"' . $struture[0]->samplingDate . '"' : "") ?>>
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

	  					<div id="diameter1InputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">Diameter 1</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="diameter1" name="diameter1" value=<?= (count($struture) > 0 ? '"' . $struture[0]->diameter1 . '"' : "")?> >
	  					 	</div>
	  					</div>

	  					<div id="diameter2InputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">Diameter 2</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="diameter2" name="diameter2" value=<?= (count($struture) > 0 ? '"' . $struture[0]->diameter2 . '"' : "")?> >
	  					 	</div>
	  					</div>

	  					<div id="heightInputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">Height</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="height" name="height" value=<?= (count($struture) > 0 ? '"' . $struture[0]->height . '"' : "")?> >
	  					 	</div>
	  					</div>

	  					<div id="perimeterInputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">Perimeter</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="perimeter" name="perimeter" value=<?= (count($struture) > 0 ? '"' . $struture[0]->perimeter . '"' : "")?> >
	  					 	</div>
	  					</div>

	  					<div id="dapInputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">DAP</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="dap" name="dap" value=<?= (count($struture) > 0 ? '"' . $struture[0]->dap . '"' : "")?> >
	  					 	</div>
	  					</div>

	  					<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
	  						<div class="text-center">
	  							<button onclick="location.href='<?=$backUrl?>'" type="button" class="btn btn-xs">Cancel</button>
	  							<button class="btn btn-xs btn-primary" type="submit"><?=(count($struture) > 0 ? "Change" : "Submit")?></button>
	  						</div>
	  					</div>
	  				</form>
		   		</div>

            	<div class="col-xs-4 col-lg-4">
			        <div class="panel panel-default">
				        <div class="panel-body">
				        	<p><span class="label label-default">Info</span></p>
				        	<p>This forms allows you to manage (insert and edit) individual structures.</p>
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