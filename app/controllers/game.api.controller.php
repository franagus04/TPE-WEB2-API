<?php
require_once './app/models/game.model.php';
require_once './app/views/json.view.php';

class GameApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new GameModel();
        $this->view = new JSONView();
    }

    // /api/game
    public function GETList($req) {

        $rateFilter = null;
        if(isset($req->query->rate)) {
            $rateFilter = $req->query->rate;
        }
        
        $orderBy = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }

        $order = null;
        if(isset($req->query->order)) {
            $order = $req->query->order;
        }
        
        // guardo los juegos en una variable mediante la ejecucion de un llamado a la db
        $games = $this->model->getGameList($rateFilter, $orderBy, $order);
        
        // mando los juegos a la vista
        return $this->view->response($games);
    }

    // /api/game/:id
    public function GETSingle($req) {
        // obtengo el id de el juego desde la ruta
        $id = $req->params->id;

        // obtengo el juego de la DB
        $game = $this->model->getGameByid($id);

        if(!$game) {
            return $this->view->response("El juego con el id: $id no existe", 404);
        }

        // mando el juego a la vista
        return $this->view->response($game);
    }

    // api/game/:id (DELETE)
    public function DELETEGame($req, $res) {
        $id = $req->params->id;

        $game = $this->model->getGameByid($id);

        if (!$game) {
            return $this->view->response("El juego con el id: $id no existe", 404);
        }

        $this->model->deleteGame($id);
        $this->view->response("El juego con el id: $id se eliminó con éxito");
    }

    // api/game (POST)
    public function POSTGame($req) {

        // valido los datos
        if (empty($req->body->title_id) || empty($req->body->pegi_class) || empty($req->body->title) || empty($req->body->year) || empty($req->body->genre) || empty($req->body->devs) || empty($req->body->vandal_rating) || empty($req->body->thumbnail)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $title_id = $req->body->title_id;       
        $class = $req->body->pegi_class;       
        $title = $req->body->title;
        $year = $req->body->year; 
        $genre = $req->body->genre; 
        $devs = $req->body->devs; 
        $rating = $req->body->vandal_rating; 
        $thumbnail = $req->body->thumbnail;

        // inserto el objeto enviando las variables con datos como paramentros y almaceno su id en una variable
        $id = $this->model->insertGame($title_id, $class, $title, $year, $genre, $devs, $rating, $thumbnail);

        // controlo errores de insercion 
        if (!$id) {
            return $this->view->response("Error al insertar juego", 500);
        }

        // Devuelvo el recurso como respuesta
        $game = $this->model->getGameByid($id);
        return $this->view->response($game, 201);
    }

    // api/game/:id (PUT)
    public function PUTGame($req, $res) {
        //almaceno al id del juego
        $id = $req->params->id;

        // verifico que exista
        $game = $this->model->getGameByid($id);
        if (!$game) {
            return $this->view->response("El juego con el id: $id no existe", 404);
        }

        // valido los datos
        if (empty($req->body->title_id) || empty($req->body->pegi_class) || empty($req->body->title) || empty($req->body->year) || empty($req->body->genre) || empty($req->body->devs) || empty($req->body->vandal_rating) || empty($req->body->thumbnail)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // almaceno los datos en variables representativas
        $title_id = $req->body->title_id;       
        $class = $req->body->pegi_class;       
        $title = $req->body->title;
        $year = $req->body->year; 
        $genre = $req->body->genre; 
        $devs = $req->body->devs; 
        $rating = $req->body->vandal_rating; 
        $thumbnail = $req->body->thumbnail;

        // actualiza el juego
        $this->model->editGame($id, $title_id, $class, $title, $year, $genre, $devs, $rating, $thumbnail);

        // obtengo el juego modificada y la devuelvo en la respuesta
        $game = $this->model->getGameByid($id);
        $this->view->response($game, 200);
    }

}

