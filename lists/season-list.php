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
  </head>

  <body>

    <?php
  		include "../data/season_data.php";

  		$seasonData = new Season();
  		$seasons = $seasonData->getSeasons(isset($_GET["page"]) ? $_GET["page"] : 0, $withTotalCampaigns = 1); 
  		$fields = $seasonData->getFieldList();
  	?>
  	
    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <!-- titulo -->
    <div class="container">
      <div class="row">
      	<div class="page-header">
         	<h1>Seasons</h1>
        </div>
      </div>
    </div>


    <!-- barra de accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10"></div>
        <div class="col-xs-6 col-lg-2"> 
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/season.php'">Insert Season</button>
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
            	if (count($seasons) > 1) {
	                foreach ($seasons as $season) {
	                	if(isset($season->season_id)){
		                    echo '<tr>
			                        <td>' . $season->season_id . '</td>
			                        <td>' . $season->code . '</td>
			                        <td>' . $season->startDate . '</td>
			                        <td>' . $season->endDate . '</td>';

			                        if ($season->totalCampaigns > 0) {
		                          		echo '<td><a href="campaign-list.php?season=' . $season->season_id .  '"><span id="accessTooltip_' . $season->season_id . '" data-toggle="tooltip" data-placement="left" title="Click to see campaigns" class="label label-default">' . $season->totalCampaigns . '</span></a>';
			                        } else {
			                        	echo '<td><span class="label label-default">' . $season->totalCampaigns . '</a>';
			                        }

		                          	echo '</td>
			                       	<td>
		                            	<button onclick="location.href=\'../forms/season.php?season_id=' . $season->season_id . '\'" type="button" class="btn btn-primary btn-xs">
		                                	<span class="glyphicon glyphicon glyphicon-edit"></span>
		                            	</button>
		                            </td>
		                       		<td>';

							        if ($season->totalCampaigns == 0) {
								        echo '<button onclick="beginDelete(\'action=delete&class=season&id=' . $season->season_id . '\',\'Do you want to remove this season?\');" type="button" class="btn btn-danger btn-xs">
								            <span class="glyphicon glyphicon-remove-sign"></span>
								          </button>';
							        } else {
							        	echo '<span id="removeTooltip_' . $season->season_id . '" class="label label-default" data-toggle="tooltip" data-placement="left" title="It has campaigns associated">Better not</span>'; 
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
          <h5>Total records <span class="badge"><?=$seasons[0]->totalRecords?></span></h5>
        </div>
        <div class="col-xs-4 col-lg-4"> 
          <div class="text-center">
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($seasons[0]->totalRecords % $seasonData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($seasons[0]->totalRecords / $seasonData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="season-list.php?page=' . $newPage . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="season-list.php?page='. $i . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="season-list.php?page=' . $newPage . '">&raquo;</a></li>';
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
	    foreach ($seasons as $season) {
	    	if (isset($season->season_id) && $season->totalCampaigns > 0) {
		    	echo "$('#removeTooltip_" . $season->season_id . "').tooltip({trigger: 'hover'});";
		    	if ($season->totalCampaigns > 0) {
		    		echo "$('#accessTooltip_" . $season->season_id . "').tooltip({trigger: 'hover'});";
		    	}
	    	}
	    }
	?>
    </script>

  </body>
</html>