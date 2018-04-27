<?php
 
// Define constantes com dados de acesso ao MySQL
define('DB_HOST', 'localhost');
define('DB_USER', 'holodroi_bares');
define('DB_PASS', '-Umpa$&56Lumpa8');
define('DB_NAME', 'holodroi_bares');

//define('DB_PASS', '');
//define('DB_NAME', 'holodroide');

 
// Habilita exibição de erros

ini_set('display_errors', true);
error_reporting(E_ALL);
 
// Inclui o arquivo de funçõees

require_once 'functions.php';