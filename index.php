<?php
require 'vendor/autoload.php';

//ROUTING
$page = "home";
if(isset($_GET['p'])){
	$page = $_GET['p'];
}

function loadData(){
    $pdo = new PDO('mysql:dbname=frame;host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $tutoriels = $pdo->query("SELECT * FROM articles");
}
$tutoriels = loadData();
//TWIG
$loader = new Twig_Loader_Filesystem(__DIR__ .'/template');
$twig = new Twig_Environment($loader,[
    //'cache' => __DIR__ .'/tmp'
]);
//Pour afficher une fonction
$twig->addFunction(new Twig_SimpleFunction('markdom', function($value){
    return  "Je ne comprends pas le mot" .$value;
}));
switch($page){
    case 'contact':
        echo $twig->render('contact.twig', compact('tutoriels'));
        break;
    case 'home':
        echo $twig->render('home.twig');
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
        break;
}