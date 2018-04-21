<?php
require 'vendor/autoload.php';
require 'MonExtension.php';

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

//Pour créer une fonction
/*$twig->addFunction(new Twig_SimpleFunction('markdom', function($value){
    //Affiche les balises html renvoyées par la bdd
    return \Michelf\MarkdownExtra::defaultTransform($value);
    //elle peut être utiliser de la sorte markmom({{tutoriel.name}})
}, ['is_safe' => ['html']]));

//Pour créer un filter
$twig->addFilter(new Twig_SimpleFilter('mardom', function($value){
    return \Michelf\MarkdownExtra::defaultTransform($value);
    //elle peut être utiliser de la sorte {{tutoriel.name | markdowm}}
}));*/
$twig->addExtension(new MonExtension());
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