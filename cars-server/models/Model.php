<?php
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $connection, int $id){
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
                       static::$table,
                       static::$primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function findAll(mysqli $connection){
        //implement this
        $sql=sprintf("SELECT * FROM %s",
                     static::$table,
                     static::$primary_key);
      
         $query=$connection->prepare($sql);
         $query->execute();
         $data=$query->get_result()->fetch_all(MYSQLI_ASSOC);
         $cars=[];
         foreach($data as $row){
            $cars[]=new static($row);

         }  
         return $cars;      
    }

    public static function create(mysqli $connection,string $name, string $color, string $year){
        $sql = sprintf("INSERT INTO %s (name,color,year) VALUES (?,?,?)",
                        static::$table);
        $query = $connection->prepare($sql);
        $query->bind_param("sss",$name,$color,$year);
        $query->execute();
        
    }

     public static function update(mysqli $connection, int $id,string $name, string $color , string $year){
        $sql = sprintf("UPDATE %s SET  name = ?, color = ?, year = ?   WHERE %s = ?",
                        static::$table,
                        static::$primary_key);
        $query = $connection->prepare($sql);
        $query->bind_param("sssi",$name,$color,$year, $id);
        $query->execute();
    }
          
      public static function delete(mysqli $connection, int $id){
        $sql = sprintf("DELETE FROM %s WHERE %s = ?",
                static::$table,
                static::$primary_key);
        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();
      
    }
}

