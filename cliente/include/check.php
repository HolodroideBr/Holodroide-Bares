<?php
 
require_once 'init.php';
 
if (!CliIsLoggedIn())
{
    header('Location: index.php');
}