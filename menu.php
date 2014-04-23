<!-- incluir alertas -->
<div class="container">
	<div class="row">
		<div class="col-xs-4 col-lg-offset-4 col-lg-8 col-lg-offset-2">
		    <div id="alert-message" class="alert-message" style="display:none">
		    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
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
    if (params["sucess"] < 0){

      if(params["sucess"] == -3){
          $('#alert-message').show();
          $('#alert-message').addClass('warning');
          $('#alert-text').html("<strong>Ups daisy!</strong>" +  params["reason"]);
      } else if(params["sucess"] == -2){
          $('#alert-message').show();
          $('#alert-message').addClass('warning');
          $('#alert-text').html("<strong>Ups daisy!</strong> Operação concluída com sucesso. No entanto verifica o seguinte: <br />" + params["reason"]);
      } else{
        $('#alert-message').show();
        $('#alert-message').addClass('danger');
        $('#alert-text').html("<strong>Shit happens!</strong> Ocorreu um erro. " + params["reason"]);
      }
    } else if (params["sucess"] == 1){
      $('#alert-message').show();
      $('#alert-message').addClass('success');
      $('#alert-text').html("<strong>Holy guacamole!</strong> Registo criado/alterado com sucesso." + (params["inserted"] != null && params["inserted"] != "" ? " Foram inseridos: " + params["inserted"] + " registos." : ""));
    } else if (params["sucess"] == 2){
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
      <a class="navbar-brand" href=<?= PROJECT_URL . "index.html"?>>Groundwater</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li <?=(strpos($_SERVER['PHP_SELF'], 'index.html') !== false ? 'class="active"' :  '')?>><a href=<?= PROJECT_URL . "index.html"?> >Home</a></li>

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

      </ul>
    <form class="navbar-form navbar-right" role="form">
		<div class="form-group">
			<input type="text" placeholder="Email" class="form-control">
		</div>
		<div class="form-group">
			<input type="password" placeholder="Password" class="form-control">
		</div>
		<button type="submit" class="btn btn-success">Sign in</button>
	</form>
    </div>
  </div>
</nav>


