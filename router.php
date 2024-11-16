<?php
    
    require_once 'libs/router.php';
    require_once 'app/controllers/game.api.controller.php';
    $router = new Router();

    #                 endpoint          verbo      controller             metodo
    $router->addRoute('game'      ,     'GET',     'GameApiController',   'GETList');
    $router->addRoute('game/:id'  ,     'GET',     'GameApiController',   'GETSingle');
    $router->addRoute('game/:id'  ,     'DELETE',  'GameApiController',   'DELETEGame');
    $router->addRoute('game'      ,     'POST',    'GameApiController',   'POSTGame');
    $router->addRoute('game/:id'  ,     'PUT',     'GameApiController',   'PUTGame');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);