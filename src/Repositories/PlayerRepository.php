<?php
/**
 * src/Repositories/PlayerRepository.php
 * @author Franckynou - Sept. 2020
 * @version 1.0.0
 * Collectionne l'ensemble des joueurs de Solitaire
 */

require_once(__DIR__ . '/../Models/PlayerModel.php');
require_once(__DIR__ . '/../Core/Database/PDOMySQL.php');
require_once(__DIR__ . '/../Core/Database/Repository/Repository.php');

 class PlayerRepository extends Repository{

     public function __construct(){
        //Appeler explicitement le constructeur de la classe parente
        parent::__construct(substr(get_class($this), 0, strpos(get_class($this),'Repository')));
     }

     /**
      * Override
      * @see Repositry::findAll()
      */
     public function findAll(): array{
         $results = parent::findAll();

         foreach ($results as $row){
            $player = new PlayerModel();
            $player->setId($row['id']);
            $player->setName($row['name']);
            $player->setTime(\DateTime::createFromFormat('H:i:s', $row['time']));
            $this->repository[] = $player;
        }
        return $this->repository;
     }

     /**
      * Override
      * @see Repositry::findById()
      */
    public function findById(int $id): PlayerModel {
        $result = parent::findById($id);
        $player = new PlayerModel();
        $player->setId($result['id']);
        $player->setName($result['name']);
        $player->setTime(\DateTime::createFromFormat('H:i:s', $result['time']));
        return $player;
    }

    public function findByName(string $name): PlayerModel {
        $model = null;

        foreach ($this->repository as $playerModel){
            if ($playerModel->getName() === $name){
                $model = $playerModel;
            }
        }
        return $model;
    }

    public function save(): PlayerModel {
        // Récupérer les données du "frontend"
        $input = json_decode(file_get_contents('php://input'));

        $sqlQuery = 'INSERT INTO ' . $this->table . '(';
        foreach($this->cols as $col){
            $sqlQuery .= $col . ',';
        }
        // Ne pas oublier d'enlever la derniere virgule
        $sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 1);

        // Continuer la requete
        $sqlQuery .= ') VALUES (';
        foreach($this->cols as $col){
            $sqlQuery .= ':' . $col . ',';
        }

        // Ne pas oublier d'enlever la derniere virgule
        $sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 1);

        //Terminer la requetes
        $sqlQuery .= ');';
        //Affecter les valeurs à chaque placeholder
        $values = [];
        foreach ($this->cols as $col) {
            if ($col === 'id'){
                $values[$col] = null;
            } else {
                $values[$col] = $input->{$col};
            }
        }

        // Le tableau sera :
        // ['id' => , 'name' => "casper le fantome", 'time' => '00:12:45']
        $statement = $this->db->prepare($sqlQuery);
        $statement->execute($values);

        return new PlayerModel();
    }

 }
 