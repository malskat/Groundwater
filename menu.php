<!-- incluir alertas -->
<div class="container">
	<div class="row">
		<div class="col-xs-4 col-lg-offset-4 col-lg-8 col-lg-offset-2">
		    <div id="alert-message" class="alert-message" style="display:none">
		    	<button type="button" class="close" data-hide="alert-message" aria-hidden="true">&times;</button>  
		    	<p id="alert-text"></p>
		    </div>
		</div>
	</div>
</div>	

<?php 
	require_once '/config/constants.php';
?>
<script src="../js/utils.js"></script>
<script>


  //para os alertas
	var params = getQueryParams(window.location.search);
    if (params["success"] < 0) {

      	if(params["success"] == -3) {
        	$('#alert-message').show();
          	$('#alert-message').addClass('warning');
          	$('#alert-text').html("<strong>Ups daisy!</strong>" +  params["reason"]);
    	} else if(params["success"] == -2) {
        	$('#alert-message').show();
          	$('#alert-message').addClass('warning');
          	$('#alert-text').html("<strong>Ups daisy!</strong> Operação concluída com sucesso. No entanto verifica o seguinte: <br />" + params["reason"]);
      	} else {
        	$('#alert-message').show();
        	$('#alert-message').addClass('danger');
        	$('#alert-text').html("<strong>Shit happens!</strong> Atenção. " + params["reason"]);
      	}
    } else if (params["success"] == 1) {
      	$('#alert-message').show();
      	$('#alert-message').addClass('success');
      	$('#alert-text').html("<strong>Holy guacamole!</strong> Registo criado/alterado com sucesso." + (params["inserted"] != null && params["inserted"] != "" ? " Foram inseridos: " + params["inserted"] + " registos." : ""));
    } else if (params["success"] == 2) {
      	$('#alert-message').show();
      	$('#alert-message').addClass('success');
      	$('#alert-text').html("<strong>Holy guacamole!</strong> Registo eliminado com sucesso.");
    }
</script>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=<?= PROJECT_URL?>>Groundwater</a>
    </div>
    <div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">

			<li <?=(strpos($_SERVER['PHP_SELF'], 'season') !== false || strpos($_SERVER['PHP_SELF'], 'campaign') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campanhas <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li role="presentation" class="dropdown-header">Épocas</li>
			    <li><a href=<?= PROJECT_URL . "forms/season.html" ?>>Inserir</a></li>
			    <li><a href=<?= PROJECT_URL . "lists/season-list.html"?>>Consultar</a></li>
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Campanhas</li>
			    <li><a href=<?= PROJECT_URL . "forms/campaign.html" ?>>Inserir</a></li>
			    <li><a href=<?= PROJECT_URL . "lists/campaign-list.html"?>>Consultar</a></li>
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'site') !== false || strpos($_SERVER['PHP_SELF'], 'plot') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Locais <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    
			    <li role="presentation" class="dropdown-header">Site</li>
			    <li><a href=<?= PROJECT_URL . "forms/site.html"?>>Inserir</a></li>
			    <li><a href=<?= PROJECT_URL . "lists/site-list.html"?>>Consultar</a></li> 
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Plot</li>
			    <li><a href=<?= PROJECT_URL . "forms/plot.html"?>>Inserir</a></li>
			    <li><a href=<?= PROJECT_URL . "forms/plot-csv.html"?>>Inserir por CSV</a></li>
			    <li><a href=<?= PROJECT_URL . "lists/plot-list.html"?>>Consultar</a></li> 
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'species') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espécies <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?= PROJECT_URL . "forms/species.html"?>>Inserir</a></li>
			    <li><a href=<?= PROJECT_URL . "forms/species-csv.html"?>>Inserir por CSV</a></li>
			    <li><a href=<?= PROJECT_URL . "lists/species-list.html"?>>Consultar</a></li> 
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'individual') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Indivíduos <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?= PROJECT_URL . "forms/individual.html"?>>Inserir</a></li>
			    <li><a href=<?= PROJECT_URL . "forms/individual-csv.html"?>>Inserir por CSV</a></li>
			    <li><a href=<?= PROJECT_URL . "lists/individual-list.html"?>>Consultar</a></li> 
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'user') !== false ? 'class="active"' :  '')?> class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilizadores <b class="caret"></b></a>
			  	<ul class="dropdown-menu">
			    	<li><a href=<?= PROJECT_URL . "forms/user.html"?>>Inserir</a></li>
			    	<li><a href=<?= PROJECT_URL . "lists/user-list.html"?>>Consultar</a></li> 
			  	</ul>
			</li>

		</ul>
		<div id="loginForm" name="loginForm" style="display:block;">
		    <form class="navbar-form navbar-right" role="form" onsubmit="return validateLogin();" method="post">
				<div id="emailInputGroup" class="form-group">
					<input id="email" name="email" type="text" placeholder="Email" class="form-control">
				</div> 
				<div id="passInputGroup" class="form-group">
					<input id="password" name="password" type="password" placeholder="Password" class="form-control">
				</div>
				<button id="loginTooltip" type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Por implementar!">Login</button>
			</form>
		</div>
		<div id="loggedInfo" name="loggedInfo" style="display:none;">
			<div class="navbar-collapse collapse">
        		<ul class="nav navbar-nav navbar-right">
            		<li><a href="#"><span class="glyphicon glyphicon glyphicon-user"></span> Cristina Antunes</a></li>
            		<li><a href="#"><span class="glyphicon glyphicon glyphicon-off"></span></a></li>
	            </ul>
			</div>
		</div>
    </div>
  </div>
</nav>



<!-- Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        	<h4 class="modal-title" id="modalLabel"></h4>
	      	</div>
			<div class="modal-body">
				<p id="modalDescription" name="modalDescription"></p>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
	        	<button id="removeModalButton" type="button" class="btn btn-primary">Sim</button>
	      	</div>
	    </div>
 	</div>
</div>

<script>

	//para mostrar a tooltip do login
	$('#loginTooltip').tooltip({trigger: 'hover'});

	//para fechar o alert;
	$(function(){
	    $("[data-hide]").on("click", function(){
	        $(this).closest("." + $(this).attr("data-hide")).hide();
	    });
	});


	//para validar o login
	function validateLogin(){
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
	        $('#alert-text').html("<strong>Shit happens!</strong> Faltam parâmetros ao login (email e password são obrigatórios)!");
			return false;
		} else {
			$("#loginForm").hide();
			$("#loggedInfo").hide();
			return true;
		}
	}
</script>


