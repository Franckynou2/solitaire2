<?php
/**
 * /index.php
 * @author Franckynou
 * @version 1.0.0
 * Point d'entrée de l'application PHP
 */
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once (__DIR__ . '/src/Core/Response/HtmlResponse.php');
require_once (__DIR__ . '/src/Core/Response/JsonResponse.php');
require_once (__DIR__ . '/src/Core/Response/Response.php');

// charger les fichiers contenant les classes utilisées
// require_once(__DIR__ . '/src/Controllers/Players.php');
// require_once(__DIR__ . '/src/Models/PlayerModel.php');
// require_once(__DIR__ . '/src/Repositories/PlayerRepository.php');
 require_once(__DIR__ . '/src/Core/Http/Request.php');
// require_once(__DIR__ . '/src/Core/Database/PDOMySQL.php');
// $connexion = new PDOMySQL();
// $connexion->connect();
 $config = json_decode(file_get_contents('./config.json'), false);
 // Créer une instance de l'objet Request
 
 $request = new Request();

 //require_once(__DIR__ . '/src/Controllers/' . $request->getControllerName());

 // $class = $request->getController();
 // $controller = new $class(); // soit :  new NotFound()  OU new Players() en fonction de la requête HTTP

// Appelle une méthode en particulier de ce contrôleur
// $controller->invoke();
 
// Retourne reponse HTTP
// $controller->sendResponse();

// Récupérer une "Réponse"
$response = $request->process();
echo ($response instanceof Response) ?