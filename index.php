<?php
	include "checkBiologyst.php";
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

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/utils.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">

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

	<div class="container">

		<div class="jumbotron">
			<div class="container">
				<h1>GWTropiMed</h1>
				<p>Costal Dune Forests under Scenarios of Groundwater Limitation: from Tropics to Mediterranean.</p>
				<h4><em>FCT R&D Project - <small>PTDC/AAC-CLI/118555/2010</small></em></h4>
				<p><a href=<?=PROJECT_URL . "info/state-of-the-art.php"?> class="btn btn-primary btn-sm" role="button">Learn more &raquo;</a></p>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-6 col-lg-7">
				<h2>Abstract</h2>	 
				<p>Groundwater (GW) drawdown and flooding patterns changes is important to vegetation as can produce dramatic changes in plant communities, on physiological performance or survival of plant species. 
					This will affect vulnerable coastal dune forests, ecosystems particularly sensitive to GW limitation, at Tropical, Meso-mediterranen and Mediterranean areas where future climate change is predicted to drastically change water availability. The aim of the study is to evaluate, along a climatic gradient, the capacity of different plant communities to adapt to GW changes through GW stress indicators’ approach.</p>
				<p>The study consider a large climate scale, including coastal dune communities in Brazil, Portugal and Spain, providing an excellent experimental design to study GW dynamics and community functioning in natural ecosystems of high ecological value. To fulfill the main objective, suitable short- and long term ecophysiological GW limitation stress indicators (using an isotopic and reflectance indices approach) can be integrated in spatio-temporal water dynamics. Ultimately, this approach will contribute to trace GW stress in coastal vegetation and help to manage vulnerable communities.</p>
			</div>
			<div class="col-xs-2 col-lg-5 spacer">
				<div class="panel panel-default">
					<div class="panel-heading">
					   <h2 class="panel-title">Partners</h2>
					</div>
					<div class="panel-body">
						<p><strong>Faculdade de Ciências da Universidade de Lisboa</strong> (FCUL)</p>
						<p><strong>Centro de Biologia Ambiental</strong> (CBA - FCUL)</p>
						<p><strong>Universidade Estadual de Campinas</strong> (Unicamp)</p>
						<p><strong>Universidad de Sevilla</strong> (US)</p>
						<p><strong>Instituto Superior Técnico</strong> (IST)</p>
						<p><strong>Centro de Recursos Naturais e Ambiente</strong> (CERENA)</p>
						<p><strong>Universitat Bielfeld</strong> (UB)</p>
						<p><strong>Rede Eléctrica Nacional, SA</strong> (REN)</p>
						<p><a href=<?=PROJECT_URL . "info/partners.php"?> class="btn btn-info btn-xs" role="button">Partners description &raquo;</a></p>
					</div>
				</div>
			</div>
		</div>

	</div>

	<?php include "footer.php";?>

  </body>
</html>
