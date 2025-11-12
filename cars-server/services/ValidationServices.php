<?php 
class ValidationServices{


    public static function ValidateInputs(string $name,string $color,string $year){
        if(!is_string($name)||!is_string($color)||!is_string($year)){
            echo ResponseService::response(400, "Inputs must be strings");
             exit;
        }
        if(empty($name)||empty($color)||empty($year)){
            echo ResponseService::response(400,"Input Can not be empty");
             exit;
        }
         if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
    echo ResponseService::response(400, "Name can only contain letters and spaces in name input");
     exit;
         }
         if (!preg_match('/^\d{4}$/', $year)) {
    echo ResponseService::response(400, "Year must be exactly 4 digits");
       exit;
         } 
        }


     public static function testInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
    }
    public static function testId($id){
            if (empty($id) || !is_numeric($id)) {
        echo ResponseService::response(400, "ID is required and must be a number");
         exit;
}
    }

    }

?>