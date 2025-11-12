<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ ."/../services/ValidationServices.php");


//This function will return all cars if no  passed id and specific car if id was passed
class CarController{
function getCars(){
    global $connection;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $car = Car::find($connection, $id);
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
/*
//I comment the other functions because first I did the assignment in this way by giving the functions the name of db columns
// then I implemented it as Charbel asks us during the meeting
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
*/

function createNewCar(){
    global $connection;

  
   $name  = $_GET['name']  ?? '';
    $color = $_GET['color'] ?? '';
    $year  = $_GET['year']  ?? '';
     
     $name  = ValidationServices::testInput($name);
    $color = ValidationServices::testInput($color);
    $year  = ValidationServices::testInput($year);
    ValidationServices::ValidateInputs($name, $color, $year);

    Car::create($connection, ['name' => $name, 'color' => $color, 'year' => $year]);
    echo ResponseService::response(200,"car created");
}

//createNewCar();
  function updateCurrentCar(){
       global $connection;
       $id=$_GET['id']??'';
       $name=$_GET['name'] ??'';
       $color=$_GET['color'] ?? '';
       $year=$_GET['year'] ?? '';
    
    $name  = ValidationServices::testInput($name);
    $color = ValidationServices::testInput($color);
    $year  = ValidationServices::testInput($year);
    ValidationServices::ValidateInputs($name, $color, $year);
    Car::update($connection, $id, ['name' => $name,'color' => $color,'year' => $year]);
         echo ResponseService::response(200,"car updated");
        }

//updateCurrentCar();
function deleteCurrentCar(){
       global $connection;
       $id=$_GET['id'];
Car::delete($connection, $id);
}
//deleteCurrentCar();

}

?>