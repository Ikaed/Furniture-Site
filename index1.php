<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("./controllers/AdminController2.php");
include_once ("./models/AdminModel.php");

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate, no-store');
header('Expires: -1');


$queryString=$_SERVER["QUERY_STRING"];
$qsArray=explode("/",$queryString);
if(file_exists("./controllers/".$qsArray[0].".php")){
 $controller=new $qsArray[0]();
 echo $controller->{$qsArray[1]}($qsArray[2]); 
}
else{
$adminController=new AdminController2(); 
 echo $adminController->getFurniture();
}


?>