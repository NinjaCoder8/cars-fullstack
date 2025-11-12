<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");

function getCars(){
    global $connection;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $car = Car::find($connection, $_GET["id"]);
    echo ResponseService::response(200, $car->toArray());
    return;
    }else{
        $car=Car::findAll($connection);
        $allcars=[];
        foreach($car as $row){
           $allcars[]=$row->toArray();
        }
    echo ResponseService::response(200,$allcars);
    return;
    }

    
}

//getCarById();
//getCars();

function insertCar(string $name, string $color, string $year){
    global $connection;
     Car::create($connection,$name, $color, $year);
    echo ResponseService::response(200,"Table Created");
}

//insertCar('tesla','black','2010');


   function updateCar(string $name, string $color, string $year){
    global $connection;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    Car::update($connection,$id,$name,$color,$year);
    echo ResponseService::response(200,"Row is Updated");
}
//updateCar("jeep", "white", "2000");

function deleteCar(){
    global $connection;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    Car::delete($connection, $id);
    echo ResponseService::response(200,"row is Deleted");
}
//deleteCar();
//ToDO: 
//transform getCarByID to getCars()
//if the id is set? then we retrieve the specific car 
// if no ID, then we retrieve all the cars


?>