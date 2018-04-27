<?php
 
// Conecta com o MySQL usando PDO

function db_connect()
{
    $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
 
    return $PDO;
}
 
 
// Cria o hash da senha, usando MD5 e SHA-1

function make_hash($str)
{
    return sha1(md5($str));
}
 
 
function UsrIsLoggedIn()
{
    if (!isset($_SESSION['usr_logged']) || $_SESSION['usr_logged'] !== true)
    {
        return false;
    }
 
    return true;
}


// Retira acentuação e espaços do nome para compor url de redirect
function retiraAcentos($string){
 $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
 $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
 $string = strtolower(strtr($string, utf8_decode($acentos), $sem_acentos));
 $string = str_replace(" ","-",$string);
 return utf8_decode($string);
}
             