<?php
/**
 * src/Http/Request.php
 * @author ADRAR - Sept. 2020
 * @version 1.0.0
 * Récupère les informations d'une requête HTTP
 */

 class Request{

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
     * @var array $requestParams
     * Collection des paramètres de la requête HTTP (QueryString)
     */
    private $requestParams;

    /**
     * @var array $requestURI
     * * URI qui a conduit jusqu'à  index.php
     */
    private $requestURI;

     /**
      *@var string $controlerName
      *Nom du contrôleur à instancier
      */
    private $controllerName;

    /**
      *@var string $controller
      *Nom de la classe à instancier
      */
    private $controller;

        /**
      *@var string $fallback
      *Controlleur par defaut a afficher si aucun controleur trouvé
      */
    private $fallback;


    
    public function __construct(string $fallback = null){

        $this->requestType = $_SERVER['REQUEST_METHOD'];
        $this->requestParams = $_GET;

        //On travaille avec des URI
        $this->requestURI = $_SERVER['REQUEST_URI'];
        $this->_traiterURI();

        $this->fallback = $fallback;
        $this->_setControllerName(); // défini le nom du fichier qui contient le contrôleur
    }

    public function getRequestMethod(): string {
        return $this->requestType;
    } 


    public function getRequestParams(): string{
        $output = '';
        foreach ($this->requestParams as $requestParam => $value){
            $output .= $requestParam . ' : ' . $value . ' <br>';
        }
        return $output;
    }

    public function getControllerName(){
        return $this->controllerName;
    }


    public function getController(): string{
        return $this->controller;
    }

    private function _setControllerName(){
        // if (array_key_exists('controller', $this->requestParams)){
        //     $name = $this->requestParams['controller']; // récupère la valeur associée à la clé controller
        //     $this->controllerName = ucfirst($name) . '.php';
        //     if (file_exists(__DIR__ . '/../../Controllers/' . $this->controllerName)){
        //         $this->controller = ucfirst($name);
        //     } else {
        //         $this->controllerName = 'NotFound.php'; // Fallback (par défaut, ce sera NotFound.php)
        //         $this->controller = 'NotFound';
        //     }
        // } else {
        //     if (!is_null($this->fallback)){
        //         $controllerName = $this->fallback . ".php";
        //         $controller = $this->fallback;
        //     } else {
        //         $controllerName = "NotFound.php";
        //         $controller = "NotFound";
        //     }
        //     $this->controllerName = $controllerName; // Fallback (par défaut, ce sera NotFound.php)
        //     $this->controller = $controller;
        // }
    }

    private function _traiterURI(){
        $laRoute = [];
        foreach ($this->routes as $route) {
            if ($this->requestURI === $route['path'] && $this->requestType === $route['httpmethod']){
                $laRoute = $route;
            break;
            }
        }
        // Si on a trouvé la route...
        if ($laRoute){
            $this->controllerName = $laRoute['controller'] . '.php';
            $this->controller = $laRoute['controller'];
            // Pauvre implémentation de la méthode à utiliser dans le controleur
            $_GET['method'] = $laRoute['method'];
        } else {
            if (!is_null($this->fallback)) {
                $this->controllerName = $this->fallback . ".php";
                $this->controller = $this->fallback;
            } else {
                $this->controllerName = "NotFound.php";
                $this->controller = "NotFound";
            } 
        }
    }
    
}