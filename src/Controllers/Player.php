<?php
/**
 * src/Controllers/Player.php
 * @author ADRAR - Sept. 2020
 * @version 1.0.0
 * Contrôleur pour l'affichage d'un joueur en particulier'
 */
require_once(__DIR__ . '/../Core/Controllers/Controller.php');
require_once(__DIR__ . '/../Repositories/PlayerRepository.php');

final class Player extends Controller {

    private $repository;

    public function __construct(){
        $this->view = __DIR__ . '/Views/player.view.php';
        
        // Instancier le dépot des données
        $this->repository = new PlayerRepository();
    }

    public function getRepository(): PlayerRepository{
        return $this->repository;
    }
}