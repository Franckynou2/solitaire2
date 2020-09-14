<?php
/**
 * src/Core/Database/Repository/Repository
 *  Abstraction de Repository
 */

 abstract class Repository {
    protected $cols;

    protected $table;

    protected $db;

    /**
     * @var string $modelClass
     * Contient le nom de la classe du modèle à traiter
     */
    private $modelClass;

    /**
    * @var array $repository
    * Tableau qui contient l'ensemble des objetts PlayerModel
    */
    protected $repository;

    protected $byId;

     public function __construct(string $model){

        // Connexion
        $connexion = new PDOMySQL();
        $connexion->connect();
        $this->db = $connexion->getInstance();

        $this->modelClass = $model . 'Model';

        //requiert le fichier qui contient la classe du modèle à traiter
        require_once(__DIR__ . '/../../../Models/' . $this->modelClass . '.php');
        $instance = $this->modelClass;
        $modelInstance = new $instance();// i.e new PlayerModel();
        
        $this->repository = []; // Initialise le repository

        // récupérer les colonnes
        $this->cols = $modelInstance->getCols();

        $this->table = strtolower($model);
        $this->byId = $this->db->prepare('SELECT ' . implode(',', $this->cols) . ' FROM ' . $this->table . ' WHERE id = :id;');
     }

     public function getRepository(): array{
        return $this->repository;
    }


     public function findAll(){
        $sqlQuery = 'SELECT ' . implode(',', $this->cols) . ' FROM ' . $this->table . ';';
        $results = $this->db->query($sqlQuery);
        return $results;
     }

     public function findById(int $id){
        $this->byId->execute(['id' => $id]);
        $result = $this->byId->fetch(); //Récupère le seul et unique résultat
        
        return $result;
     }
 }