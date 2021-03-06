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
  		if ($_BIOLOGYST_LOGGED === false || array_search('user', $_BIOLOGYST_LOGGED['userInfo']['permissions']) === false) {
  			header('Location: ' . PROJECT_URL . 'index.php?response=' . ($_BIOLOGYST_LOGGED === false ? '-1' : '-8' ));
  			die;
  		}

  		require_once "../data/user_data.php";

  		$userData = new User();
  		$users = array();
	    $whereClause = "";
	    $getParameters = "";

  		if(isset($_GET["nameEmail"])){

			$whereClause = " upper(b.first_name) like upper('%" . $_GET["nameEmail"] . "%') 
							or upper(b.last_name) like upper('%" . $_GET["nameEmail"] . "%') 
							or upper(b.email) like upper('%" . $_GET["nameEmail"] . "%')";

		   	$getParameters = "nameEmail=" . $_GET["nameEmail"];
			$users = $userData->getUserBy($whereClause, (isset($_GET["page"]) ? $_GET["page"] : 0));

		} else {
  			$users = $userData->getUsers(isset($_GET["page"]) ? $_GET["page"] : 0); 
  		}
  		
  		$fields = $userData->getFieldList();
  	?>
  	
    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <!-- titulo -->
    <div class="container">
      <div class="row">
      	<div class="page-header">
         	<h1>Users</h1>
        </div>
      </div>
    </div>


    <!-- barra de accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10">
        	<form  class="form-inline" role="form" name="form_searchindividual_data" action="../core/core_action.php" method="post">
            	<input type="hidden" value="search" name="action">
            	<input type="hidden" value="user" name="class">
	            <div class="form-group">
	              <input type="text" class="form-control input-sm" name="nameEmail" placeholder="Name or Email" value=<?= (isset($_GET["nameEmail"]) ? '"' . $_GET["nameEmail"] . '"' : "") ?>>
	            </div>
	            <button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
	        </form>
        </div>
        <div class="col-xs-6 col-lg-2"> 
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/user.php'">Insert User</button>
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
                foreach ($users as $user) {
                	if(isset($user->biologyst_id)){
	                    echo '<tr>
		                        <td>' . $user->biologyst_id . '</td>
		                        <td>' . $user->first_name . ' ' .  $user->last_name . ' </td>
		                        <td>' . $user->email . '</td>
		                        <td>' . $user->creation_date . '</td>
		                        <td>' . (isset($user->last_login) ? $user->last_login : '--')  . '</td>
		                       	<td>
	                            	<button onclick="location.href=\'../forms/user.php?user_id=' . $user->biologyst_id . '\'" type="button" class="btn btn-primary btn-xs">
	                                	<span class="glyphicon glyphicon glyphicon-edit"></span>
	                            	</button>
	                            </td>
	                       		<td>
							    	<button onclick="beginDelete(\'action=delete&class=user&id=' . $user->biologyst_id . '\', \'Do you want to remove this User?\');" type="button" class="btn btn-danger btn-xs">
							            <span class="glyphicon glyphicon-remove-sign"></span>
							          </button>
						      	</td>
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
          <h5>Total records <span class="badge"><?=$users[0]->totalRecords?></span></h5>
        </div>
        <div class="col-xs-4 col-lg-4"> 
          <div class="text-center">
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($users[0]->totalRecords % $userData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($users[0]->totalRecords / $userData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="user-list.php?page=' . $newPage . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="user-list.php?page='. $i . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="user-list.php?page=' . $newPage . '">&raquo;</a></li>';
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