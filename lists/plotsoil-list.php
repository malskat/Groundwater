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
  </head>

  <body>

    <?php


  		if ($_BIOLOGYST_LOGGED === false) {
  			header('Location: ' . PROJECT_URL . 'index.php?response=-1');
  			die;
  		}

		require_once '../data/campaign_data.php';
  		$campaignData = new Campaign();
    	$campaigns = $campaignData->getCampaigns(-1);

		$plotSoils = array();
		$fields = array();
		$backUrl = "";
		$insertUrl = "/lists/plot-list.php";
		$subtitle = "No soil samples";

		if(isset($_GET["plot"]) && $_GET["plot"] != "") {

	  		include "../data/plotsoil_data.php";
	  		$plotSoilData = new PlotSoil();

	  		$whereClause = 'ps.plot_id = "' . $_GET['plot'] . '"';

	  		if (isset($_GET["campaign"])) {
				$whereClause .= "and ps.sampling_campaign_id = " . $_GET["campaign"];
			}

	  		$plotSoils = $plotSoilData->getPlotSoilBy($whereClause, (isset($_GET["page"]) ? $_GET["page"] : 0));
	  		$fields = $plotSoilData->getFieldList();
			
			$insertUrl = "../forms/plotsoil.php?plot=" . $_GET["plot"];
		} 

		if (count($plotSoils) > 1) {
  			$subtitle = 'for ' . $plotSoils[1]->siteTitle . ' ' .  $plotSoils[1]->plotCode;
  		} else {
			include "../data/plot_data.php"; 

  			$plotData = new Plot();
			$plot = $plotData->getPlotBy("plot_id = " . $_GET["plot"], -1);
  			$subtitle = 'for ' . $plot[0]->title . ' ' .  $plot[0]->code;
  		}


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
         		Plot Soil Samples
				<small><?=$subtitle?></small>
         	</h2>
         	
        </div>
      </div>
    </div>


    <!-- barra de accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-2 col-lg-4">
			<button class="btn btn-link" onclick="location.href='<?=$backUrl?>'">« back</button>
		</div>

		<div class="col-xs-6 col-lg-4">
			<form  class="form-inline" role="form" name="form_searchplotsoil_data" action="../core/core_action.php" method="post">
            	<input type="hidden" value="search" name="action">
            	<input type="hidden" value="plotsoil" name="class">
            	<input type="hidden" value="<?=$_GET['plot']?>" name="plot">
            	<div class="form-group">
            		<select name="campaign" class="form-control input-sm">
						<option value="none">Campaign</option>
						<?php
							foreach($campaigns as $campaign){
								echo '<option ' . (isset($_GET["campaign"]) && $campaign->sampling_campaign_id == $_GET["campaign"] ? 'selected' : '') . ' value="' . $campaign->sampling_campaign_id . '">' . $campaign->designation . '</option>';
							}
						?>
					</select>
            	</div>
            	<button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
        	</form>
		</div>


        <div class="col-xs-6 col-lg-4"> 
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='<?=$insertUrl?>'">Insert Soil Sample</button>
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
            	if (count($plotSoils) > 1) {
	                foreach ($plotSoils as $plotSoil) {
	                	if(isset($plotSoil->plot_soil_id)){
		                    echo '<tr>			                        
			                        <td>' . (isset($plotSoil->measureDate) && $plotSoil->measureDate != "0000-00-00" ? $plotSoil->measureDate : 'N.D.') . '</td>
			                        <td>' . $plotSoil->campaignDesignation . '</td>
			                        <td>' . $plotSoil->soilCode . '</td>
			                        <td>' . (isset($plotSoil->soil_18o_10) && $plotSoil->soil_18o_10 != "" ? $plotSoil->soil_18o_10 : 'N.D.') . '</td>
			                        <td>' . (isset($plotSoil->soil_18o_30) && $plotSoil->soil_18o_30 != "" ? $plotSoil->soil_18o_30 : 'N.D.') . '</td>
			                        <td>' . (isset($plotSoil->soil_18o_50) && $plotSoil->soil_18o_50 != "" ? $plotSoil->soil_18o_50 : 'N.D.') . '</td>
			                        <td>' . (isset($plotSoil->soilWaterContent) && $plotSoil->soilWaterContent != "" ? $plotSoil->soilWaterContent : 'N.D.') . '</td>
			                        <td>' . $plotSoil->creation_date	 . '</td>';

		                          	echo '<td>
			                            	<button onclick="location.href=\'../forms/plotsoil.php?id=' . $plotSoil->plot_soil_id . '\'" type="button" class="btn btn-primary btn-xs">
			                                	<span class="glyphicon glyphicon glyphicon-edit"></span>
			                            	</button>
			                            </td>
		                       			<td>
								        	<button onclick="beginDelete(\'action=delete&class=plotsoil&id=' . $plotSoil->plot_soil_id . '\',\'Do you want to remove this Plot Soil Sample?\');" type="button" class="btn btn-danger btn-xs">
								            <span class="glyphicon glyphicon-remove-sign"></span>
								          </button>
							        	</td>
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
          <h5>Total records <span class="badge"><?=$plotSoils[0]->totalRecords?></span></h5>
        </div>
        <div class="col-xs-4 col-lg-4"> 
          <div class="text-center">
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($plotSoils[0]->totalRecords % $plotSoilData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($plotSoils[0]->totalRecords / $plotSoilData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="plotsoil-list.php?page=' . $newPage . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="plotsoil-list.php?page='. $i . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="plotsoil-list.php?page=' . $newPage . '">&raquo;</a></li>';
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

  </body>
</html>