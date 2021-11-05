<?php

namespace core;
use core\db\Database;

class Model{

    protected $table; //* Esto es $t1
    protected $primary_key = "id"; //* Esto es $pk_t1

    protected function all(){
        $result = Database::select($this->table);
        return $result;
    }
    
    protected function find($pk_searched){
        $where = "$this->primary_key = :$this->primary_key";
        $bind_params = [
            ":$this->primary_key" => $pk_searched
        ];
        $result = Database::select($this->table, ['*'], $where, $bind_params);
        return $result[0];
    }

    protected function belongsToMany($fields, $t2, $pk_t2, $t_union, $fk_t, $fk_t2, $pk_searched){
        $t1 = $this->table;
        $pk_t1 = $this->primary_key;

        $query = "SELECT ";
        foreach ($fields as $field) {
            $query .= $field . ", ";
        }
        $query = rtrim($query, ", ");
        $query .= " FROM $t2";
        $query .= " JOIN $t_union ON $t2.$pk_t2 = $t_union.$fk_t2";
        $query .= " JOIN $t1 ON $t1.$pk_t1 = $t_union.$fk_t AND $t1.$pk_t1 = :$pk_t1";
        $bind_params = [
            ":$pk_t1" => $pk_searched 
        ];
        $result = Database::execute($query, $bind_params);
        return $result;
    }

    protected function hasMany($fields, $t2, $fk_t2, $pk_searched) {
        $t1 = $this->table;
        $pk_t1 = $this->primary_key;
        
        $query = "SELECT ";
        foreach ($fields as $field) {
            $query .= $field . ", ";
        }
        $query = rtrim($query, ", ");
        $query .= " FROM $t2";
        $query .= " JOIN $t1 ON $t1.$pk_t1 = $t2.$fk_t2 AND $t1.$pk_t1 = :$pk_t1";
        $bind_params = [
            ":$pk_t1" => $pk_searched 
        ];
        return Database::execute($query, $bind_params);
    }

    protected function insert(){
        $result = Database::insert($this->table, $_POST);
        return $result;
    }

    protected function edit($pk_searched) {
        $result = Database::edit($this->table, $_POST, $this->primary_key, $pk_searched);
        return $result;
    }      
    
    protected function delete($pk_searched){
        $result = Database::delete($this->table, $this->primary_key, $pk_searched);
        return $result;
    }

    public static function __callStatic($name, $arguments){
        return (new static)->$name(...$arguments);
    }
}