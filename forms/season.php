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
  		if(isset ($_GET["season_id"])){
  			include "../data/season_data.php"; 
  			$seasonData = new Season();
			$season = $seasonData->getSeasonBy("season_id = " . $_GET["season_id"], -1);
  		}
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
    	<div class="row">
	    	<div class="page-header">
	       		<h1>Época</h1>
	      	</div>
	    </div>
	</div>

	<!-- formulario -->
	<div class="container">
      <div class="row">
		<div class="col-xs-12 col-lg-12">
	        <div class="panel panel-primary">
	        	<div class="panel-heading">
				   <h3 class="panel-title"><?=((isset($season) && is_array($season) && count($season) > 0) ? "Editar Época" : "Inserir Época")?></h3>
				</div>
		        <div class="panel-body">
		        	<div class="col-xs-8 col-lg-8">
		        		<form class="form-horizontal" role="form" name="form_season_data" action="../services/seasonSubmissionData.php" onsubmit="return validateForm();" method="post">

							<?= (isset($season) ?'<input type="hidden" value="' . $season[0]->season_id . '" name="season_id" >' : '')?>

							<div id="codeInputGroup" class="form-group">
								<label for="inputCode" class="col-lg-3 control-label">Código*</label>
								<div class="col-lg-4">
									<input type="text" class="form-control" id="code" name="code" placeholder="Código da época" value=<?= (isset($season) ? '"' . $season[0]->code . '"' : "") ?>>
							 	</div>
							</div>

							<div id="startDateInputGroup" class="form-group">
								<label for="inputCode" class="col-lg-3 control-label">Início (Europa)*</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="startDate" name="startDate" class="input-medium" readonly value= <?= (isset($season) ? $season[0]->startDate : "") ?>>
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

							<div id="endDateInputGroup" class="form-group">
								<label for="inputCode" class="col-lg-3 control-label">Fim (Europa)*</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div class="input-prepend bfh-datepicker-toggle" data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="endDate" name="endDate" class="input-medium" readonly value=<?= (isset($season) ? $season[0]->endDate : "") ?>>
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

							<div class="form-group">
								<label for="inputCode" class="col-lg-3 control-label">Início (Trópicos)</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="tropicalStartDate" name="tropicalStartDate" class="input-medium" readonly value= <?= (isset($season) ? $season[0]->tropicalStartDate : "") ?>>
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

							<div class="form-group">
								<label for="inputCode" class="col-lg-3 control-label">Fim (Trópicos)</label>
								<div class="col-lg-4">
									<div class="bfh-datepicker">
									  <div class="input-prepend bfh-datepicker-toggle" data-toggle="bfh-datepicker">
									    <span class="add-on"><i class="icon-calendar"></i></span>
									    <input type="text" id="tropicalEndDate" name="tropicalEndDate" class="input-medium" readonly value=<?= (isset($season) ? $season[0]->tropicalEndDate : "") ?>>
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

							<div class="spacer well well-sm col-xs-4 col-lg-4 col-lg-offset-4">
								<div class="text-center">
									<button onclick="location.href='../lists/season-list.php'" type="button" class="btn btn-xs">Cancelar</button>
									<button class="btn btn-xs btn-primary" type="submit"><?=(isset($season) ? "Alterar" : "Submeter")?></button>
								</div>
							</div>

						</form>
		        	</div>

		        	<div class="col-xs-4 col-lg-4">
				        <div class="panel panel-default">
					        <div class="panel-body">
					        	<p><span class="label label-default">Informações</span></p>
					        	<p>Neste formulário podes inserir ou alterar as épocas de amostragem.</p>
					        	<p>Estas épocas são usadas, por exemplo, para agregar campanhas feitas em locais distintos.</p>
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
    		var code = $('#code').val();
    		var startDate = $('#startDate').val();
    		var endDate = $('#endDate').val();
    		var hasErrors = false;


    		if(code == "" ) {
    			hasErrors = true;
    			$('#codeInputGroup').addClass('has-error');
    		} else {
    			$('#codeInputGroup').removeClass('has-error');
    		}

			if(startDate == ""){
    			hasErrors = true;
				$('#startDateInputGroup').addClass('has-error');
			} else {
    			$('#startDateInputGroup').removeClass('has-error');
    		}

    		if(endDate == "" ) {
    			hasErrors = true;
    			$('#endDateInputGroup').addClass('has-error');
    		} else {
    			$('#endDateInputGroup').removeClass('has-error');
    		}

    		if (hasErrors){
    			$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens!</strong> Faltam parâmetros à época!");
    			return false;
    		} else {
    			return true;
    		}

    	}
    </script>

  </body>
</html>