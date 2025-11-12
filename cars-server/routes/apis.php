<?php 

//array of routes - a mapping between routes and controller name and method!
$apis = [
    '/cars'         => ['controller' => 'CarController', 'method' => 'getCars'],
     '/cars/create'  => ['controller' => 'CarController', 'method' => 'createNewCar'],
    '/cars/update'  => ['controller' => 'CarController', 'method' => 'updateCurrentCar'],
     '/cars/delete'  => ['controller' => 'CarController', 'method' => 'deleteCurrentCar'],
    '/users'         => ['controller' => 'UserController', 'method' => 'getUsers']
];

