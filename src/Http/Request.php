<?php
/**
 * src/Http/Request.php
 * @author Franckynou - Sept 2020
 * @version 1.0.0
 * Récupère les informations d'une requête HTTP
 */ 
require_once(__DIR__ . './../../Controllers/NotFound.php');
require_once(__DIR__ . './../../Controllers/Player.php');
require_once(__DIR__ . './../../Controllers/Players.php');

class Request {
    /**
     * @var array $routes 
     * Contient les "routes" de l'application
      */
      private $routes = [
          [
            'path' => '/players',
            'httpmethod' => 'GET',
            'controller' => 'Players',
            'method' => 'bestof'
          ],
          [
            'path' => '/players',
            'httpmethod' => 'POST',
            'controller' => 'Players',
            'method' => 'addPlayer'
          ]
      ];
    
    /**
     * @var string $requestType
     * Type de la requête HTTP : GET | POST | PUT | DELETE | PATCH
     */
    private $requestType;

    /**
     * @var array $requestParam
     * Collection des paramètres de la requête HTTP (QueryString)
     */
    private $requestParam;

    /**
     * @var string $controllerName*
     * Nom du contrôleur à instancier
     */
    private $controllerName;

    /**
     * @var string $controller
     * Nom de la classe à instancier
     */
    private $controller;

    
    /**
    * @var string $fallback
    * contrôleur par défaut à afficher si aucun n'a été trouvé
    */
    private $fallback;
    
    /**
    * @var string $requestURI
    * URI qui a conduit jusqu'à l'index.php
    */
    private $requestURI;
    
    /**
    * @var array $route
    * Contient les vroum vroum de l'app
    */
    private $routes=[
        [
            'path'=>'/players',
            'httpMethod'=>'GET',
            'controller'=>'Players',
            'method'=>'bestOf'
        ],
        [
            'path'=>'/players',
            'httpMethod'=>'POST',
            'controller'=>'Players',
            'method'=>'addPlayer'
        ]
    ];
    
        
        
    public function __construct(string $fallback = null) {
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        $this->requestParams = $_GET;
        
        $this->requestURI = $_SERVER['REQUEST_URI'];
        $this->_traiterURI();
        
        $this->fallback = $fallback;
        
    //    $this->_setControllerName(); // Définit le nom du fichier qui contient le contrôleur
    }

    public function getRequestMethod(): string {
        return $this->requestType;
    }

    public function getRequestParams(): string {
        $output = '';

        foreach ($this->requestParams as $requestParam => $value) {
            $output .= $requestParam . ' : ' . $value . '<br>';
        }
        return $output;
    }

    public function getControllerName(): string {
        return $this->controllerName;
    }

    public function getController(): string {
        return $this->controller;
    }

    private function _setControllerName() {
        if (array_key_exists('controller', $this->requestParams)) {
            $name = $this->requestParams['controller'];
            $this->controllerName = ucfirst($name) . '.php';
            if (file_exists(__DIR__ . '/../Controllers/' . $this->controllerName)) {
                $this->controller = ucfirst($name);
            } else {
                $this->controllerName = 'NotFound.php';
                $this->controller = 'NotFound';
            }
        } else{
            if (!is_null($this->fallback)) {
                $controllerName= $this->fallback . ".php";
                $controller = $this->fallback;
            } else {
                $controllerName = "NotFound.php";
                $controller = "NotFound";
            }
            $this->controllerName = $controllerName; //Fallback par défaut
            $this->controller = $controller;
        }
    }
    
    private function _traiterURI():Controller{
        $laRoute=null;
        foreach($this->routes as $route) {
            if($this->requestURI === $route['path'] && $this->requestType === $route['httpMethod']){
                $laRoute=$route;
                die;
            }
        }
        // Sisi la route 66
        if($laRoute){
            $this->controllerName = $laRoute['controller'] .'.php';
            $controller = $laRoute['controller'];
            $_GET["method"] = $laRoute['method'];
        } else {
            if (!is_null($this->fallback)) {
                $this->controllerName = $this->fallback . ".php";
                $controller = $this->fallback;
            } else{
                $this->controllerName = "NotFound.php";
                $controller = "NotFound";
            }
        }
        
        require_once(__DIR__ './../../Controllers/' . $this->controllerName);
        return new $controller();
    }
    
    public function process() {
        return $this->controller->invoke();
    }
}
