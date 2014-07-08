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

  	<?php 
  		include "../data/plot_data.php";
      	include "../data/site_data.php";
			
      		$plotData = new Plot();

			$plots = array();
			$getParameters = "";

			if(isset($_GET["site"]) || isset($_GET["code"])){

				$whereClause = "";

				if(isset($_GET["site"])){
				   $whereClause .= "p.site_id = " . $_GET["site"];
				   $getParameters .= "site=" . $_GET["site"];
				}

				if(isset($_GET["code"])){
				  if ($whereClause != "") {
				    $whereClause .= " and upper(p.code) like upper('%" . $_GET["code"] . "%')";
				    $getParameters .= "code=" . $_GET["code"];
				  } else {
				    $whereClause .= " upper(p.code) like upper('%"  . $_GET["code"] . "%')";
				    $getParameters .= "&code=" . $_GET["code"];
				  }
				}

				$plots = $plotData->getPlotBy($whereClause, (isset($_GET["page"]) ? $_GET["page"] : 0), $withTotalIndividuals = 1);
			} else {
				$plots = $plotData->getPlotsSite((isset($_GET["page"]) ? $_GET["page"] : 0), $withTotalIndividuals = 1); 
			}

	  		$fields = $plotData->getFieldList();
      		
      		$siteData = new Site();
	      	$sites = $siteData->getSites(-1);
	  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
       		<h1>Plots</h1>
      	</div>
      </div>
    </div>

    <!-- accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10">
          <form  class="form-inline" role="form" name="form_searchplot_data" action="../core/core_action.php" method="post">
            <input type="hidden" value="search" name="action">
            <input type="hidden" value="plot" name="class">
            <div class="form-group">
              <input type="text" class="form-control input-sm" name="code" placeholder="Code" value=<?= (isset($_GET["code"]) ? '"' . $_GET["code"] . '"' : "") ?>>
            </div>
            <div class="form-group">
              <select name="site" class="form-control input-sm">
                <option value="none">Site</option>
                <?php
                  foreach($sites as $site){
                    echo '<option ' . (isset($_GET["site"]) && $site->site_id == $_GET["site"] ? 'selected' : '') . ' value="' . $site->site_id . '">' . $site->title . '</option>';
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
          </form>
        </div>
        <div class="col-xs-6 col-lg-2"> 
          <!-- insercao -->
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/plot.php'">Insert Plot</button>
        </div>
      </div>
    </div>

    <!-- lista -->
    <div class="container">
  		<div class="row spacer">
  			<div class="col-xs-12 col-lg-12">
          		<table class="table table-hover">
        		<thead>
              		<tr class="active">
		              	<?php
		              		foreach ($fields as $field) {
		              			echo '<th>' . $field . '</th>';
		              		}
		              	?>
                		<th>Edit</th>
                		<th>Remove</th>
              		</tr>
           		 </thead>
	            <tbody>
	          		<?php
	                if(count($plots) > 1) {
	               		foreach ($plots as $plot) {
	                    if(isset($plot->plot_id)){
	                      $plot_type = (isset($plot->plotType) && $plot->plotType != "" ? ($plot->plotType == 'ch' ? 'Pond' : 'Dune') : 'N.D.');
	               				echo '<tr>
	    	            	    		<td>' . $plot->plot_id . '</td>
	    	                			<td>' . $plot->code . '</td>
	                        			<td>' . $plot->title . '</td>
	                        			<td>' . $plot_type . '</td>
	    	                  			<td>' . (isset($plot->coordinateX) && $plot->coordinateX != "" && $plot->coordinateX !== "-1"? $plot->coordinateX : "N.D.") . '</td>
	    	                  			<td>' . (isset($plot->coordinateY) && $plot->coordinateY != "" && $plot->coordinateY !== "-1"? $plot->coordinateY : "N.D.") . '</td>';
	    	                  			
	    	                  			if ($plot->totalIndividuals > 0) {
	                        				echo '<td><a href="individual-list.php?plot=' . $plot->plot_id .  '"><span id="accessTooltip_' . $plot->plot_id . '" data-toggle="tooltip" data-placement="left" title="Click to see this Individuals" class="label label-default">' . $plot->totalIndividuals . '</span></a></td>';
	    	                  			}else {
	    	                  				echo '<td><span class="label label-default">' . $plot->totalIndividuals . '</a></td>';
	    	                  			}

				  	                  	echo '<td>
				  	                  		<button onclick="location.href=\'../forms/plot.php?plot_id=' . $plot->plot_id . '\'" type="button" class="btn btn-primary btn-xs">
				  	                  			<span class="glyphicon glyphicon-edit"></span>
				  	                  		</button>
				  	                  	</td>
								        <td>';

							   
								        if ($plot->totalIndividuals == 0) {
									        echo '<button onclick="beginDelete(\'action=delete&class=plot&id=' . $plot->plot_id . '\', \'Do you want to remove this Individual?\');" type="button" class="btn btn-danger btn-xs">
									            <span class="glyphicon glyphicon-remove-sign"></span>
									          </button>';
								        } else {
								        	echo '<span id="removeTooltip_' . $plot->plot_id . '" class="label label-default" data-toggle="tooltip" data-placement="left" title="It has Individuals associated">Better not</span>'; 
								        }

									    echo '</td>
	    	                		</tr>';
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
          <h5>Total records <span class="badge"><?=$plots[0]->totalRecords?></span></h5></div>
        <div class="col-xs-4 col-lg-4"> 
          <div class="text-center">
            <ul class="pagination">

              <?php

                //paginas
                $addPage = (($plots[0]->totalRecords % $plotData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($plots[0]->totalRecords / $plotData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="plot-list.php?page=' . $newPage . ($getParameters != "" ? '&' . $getParameters : "") . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="plot-list.php?page='. $i . ($getParameters != "" ? '&' . $getParameters : "") . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="plot-list.php?page=' . $newPage . ($getParameters != "" ? '&' . $getParameters : "") . '">&raquo;</a></li>';
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
	    foreach ($plots as $plot) {
	    	if (isset($plot->plot_id) && $plot->totalIndividuals > 0) {
		    	echo "$('#removeTooltip_" . $plot->plot_id . "').tooltip({trigger: 'hover'});";
		    	if ($plot->totalIndividuals > 0) {
		    		echo "$('#accessTooltip_" . $plot->plot_id . "').tooltip({trigger: 'hover'});";
		    	}
	    	}
	    }
	?>
    </script>

  </body>
</html>