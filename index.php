<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Projecto Ground Water</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/mainCore.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


    <div id="alert-message" class="alert-message" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
      <p id="alert-text"></p>
    </div>

    <!-- incluir menu principal -->
    <?php include "menu.php";?>

	<div class="jumbotron">
		<div class="container">
			<h1 class="text-center">GWTropiMed</h1>
			<p class="text-center">Costal dune forests under scenarios of groundwater limitations: from tropics to mediterranean.</p>
			<p class="text-center">Por Cristina Antunes.</p>
		</div>
	</div>

	<div class="container">

		<div class="row">	    
		</div>

	</div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/utils.js"></script>


    <script>
      var params = getQueryParams(window.location.search);
      if (params["sucess"] < 0){	

        if(params["sucess"] == -3){
            $('#alert-message').show();
            $('#alert-message').addClass('danger');
            $('#alert-text').html("<strong>Ups daisy!</strong>" +  params["reason"]);
        } else if(params["sucess"] == -2){
            $('#alert-message').show();
            $('#alert-message').addClass('danger');
            $('#alert-text').html("<strong>Ups daisy!</strong> Operação concluída com sucesso. No entanto verifica o seguinte: <br />" + params["reason"]);
        }else{
          $('#alert-message').show();
          $('#alert-message').addClass('danger');
          $('#alert-text').html("<strong>Shit happens!</strong> Ocorreu um erro. " + params["reason"]);
        }
      } 
      else if (params["sucess"] == 1){
        $('#alert-message').show();
        $('#alert-message').addClass('success');
        $('#alert-text').html("<strong>Holy guacamole!</strong> Registo criado com sucesso.");
      }

    </script>

  </body>
</html>
