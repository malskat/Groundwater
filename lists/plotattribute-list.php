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
		<!-- Bootstrap core CSS -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<!-- Bootstrap alerts -->
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

	  	<?
	  		if ($_BIOLOGYST_LOGGED === false) {
	  			header('Location: ' . PROJECT_URL . 'index.php?response=-1');
	  			die;
	  		} 

			$plot_sample_values = array();
			$plot = array();

		    $getParameters = "";

			if (isset($_GET['plot'])) {
	  		
		   		require_once '../data/plotattribute_data.php';
		    	$plotAttributeData = new PlotAttribute();
				
				$whereClause = 'pa.plot_id = "' . $_GET['plot'] . '"';
		    	$plot_sample_values = $plotAttributeData->getPlotAttributeBy($whereClause, (isset($_GET["page"]) ? $_GET["page"] : 0));

		    	if (count($plot_sample_values) <= 1) {
					require_once '../data/plot_data.php';
			    	$plotData = new Plot();
			    	$plot = $plotData->getPlotBy("plot_id = " . $_GET["plot"], -1);

				} else {
			    	$plot[0]->title = $plot_sample_values[1]->siteTitle;
			    	$plot[0]->code = $plot_sample_values[1]->plotCode;
				}

			}




			$fields = $plotAttributeData->getFieldList();

			$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
	  		if (false === strpos($backUrl, 'plot.php') && false === strpos($backUrl, 'plot-list')) {
				$backUrl = '../lists/plot-list.php';
	  		}

		?>

	  	<!-- incluir menu principal -->
	  	<?php include "../menu.php";?>

	    <!-- titulo -->
	    <div class="container">
			<div class="row">
				<div class="page-header">
					<h2>
						Plot Water Info
						<small>for <?=(isset($_GET['plot']) ? $plot[0]->title . ' ' .  $plot[0]->code : 'Invalid')?></small>
					</h2>
				</div>
			</div>
		</div>

 		<div class="container">
			<div class="row">
				<div class="col-xs-2 col-lg-8">
					<button class="btn btn-link" onclick="location.href='<?=$backUrl?>'">« back</button>
				</div>

				<div class="col-xs-6 col-lg-4"> 
	        		<button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/plotattribute.php?plot=<?=$_GET['plot']?>'">
	        			Insert Plot Sample
	        		</button>
		        </div>
		        
			</div>
		</div>


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
				                <th>Edit</th>
				                <th>Remove</th>
				            </tr>
		            	</thead>
		            	<tbody>
		            		<?
				                if(count($plot_sample_values) > 1) {
				             		foreach ($plot_sample_values as $plot_sample) {
					                    if(isset($plot_sample->plotCode)){
					                    	echo '<tr>
					                    			<td>' . $plot_sample->plot_attribute_id . '</td>
	      	            	    					<td>' . $plot_sample->measureDate . '</td>
	      	            	    					<td>' . $plot_sample->campaignDesignation . '</td>
	      	            	    					<td>' . (isset($plot_sample->groundWater_18o) && $plot_sample->groundWater_18o != "" ? $plot_sample->groundWater_18o : 'N.D.') . '</td>
	      	            	    					<td>' . (isset($plot_sample->pondWater_18o) && $plot_sample->pondWater_18o != "" ? $plot_sample->pondWater_18o : 'N.D.') . '</td>
	      	            	    					<td>' . (isset($plot_sample->gw_level) && $plot_sample->gw_level != "" ? $plot_sample->gw_level : 'N.D.') . '</td>
	      	            	    					<td>' . $plot_sample->creation_date . '</td>';
	      	            	    			echo '<td>
						      	                  		<button onclick="location.href=\'../forms/plotattribute.php?id=' . $plot_sample->plot_attribute_id . '\'" type="button" class="btn btn-primary btn-xs">
						      	                  			<span class="glyphicon glyphicon glyphicon-edit"></span>
						      	                  		</button>
						      	                  	</td>';

						      	            if (!isset($plot_sample->totalSoilPlots) || $plot_sample->totalSoilPlots == 0) {
							      	            echo '<td>
							                              <button onclick="beginDelete(\'action=delete&class=plotattribute&id=' . $plot_sample->plot_attribute_id . '\', \'Do you want to remove this Plot Water Info?\');" type="button" class="btn btn-danger btn-xs">
							                                <span class="glyphicon glyphicon-remove-sign"></span>
							                              </button>
							                            </td>';
						      	            } else {
						      	            	echo '<td>
						      	            			<span id="removeTooltip_' . $plot_sample->plot_attribute_id . '" class="label label-default" data-toggle="tooltip" data-placement="left" title="It has Soil Samples associated">Better not</span>
						      	            		</td>'; 
						      	            }


	      	            	    			echo '</tr>';
					                    }
					                }
					            } else {
					            	echo '<tr><td colspan=' . (count($fields) + 2) . ' style="text-align:center">No data to show!</td></tr>';
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
		          <h5>Total records <span class="badge"><?=(isset($plot_sample_values[0]) ? $plot_sample_values[0]->totalRecords : 0 )?></span></h5>
		        </div>
		        <div class="col-xs-4 col-lg-4">
		          <div class="text-center">
		            <ul class="pagination">
		              <?
		                //paginas
		                $addPage = (isset($plot_sample_values[0]) && ($plot_sample_values[0]->totalRecords % $plotAttributeData->getTotalRows()) > 0 ? 1 : 0);
		                $nPages = (isset($plot_sample_values[0]) ? floor($plot_sample_values[0]->totalRecords / $plotAttributeData->getTotalRows()) : 0 ) + $addPage;
		                if ( $nPages > 1) {

		                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

		                  //botao para tras
		                  if ($currentPage == 1) {
		                    echo '<li class="disabled"><a >&laquo;</a></li>';
		                  } else {
		                    $newPage = ($currentPage - 1);
		                    echo '<li><a href="plotattribute-list.php?plot=' . $_GET['plot'] . '&page=' . $newPage . ($getParameters != "" ? $getParameters : "") . '">&laquo;</a></li>';
		                  }

		                  $begin = (($currentPage - 3) > 1 ? ($currentPage - 3) :  1 ); 
		                  $end = (($currentPage + 3) < $nPages ? ($currentPage + 3) :  $nPages ); 

		                  for ($i = $begin; $i <= $end; $i++ ) {
		                    $active = ($currentPage == $i  ? 'class="active"' : "");
		                    echo '<li ' . $active . '><a href="plotattribute-list.php?plot=' . $_GET['plot'] . '&page='. $i . ($getParameters != "" ? $getParameters : "") . '">' . $i . '</a></li>';
		                  }

		                  //botao para a frente
		                  if ($currentPage == $nPages) {
		                    echo '<li class="disabled"><a >&raquo;</a></li>';
		                  } else {
		                    $newPage = ($currentPage + 1);
		                    echo '<li><a href="plotattribute-list.php?plot=' . $_GET['plot'] . '&page=' . $newPage . ($getParameters != "" ? $getParameters : "") . '">&raquo;</a></li>';
		                  }

		                }

		              ?>
		            </ul>
		          </div>
		        </div>
	        	<div class="col-xs-4 col-lg-4"></div>
	    	</div>
	    </div>

	    <?php include "../footer.php";?>

	    <script>
		    <?php
			    foreach ($plot_sample_values as $plot_sample) {
			    	if (isset($plot_sample->plot_attribute_id)) {
				    	echo "$('#accessSoilSamplesTooltip_" . $plot_sample->plot_attribute_id . "').tooltip({trigger: 'hover'});";
			    	}

			    	if (isset($plot_sample->totalSoilPlots) && $plot_sample->totalSoilPlots > 0 ) {
			    		echo "$('#removeTooltip_" . $plot_sample->plot_attribute_id . "').tooltip({trigger: 'hover'});";
			    	}
			    }
			?>
		</script>

	</body>
</html>

