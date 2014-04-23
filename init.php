<?php

include 'config/database.php';

setlocale(LC_ALL, 'pt_PT.iso885915@euro');
setlocale(LC_ALL,'pt_PT');

$Database = new PDO($Config['database_host'], $Config['database_user'], $Config['database_password']);
$Database->exec("SET CHARACTER SET utf8");
$Database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$Database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 