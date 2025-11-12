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
        $sql= sprintf("SELECT * from %s",static::$table);
        $query=$connection->prepare($sql);
        $query->execute();
        $res=$query->get_result();
        $arr=[];
        while ($car=$res->fetch_assoc()){
            $arr[]=new static($car);
        }
        return $arr;
         
    }
    public static function create(mysqli $connection,array $cardata){
        $columns=array_keys($cardata);
        $vals=array_values($cardata);
        $placeHolders=implode(',',array_fill(0,count($columns),'?'));
        $sql=sprintf("INSERT INTO %s (%s) VALUES (%s)",static::$table,implode(',',$columns,$placeHolders));
        $statement=$connection->prepare($sql);
        $types='';
        foreach($vals as $val){
            if (is_int($val)) $types .='i';
            if (is_float($val)) $types .='d';
            if (is_string($val)) $types .='s';
            else $types .='b';
        }
        $statement=bind_param($types, ...$vals);
        $query=$statement->execute();
        return $query;
    }
    public static function update(mysqli $connection,int $id, array $cardata){
        $columns=array_keys($cardata);
        $vals=array_values($cardata);
        $set=implode(' = ?, ',$columns) . '= ?';
        $sql=sprintf("UPDATE %s WHERE %s = ?",static::$table,$set,static::$primary_key);
        $statement=$connection->prepare($sql);
        $types='';
        foreach($vals as $val){
            if (is_int($val)) $types .='i';
            if (is_float($val)) $types .='d';
            if (is_string($val)) $types .='s';
            else $types .='b';
        }
        $types .= 'i';
        $vals[]=$id;
        $statement->bind_param($types, ...$vals);
        $query=$statement->execute();
        return $query;
    }
    public static function delete(mysqli $connection, int $id){
        $sql=sprintf("DELETE FROM %s WHERE %s = ?",static::$table,static::$primary_key);
        $statement=$connection->prepare($sql);
        $statement->bind_param("i",$id);
        $query=$statement->execute();
        return $query;
    }
}



?>
