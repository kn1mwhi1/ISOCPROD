<?php
	// index.php file
	include_once("controller/Controller.php");
	include_once("model/Model.php");
	include_once("view/View.php");

$model = new Model();
//It is important that the controller and the view share the model
$controller = new Controller($model);
$view = new View($controller, $model);
if (isset($_GET['action'])) $controller->{$_GET['action']}();
echo $view->output();
	
?>