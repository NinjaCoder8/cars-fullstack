<?php
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $connection, string $id){
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

//I comment the other functions because first I did the assignment in this way by giving the functions the name of db columns
// then I implemented it as Charbel asks us during the meeting
//They are implemented down below the commented functions



  /*  public static function create(mysqli $connection,string $name, string $color, string $year){
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
      
    }*/
        public static function getTypes($data){
            $types='';
            foreach ($data as $value) {
            if (is_int($value)) $types .= 'i';
            elseif (is_float($value)) $types .= 'd';
            elseif (is_string($value)) $types .= 's';
            else $types .= 'b';}
            return $types; 

        }
        public static function create(mysqli $connection, array $data){
        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        $sql = sprintf( "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(',', $columns),
            $placeholders);   
        $stmt = $connection->prepare($sql);     
        $types = self::getTypes($values);
        $stmt->bind_param($types, ...$values);     
        $query = $stmt->execute();
        return $query;
    }

    public static function update(mysqli $connection, int $id, array $data){
    $columns = array_keys($data);
    $values = array_values($data);
    $set_clause = implode(' = ?, ', $columns) . ' = ?';
    $sql = sprintf( "UPDATE %s SET %s WHERE %s = ?",
        static::$table,
        $set_clause,
        static::$primary_key
    );
    $stmt = $connection->prepare($sql);
    $types = self::getTypes($values);
   $types .= 'i';
   $values[] = $id;
    $stmt->bind_param($types, ...$values);
    $query = $stmt->execute();
    return $query;
}
   public static function delete(mysqli $connection, int $id){
    $sql = sprintf("DELETE FROM %s WHERE %s = ?",
        static::$table,
        static::$primary_key
    );
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $query = $stmt->execute();
    return $query;
}

  
}

