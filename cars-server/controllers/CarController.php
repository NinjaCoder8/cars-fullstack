<?php
include("../models/Car.php");
include("../connection/connection.php");
include("../services/ResponseService.php");

function getCars(){
    global $connection;
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $car = Car::find($connection, $id);
        echo ResponseService::response(200, $car->toArray());
    }else{
        // retrieve all cars
        $cars = Car::findAll($connection);
        $payload = [];
        foreach($cars as $car){
            $payload[] = $car->toArray();
        }
        echo ResponseService::response(200, $payload);
        return;
    }

    return;
}

function createCar(){
    global $connection;
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data)){
        if(isset($data['car'])){
            $newCarData = $data['car'];
            if (!isset($newCarData['name'], $newCarData['year'], $newCarData['color'])) {
                echo ResponseService::response(400, "Missing required car fields");
                return;
            }
            $insterted_id = Car::create($connection,$newCarData);
            echo ResponseService::response(200,$insterted_id);
        }else{
            echo ResponseService::response(401,"Missing car's data");
        }
    }else{
        echo ResponseService::response(401,"Bad http request");
    }
}

function updateCar(){
    global $connection;
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data)){
        if(isset($data['car'])){
            $updatedCarData = $data['car'];
            if(Car::update($connection,$updatedCarData)){
                echo ResponseService::response(200,$updatedCarData);
            }else{
                echo ResponseService::response(500,"Server error");
            }            
        }else{
            echo ResponseService::response(401,"Missing car's data");
        }
    }else{
        echo ResponseService::response(401,"Bad http request");
    }
}

function deleteCar(){
    global $connection;
    if(isset($_GET["id"])){
        $deleteId = $_GET["id"];
        if(Car::delete( $connection ,$deleteId)){
            echo ResponseService::response(200,$deleteId);
        }else{
            echo ResponseService::response(500,"Server error");
        }            
    }else{
        echo ResponseService::response(401,"Bad http request");
    }
}
?>