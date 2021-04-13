<?php
namespace app\core\database;

use app\core\Model;

abstract class DatabaseModel extends Model
{
    /**
     * Method for implementation in the app\models model.
     * 
     * @return string Database table name for corresponding model.
     */
    abstract public function table(): string;

    /**
     * Method for implementation in the app\models model.
     * 
     * @return array Database column names for corresponding model.
     */
    abstract public function columns(): array;
    
    /**
     * Prepare SQL statement, bind app\models 
     * model values and execute in database.
     */
    public function save()
    {
        $table = $this->table();
        $columns = $this->columns();
        $attributes = [];
        foreach ($columns as $column) {
            if (!empty($this->{$column})){
                array_push($attributes, $column);
            }
        }
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = Database::prepare(
            "INSERT INTO $table (".implode(',', $attributes).")
             VALUES (".implode(',', $params).")"
        );
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
    }

    /**
     * Delete record(s) from database table.
     * 
     * Find class from which method is called and asume that 
     * table name is class name in the plural. 
     * Prepare SQL statements, bind passed id(s) and execute.
     * 
     * @param array $ids
     */
    public static function delete($ids)
    {
        $class =  preg_replace(
            '/(\w+)\\\(\w+)\\\(\w+)/', 
            '${3}', 
            get_called_class()
        );
        $table = strtolower($class).'s'; 

        foreach ($ids as $id) {
            $statement = Database::prepare("DELETE FROM $table WHERE id = :id"); 
            $statement->bindValue(":id", $id); 
            $statement->execute();
        }
    }

    /**
     * Get all record(s) from database table.
     * 
     * Find class from which method is called and assume 
     * that table name is class name in the plural. 
     * Prepare SQL statement and execute.
     * 
     * @return array
     */
    public static function all()
    {
        $class =  preg_replace(
            '/(\w+)\\\(\w+)\\\(\w+)/', 
            '${3}', 
            get_called_class()
        );
        $table = strtolower($class).'s';

        $statement = Database::prepare("SELECT * FROM $table");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function sortBy($attr)
    {   
        return usort(self::all(), fn($a, $b) => strcmp($a->$attr, $b->$attr));
    }

    // private static function compare()
    // {
        
    // }
}