<?php

class GameModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=g51_x360_db;charset=utf8', 'root', '');
    }
 
    public function getGameList($rateFilter = null, $orderBy = false, $order = null) {
        $sql = 'SELECT * FROM game';

        // verifico si existe filtro
        if ($rateFilter != null) {
            switch($rateFilter) {
                case 'positive':
                    $sql .= ' WHERE vandal_rating >= 8';
                    break;
                case 'negative':
                    $sql .= ' WHERE vandal_rating <= 7';
                    break;
            }
        }
        // verifico si existe orden especifico
        if($orderBy) {
            switch($orderBy) {
                case 'titulo':
                    $sql .= ' ORDER BY title';
                    break;
                case 'año':
                    $sql .= ' ORDER BY year';
                    break;
                case 'clasificacion':
                    $sql .= ' ORDER BY pegi_class';
                    break;
            }
        }
        // verifico si el orden especifico es ascendente, descendente o nulo
        if ($orderBy && $order != null) {
            switch($order) {
                case 'asc':
                    $sql .= ' ASC';
                    break;
                case 'desc':
                    $sql .= ' DESC';
                    break;
            }
        }

        // una vez verificados los filtros y redactada la query la preparo y la ejecuto
        $query = $this->db->prepare($sql);
        $query->execute();
        // almaceno el resultado de la query en un arreglo del objetos
        $games = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $games;
    }
 
    public function getGameByid($id){
        // consulta por el juego
        $query_single_game = $this->db->prepare("SELECT * from game WHERE id_game = ?");
        // ejecucion de la sentencia
        $query_single_game->execute([$id]);
        // almaceno los datos del juego en un objeto
        $game = $query_single_game->fetch(PDO::FETCH_OBJ);

        return $game;
    }
 
    public function insertGame($title_id, $class, $title, $year, $genre, $devs, $rating, $thumbnail){
        // creo una sentencia que solicita variables y los convierte en texto para la query
        $query = $this->db->prepare("INSERT INTO `game`(`title_id`, `pegi_class`, `title`, `year`, `genre`, `devs`, `vandal_rating`, `thumbnail`) VALUES (?,?,?,?,?,?,?,?)");
        // reemplazo las variables faltantes por los parametros adjuntos en la ejecucion del metodo
        $query->execute([$title_id, $class, $title, $year, $genre, $devs, $rating, $thumbnail]);

        // solicito el id del objeto insertado
        $id = $this->db->lastInsertId();
        // devuelvo el id para la posterior respuesta
        return $id;

    }
 
    public function deleteGame($id){
        // declaro la sentencia que elimina el juego segun el id provisto
        $query_delete_game = $this->db->prepare("DELETE from game WHERE id_game = ?");
        // ejecucion y declaracion del id solicitado por la query
        $query_delete_game->execute([$id]);
    }

    public function editGame($id, $title_id, $class, $title, $year, $genre, $devs, $rating, $thumbnail){
        // declaro la sentencia que marca los parametros a actualizar
        $query = $this->db->prepare("UPDATE game SET `title_id`= ? , `pegi_class`= ? , `title`= ? , `year`= ? , `genre`= ? , `devs`= ? , `vandal_rating`= ? , `thumbnail`= ? WHERE id_game = ?");
        // ejecucion y declaracion de variables pendientes
        $query->execute([$title_id, $class, $title, $year, $genre, $devs, $rating, $thumbnail, $id]);
        return $query;
    }
}