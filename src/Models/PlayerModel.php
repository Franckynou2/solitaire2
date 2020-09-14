<?php
/**
 * src/Models/PlayerModel.php
 * @author Franckynou - Sept. 2020
 * @version 1.0.0
 * Modèle de stockage des informations relatives aux joueurs 
 */

 class PlayerModel{

    /**
      * @var int $id
      * id du joueur
      */
      private $id;

     /**
      * @var string $name
      * Nom du joueur
      */
     private $name;

     /**
      * @var \DateTime $time
      * Temps mis pour finaliser la partie
      */
     private $time;


     public function __construct() {}

     public function getId(){
         return $this->id;
     }

     public function setId(int $id){
         $this->id = $id;
     }

     public function setName(string $name){
        $this->name = $name;
    }

     public function getName(): string{
         return $this->name;
     }

     public function setTime(\DateTime $time){
        $this->time = $time;
    }

    public function getTime(){
        return $this->time->format('D-m-Y H:i:s');
    }

    public function getCols(): array{
        $cols = [];

        foreach ($this as $property => $value) {
            $cols[] = $property;
        }
        return $cols;
        
    }

 }