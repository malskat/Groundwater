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

		<title>Projecto Ground Water</title>

		<script src="../js/jquery-1.10.2.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<!-- Bootstrap core CSS -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<!-- Bootstrap alerts -->
		<link href="../css/alerts.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="../css/mainCore.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="../../assets/js/html5shiv.js"></script>
		  <script src="../../assets/js/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>

	  	<!-- incluir menu principal -->
	  	<?php include "../menu.php";?>

	  	<?
		    include '../data/ecofisio_data.php';

			$ecoFisioValues = array();
		    $ecoFisioData = new EcoFisio();

			if (isset($_GET['individualCode'])) {
		    	$ecoFisioValues = $ecoFisioData->getEcoFisioBy($where = 'ef.individualCode = "' . $_GET['individualCode'] . '"', $orderBy = 'ef.samplingDate ASC' , 
		    	                                               isset($_GET["page"]) ? $_GET["page"] : 0);
			}

			$fields = $ecoFisioData->getFieldList();

			$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
	  		if (false === strpos($backUrl, 'individual.php') && false === strpos($backUrl, 'individual-list')) {
				$backUrl = '../lists/individual-list.php';
	  		}
		?>

	    <!-- titulo -->
	    <div class="container">
			<div class="row">
				<div class="page-header">
					<h2>Eco-Fisiologia</h2>
					<h5>Indivíduo - <?=$_GET['individualCode']?></h5>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-lg-8">
					<button class="btn btn-link" onclick="location.href='<?=$backUrl?>'">« voltar</button>
				</div>
				<div class="col-xs-6 col-lg-4">
					<div class="btn-group pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
								Gráficos <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="../charts/ecofisio-temporaloverview.php?individualCode=<?=$_GET['individualCode']?>"><strong>Temporal Overview</strong></a></li>
								<li><a href="../charts/ecofisio-leaf13CphotoPI.php?individualCode=<?=$_GET['individualCode']?>"><strong>Leaf 13C and PI / Xylem 18O</strong></a></li>
								<li><a href="../charts/ecofisio-leaf15NleafCN.php?individualCode=<?=$_GET['individualCode']?>"><strong>Leaf 15N and CN / Xylem 18O</strong></a></li>
							</ul>
						</div>
						<button type="button" class="btn btn-primary btn-sm" onclick="location.href='../forms/ecofisio.php?individualCode=<?=$_GET['individualCode']?>'">Inserir Amostragem</button>
					</div>
				</div>
			</div>
		</div>

	    	<!-- tabela e gráfico -->
	    <div class="container">
	  		<div class="row spacer">
	  			<div class="col-xs-12 col-lg-12">
	  				<table class="table table-hover">
		        		<thead>
			              <tr class="active">
			              	<?
			              		foreach ($fields as $field) {
			              			echo '<th>' . $field . '</th>';
			              		}
			              	?>
			                <th>Acções</th>
			              </tr>
		            	</thead>
		            	<tbody>
		            		<?
				                if(count($ecoFisioValues) > 1) {
				             		foreach ($ecoFisioValues as $ecoFisioValue) {
					                    if(isset($ecoFisioValue->individualCode)){
					                    	echo '<tr>
					                    			<td>' . $ecoFisioValue->campaignDesignation . '</td>
					                    			<td>' . $ecoFisioValue->samplingDate . '</td>
	      	            	    					<td>' . (isset($ecoFisioValue->leaf_13C) && $ecoFisioValue->leaf_13C != "" ? $ecoFisioValue->leaf_13C : 'ND' ) . '</td>
	      	            	    					<td>' . (isset($ecoFisioValue->leaf_15N) && $ecoFisioValue->leaf_15N != "" ? $ecoFisioValue->leaf_15N : 'ND' ) . '</td>
	      	            	    					<td>' . (isset($ecoFisioValue->xylemWater_18O) && $ecoFisioValue->xylemWater_18O != "" ? $ecoFisioValue->xylemWater_18O : 'ND' ) . '</td>
	      	            	    					<td>' . (isset($ecoFisioValue->photosynthetic_PI) && $ecoFisioValue->photosynthetic_PI != "" ? $ecoFisioValue->photosynthetic_PI : 'ND' ) . '</td>
	      	            	    					<td>
	      	            	    						<div class="btn-group">
	      	            	    							<button onclick="location.href=\'../forms/ecofisio.php?individualCode=' . $ecoFisioValue->individualCode . '&sampling_campaign_id=' . $ecoFisioValue->sampling_campaign_id . '\'" type="button" class="btn btn-primary btn-xs">
							      	                  			<span class="glyphicon glyphicon glyphicon-edit"></span>
							      	                  		</button>
							      	                  		<button onclick="beginDelete(\'action=delete&class=ecofisio&id=' . $ecoFisioValue->individualCode . '|' . $ecoFisioValue->sampling_campaign_id . '\', \'Queres mesmo remover esta amostragem de Eco-Fisiologia?\');" type="button" class="btn btn-danger btn-xs">
								                            	<span class="glyphicon glyphicon-remove-sign"></span>
								                            </button>
	      	            	    						</div>
	      	            	    					</td>
	      	            	    				</tr>';
					                    }
					                }
					            } else {
					            	echo '<tr><td colspan=' . (count($fields) + 2) . ' style="text-align:center">Não existem resultados para apresentar!</td></tr>';
					            }
					        ?>
		            	</tbody>
		            </table>
		        </div>
		    </div>
		</div>

        <!-- paginacao -->
	    <div class="container">
	    	<div class="row">
		        <div class="col-xs-4 col-lg-4">
		          <h5>Total de registos <span class="badge"><?=$ecoFisioValues[0]->totalRecords?></span></h5>
		        </div>
		        <div class="col-xs-4 col-lg-4">
		          <div class="text-center">
		            <ul class="pagination">
		              <?
		                //paginas
		                $addPage = (($ecoFisioValues[0]->totalRecords % $ecoFisioData->getTotalRows()) > 0 ? 1 : 0);
		                $nPages = floor($ecoFisioValues[0]->totalRecords / $ecoFisioData->getTotalRows()) + $addPage;
		                if ( $nPages > 1) {

		                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

		                  //botao para tras
		                  if ($currentPage == 1) {
		                    echo '<li class="disabled"><a >&laquo;</a></li>';
		                  } else {
		                    $newPage = ($currentPage - 1);
		                    echo '<li><a href="ecofisio-list.php?individualCode=' . $_GET['individualCode'] . '&page=' . $newPage . '">&laquo;</a></li>';
		                  }

		                  $begin = (($currentPage - 3) > 1 ? ($currentPage - 3) :  1 ); 
		                  $end = (($currentPage + 3) < $nPages ? ($currentPage + 3) :  $nPages ); 

		                  for ($i = $begin; $i <= $end; $i++ ) {
		                    $active = ($currentPage == $i  ? 'class="active"' : "");
		                    echo '<li ' . $active . '><a href="ecofisio-list.php?individualCode=' . $_GET['individualCode'] . '&page='. $i .'">' . $i . '</a></li>';
		                  }

		                  //botao para a frente
		                  if ($currentPage == $nPages) {
		                    echo '<li class="disabled"><a >&raquo;</a></li>';
		                  } else {
		                    $newPage = ($currentPage   + 1);
		                    echo '<li><a href="ecofisio-list.php?individualCode=' . $_GET['individualCode'] . '&page=' . $newPage .'">&raquo;</a></li>';
		                  }

		                }

		              ?>
		            </ul>
		          </div>
		        </div>
	        	<div class="col-xs-4 col-lg-4"></div>
	    	</div>
	    </div>
	</body>
</html>

