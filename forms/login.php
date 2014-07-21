<?php
	include "../checkBiologyst.php";
	require_once '../config/constants.php';
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
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/alerts.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <div class="container">

  		<div class="row spacer">
			<div class="col-xs-6 col-lg-6 col-lg-offset-3">
		        <div class="panel panel-default">
		            <div class="panel-body">
		            	<div class="col-xs-10 col-lg-10 col-lg-offset-1 smallspacer">
		            		<p class="lead text-center"><strong>Welcome to GWTropiMed</strong></p>
		            		<h6 class="text-center">Please login to manage entities like sites or individuals.</h6>
		            	</div>
		            	<div id="loginForm" name="loginForm">
							<form role="form" onsubmit="return validateLogin();" action="../services/make_entrance.php" method="post">			
								<input id="destination" name="destination" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>">
								
								<div id="emailInputGroup" class="form-group col-xs-10 col-lg-10 col-lg-offset-1 smallspacer">
									<input id="email" name="email" type="text" class="form-control" placeholder="email">
								</div> 
								<div id="passInputGroup" class="form-group col-xs-10 col-lg-10 col-lg-offset-1">
									<input id="password" name="password" type="password" class="form-control" placeholder="password">
								</div>
								<div class="text-center col-xs-10 col-lg-10 col-lg-offset-1">
									<button id="loginTooltip" type="submit" class="btn btn-success btn-lg btn-block" data-toggle="tooltip" data-placement="left" title="Por implementar!">Login <span class="glyphicon glyphicon-play-circle"></span></button>
								</div>
							</form>
						</div>
						<div class="col-xs-10 col-lg-10 col-lg-offset-1 smallspacer">
							<p class="text-center"><small><a href="<?=PROJECT_URL . 'forms/recover-password.php'?>">Forgot password?</a></small></p>
						</div>
		            </div>
		        </div>
	  		</div>
  		</div>

  	</div>

  	<?php include "../footer.php";?>

	<script>
	  		//para validar o login
		function validateLogin() {

			var email = $('#email').val();
	    	var password = $('#password').val();
	    	var hasErrors = false;

			if (email == '') {
				$('#emailInputGroup').addClass('has-error');
				hasErrors = true;
			}else {
				$('#emailInputGroup').removeClass('has-error');
			}

			if (password == '') {
				$('#passInputGroup').addClass('has-error');
				hasErrors = true;
			}else {
				$('#passInputGroup').removeClass('has-error');
			}
			
			if (hasErrors){
				$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens! </strong>Email and Password are mandatory!");
				return false;
			} else {
				$("#loginForm").hide();
				$("#loggedInfo").show();
				return true;
			}
		}
	</script>

  </body>
</html>