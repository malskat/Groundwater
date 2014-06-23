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
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap alerts -->
    <link href="../css/alerts.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">


  </head>

  <body>

  	<?
  		if(isset ($_GET["user_id"])){
  			include "../data/user_data.php"; 
  			$userData = new User();
			$user = $userData->getUserBy("biologyst_id = " . $_GET["user_id"], -1);
  		}
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
          <h1>Utilizador</h1>
        </div>
      </div>
    </div>

	<div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?= (isset($user) ? "Editar Utilizador" : "Inserir Utilizador") ?></h3>
            </div>
            <div class="panel-body">
				<div class="col-xs-8 col-lg-8">
					<form class="form-horizontal" role="form" name="form_site_data" action="../services/userSubmissionData.php" onsubmit="return validateForm();" method="post">

	  					<?= (isset($user) ?'<input id="user_id" name="user_id" type="hidden" value="' . $user[0]->biologyst_id . '">' : '')?>

	  					<div id="firstInputGroup" class="form-group">
	  						<label for="inputCode" class="col-lg-3 control-label">Primeiro nome*</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Primeiro nome do utilizador" value=<?= (isset($user) ? '"' . $user[0]->first_name . '"' : "")?> >
	  					 	</div>
	  					</div>
	  					<div id="lastInputGroup" class="form-group">
	  						<label for="inputGenus" class="col-lg-3 control-label">Último nome*</label>
	  						<div class="col-lg-4">
	  							<input type="text" class="form-control" id="last_name" name="last_name" value=<?= (isset($user) ? '"' . $user[0]->last_name . '"' : "")?> >
	  					 	</div>
	  					</div>

	  					<?
	  						if (isset($user)) {
	  							echo '<input type="hidden" value="' . $user[0]->email . '" name="emailUser" id="emailUser">';
				     			echo '<div class="form-group">
				  						<label class="col-lg-3 control-label">Email</label>
				  						<div class="col-lg-4">
				  							<p class="form-control-static">' . $user[0]->email . '</p>
				  					 	</div>
				  					</div>';
	  						} else {
	  							echo '<div id="emailUserInputGroup" class="form-group">
				  						<label for="inputEmail" class="col-lg-3 control-label">Email*</label>
				  						<div class="col-lg-4">
				  							<input type="text" class="form-control" id="emailUser" name="emailUser" >
				  					 	</div>
				  					</div>';
	  						}
	  					?>


	  					<div id="passwordUserInputGroup" class="form-group">
	  						<label for="inputPassword" class="col-lg-3 control-label"><?= (isset($user) ? 'Nova ' : "" )?>Password*</label>
	  						<div class="col-lg-4">
	  							<input type="password" class="form-control" id="passwordUser" name="passwordUser">
	  					 	</div>
	  					</div>

	  					

	  					<?
	  						if(isset($user)) {
	  							echo '<div class="form-group">
				  						<label class="col-lg-3 control-label">Data de criação</label>
				  						<div class="col-lg-4">
				  							<p class="form-control-static">' . $user[0]->creation_date . '</p>
				  					 	</div>
				  					</div>
				  					<div class="form-group">
				  						<label class="col-lg-3 control-label">Último login</label>
				  						<div class="col-lg-4">
				  							<p class="form-control-static">' . (isset($user[0]->last_login) ? $user[0]->last_login : '--') . '</p>
				  					 	</div>
				  					</div>';
	  						}

	  					?>

	  					<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
	  						<div class="text-center">
	  							<button onclick="location.href='../lists/user-list.php'" type="button" class="btn btn-xs">Cancelar</button>
	  							<button class="btn btn-xs btn-primary" type="submit"><?=(isset($user) ? "Alterar" : "Submeter")?></button>
	  						</div>
	  					</div>
	  				</form>
		   		</div>

            	<div class="col-xs-4 col-lg-4">
			        <div class="panel panel-default">
				        <div class="panel-body">
				        	<p><span class="label label-default">Informações</span></p>
				        	<p>Neste formulário podes inserir ou alterar os utilizadores que acedem ao GroundWater.</p>
				        	<p>O <strong>email</strong> e a <strong>password</strong> serão usados para identificar os utilizadores. Não podem existir diferentes utilizadores com o mesmo email.</p>
					    	<p><strong>Todos os campos com * são obrigatórios.</strong></p>
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
    		var firstName = $('#first_name').val();
    		var lastName = $('#last_name').val();
    		var email = $('#emailUser').val();
    		var user_id = $('#user_id').val();
    		var password = $('#passwordUser').val();

    		if (!user_id && password == "") {
				hasErrors = true;
    			$('#passwordUserInputGroup').addClass('has-error');
    		} else {
    			$('#passwordUserInputGroup').removeClass('has-error');
    		}

    		var hasErrors = false;

    		if(firstName == "" ) {
    			hasErrors = true;
    			$('#firstInputGroup').addClass('has-error');
    		} else {
    			$('#firstInputGroup').removeClass('has-error');
    		}

			if(lastName == ""){
    			hasErrors = true;
				$('#lastInputGroup').addClass('has-error');
			} else {
    			$('#lastInputGroup').removeClass('has-error');
    		}

			if(email == ""){
    			hasErrors = true;
				$('#emailUserInputGroup').addClass('has-error');
			} else {
				//validar email
				var regexEmail = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
				if (!regexEmail.test(email)){
    				hasErrors = true;
					$('#emailUserInputGroup').addClass('has-error');
				} else {
    				$('#emailUserInputGroup').removeClass('has-error');
				}
    		}


    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens!</strong> Faltam parâmetros a este utilizador!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>