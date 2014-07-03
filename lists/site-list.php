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

  	<?php
  		include "../data/site_data.php";

  		$siteData = new Site();
  		$sites = $siteData->getSites(isset($_GET["page"]) ? $_GET["page"] : 0, $withTotalPlots = 1); 
  		$fields = $siteData->getFieldList();
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php";?>

    <!-- titulo -->
    <div class="container">
      <div class="row">
      	<div class="page-header">
       		<h1>Sites</h1>
      	</div>
      </div>
    </div>


    <!-- barra de accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10"></div>
        <div class="col-xs-6 col-lg-2">
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/site.php'">Insert Site</button>
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
		                <th>Editar</th>
		                <th>Remover</th>
		              </tr>
	            	</thead>
		            <tbody>
		          		<?
		                $totalRecords = 0;
		           			foreach ($sites as $site) {
		                  		if(isset($site->site_id)){
		             				echo '<tr>
				    	            	    <td>' . $site->site_id . '</td>
				    	                	<td>' . $site->code . '</td>
				    	                  	<td>' . $site->title . '</td>
				    	                  	<td>' . $site->country . '</td>
				    	                  	<td>' . (isset($site->coordinateX) && $site->coordinateX != "" ? $site->coordinateX : "N.D.") . '</td>
				    	                  	<td>' . (isset($site->coordinateY) && $site->coordinateY != "" ? $site->coordinateY : "N.D.") . '</td>';
				                          	
				                          	if ($site->totalPlots > 0) {
				                          		echo '<td><a href="plot-list.php?site=' . $site->site_id .  '"><span id="accessTooltip_' . $site->site_id . '" data-toggle="tooltip" data-placement="left" title="Click to see this Plots" class="label label-default">' . $site->totalPlots . '</span></a></td>';
				                          	} else {
				                          		echo '<td><span class="label label-default">' . $site->totalPlots . '</a></td>';
				                          	}
				    	                  	
				    	                  	echo '<td>
				    	                  		<button onclick="location.href=\'../forms/site.php?site_id=' . $site->site_id . '\'" type="button" class="btn btn-primary btn-xs">
				    	                  			<span class="glyphicon glyphicon glyphicon-edit"></span>
				    	                  		</button>
				    	                  	</td> 
											<td>';
										   
									        if ($site->totalPlots == 0) {
										        echo '<button onclick="beginDelete(\'action=delete&class=site&id=' . $site->site_id . '\',\'Do you want to remove this Site?\');" type="button" class="btn btn-danger btn-xs">
										            <span class="glyphicon glyphicon-remove-sign"></span>
										          </button>';
									        } else {
									        	echo '<span id="removeTooltip_' . $site->site_id . '" data-toggle="tooltip" data-placement="left" title="It has some Plots associated" class="label label-default">Better not</span>'; 
									        }

										    echo '</td>
									     </tr>';
		                  		}
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
          <h5>Total records <span class="badge"><?=$sites[0]->totalRecords?></span></h5>
       </div>
        <div class="col-xs-4 col-lg-4">
          <div class="text-center"> 
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($sites[0]->totalRecords % $siteData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($sites[0]->totalRecords / $siteData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="site-list.php?page=' . $newPage . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="site-list.php?page='. $i . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="site-list.php?page=' . $newPage . '">&raquo;</a></li>';
                  }

                }

              ?>
            </ul>
          </div>
        </div>
        <div class="col-xs-4 col-lg-4"></div>
      </div>
    </div>

    <script>
    <?php
	    foreach ($sites as $site) {
	    	if (isset($site->site_id) && $site->totalPlots > 0) {
		    	echo "$('#removeTooltip_" . $site->site_id . "').tooltip({trigger: 'hover'});";
		    	if ($site->totalPlots > 0) {
		    		echo "$('#accessTooltip_" . $site->site_id . "').tooltip({trigger: 'hover'});";
		    	}
	    	}
	    }
	?>
    </script>

  </body>
</html>