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
    
  	<!-- incluir menu principal -->
    <?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
         		<h1>Plots</h1>
        </div>
      </div>
    </div>

    <div class="container">
  		<div class="row">
  			<div class="col-xs-12 col-lg-12">
	  			<div class="panel panel-primary">
		        	<div class="panel-heading">
					   <h3 class="panel-title">Inserir Plots por csv</h3>
					</div>
			        <div class="panel-body">
			        	<div class="col-xs-8 col-lg-8">
				        	<form class="form-horizontal" role="form" name="form_plot_csv_data" enctype="multipart/form-data" action="../services/plotSubmissionData.php" onsubmit="return validateForm();"  method="post">

				  				<input type="hidden" value="excel" name="submissionType" >

				  				<div id="fileInputGroup" class="form-group spacer">
				  					<label for="inputGenus" class="col-lg-2 control-label">Ficheiro*</label>
				  					<div class="col-lg-6">
				  						<input type="file" class="form-control" id="file" name="file" placeholder="">
				  				 	</div>
				  				</div>

				  				<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
									<div class="text-center">
										<button onclick="location.href='../lists/plot-list.php'" type="button" class="btn btn-xs">Cancelar</button>
										<button class="btn btn-xs btn-primary" type="submit"><?=(isset($season) ? "Alterar" : "Submeter")?></button>
									</div>
								</div>
				  			</form>
				  		</div>
				  		<div class="col-xs-4 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-body">
								<p><span class="label label-default">Informações</span></p>
								<p>1. O ficheiro submetido tem de ter a extensão .csv .</p>
								<p>2. Consegues isso guardando o ficheiro no excel, procurando esse formato na lista de possíveis formatos.</p>
								<p>3. A primeira linha do ficheiro está guardada para o nome dos atributos.</p>
								<p>4. São necessários os seguintes atributos, para inserir um Plot: <strong>siteCode</strong>, <strong>plotCode</strong>, <strong>coordinateX</strong>, <strong>coordinateY</strong>.</p>
								<p>5. Existe um ficheiro de referência para eventuais dúvidas que possam existir.</p>
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
		        $('#alert-text').html("<strong>Shit happens!</strong> Falta o ficheiro!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>