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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  	<!-- incluir menu principal -->
    <?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
         		<h1>Species</h1>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
      		<div class="col-xs-12 col-lg-12">
	  			<div class="panel panel-primary">
		        	<div class="panel-heading">
					   <h3 class="panel-title">Insert Species by CSV</h3>
					</div>
			        <div class="panel-body">
			        	<div class="col-xs-8 col-lg-8">
				  			<form class="form-horizontal" role="form" name="form_species_csv_data" enctype="multipart/form-data" action="../services/speciesSubmissionData.php" onsubmit="return validateForm();" method="post">
				  				<input type="hidden" value="excel" name="submissionType" >

				  				<div id="fileInputGroup" class="form-group spacer">
				  					<label for="inputGenus" class="col-lg-2 control-label">File*</label>
				  					<div class="col-lg-10">
				  						<input type="file" class="form-control" id="file" name="file" placeholder="">
				  				 	</div>
				  				</div>


				  				<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
									<div class="text-center">
										<button onclick="location.href='../lists/species-list.php'" type="button" class="btn btn-xs">Cancel</button>
										<button class="btn btn-xs btn-primary" type="submit">Submit</button>
									</div>
								</div>

				  			</form>
				  		</div>
				  		<div class="col-xs-4 col-lg-4">
				  			<div class="panel panel-default">
								<div class="panel-body">
									<p><span class="label label-default">Info</span></p>
									<p>This form allows you to insert a lot of Individual Species, by submiting a file.</p>
									<p>Submitted files must have csv extension.</p>
									<p>The submitted files must follow this structure: <strong>genus</strong>, <strong>species</strong>, <strong>type</strong>, <strong>code</strong> and <strong>functionalGroup</strong> (not mandatory).</p>
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
			var file = $('#file').val();
			var hasErrors = false;


			if(file == "" ) {
				hasErrors = true;
				$('#fileInputGroup').addClass('has-error');
			} else {
				$('#fileInputGroup').removeClass('has-error');
			}

			if (hasErrors){
				$('#alert-message').show();
				$('#alert-message').addClass('danger');
				$('#alert-text').html("<strong>Attention:</strong> Missing arguments to submission!");
				return false;
			} else {
				return true;
			}

		}
    </script>

  </body>
</html>