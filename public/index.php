
<?php
require_once("../Core/Router.php");


$url = $_SERVER["QUERY_STRING"];

//Instanciation de la class Router
$router = new Router();

//Ajout des formats de routes qu'on accepte
// $router->add('', ['controller' => 'HomeController', 'action' => 'viewHome']);
$router->add("{controller}~{action}");
// $router->add("admin~{controller}~{action}");
// $router->add("admin/{controller}/{id:\d+}/{action}");
// $router->add("{controller}/{id:\d+}/{action}");
// $router->add("{controller}/{bookname}/{action}");
// $router->add("{controller}/{username:\w+\d+}/{action}");
// $router->add("{controller}/{name:[a-zA-Z-\-]+\d+}/{action}");
// $router->add("{controller}/{id:\d+}/{books}/{action}");

// var_dump($router->match($url));
$router->dispatch($url);
// var_dump($router->getmatch($url));

// echo"<pre>";
// var_dump($router->getadd($url));
// echo"</pre>";

?>
