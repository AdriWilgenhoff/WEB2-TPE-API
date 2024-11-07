<?php
    
    require_once 'libs/router.php';

    require_once 'app/controllers/attractions.api.controller.php';
    require_once 'app/controllers/user.api.controller.php';
    require_once 'app/middlewares/jwt.auth.middleware.php';
    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    #                 endpoint        verbo      controller              metodo
    $router->addRoute('atraccion'      ,            'GET',     'AttractionApiController',   'getAll');
    $router->addRoute('atraccion/:id'  ,            'GET',     'AttractionApiController',   'getByID'   );
    $router->addRoute('atraccion/:id'  ,            'DELETE',  'AttractionApiController',   'delete');
    $router->addRoute('atraccion'  ,                'POST',    'AttractionApiController',   'create');
    $router->addRoute('atraccion/:id'  ,            'PUT',     'AttractionApiController',   'update');
    $router->addRoute('atraccion/:id/finalizada'  , 'PUT',     'AttractionApiController',   'setFinalize');
    
    $router->addRoute('user/token'    ,            'POST',     'UserApiController',   'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);