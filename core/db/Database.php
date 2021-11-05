<?php

namespace core\db;

class Database{
    
    private function select($table, $fields = ['*'], $where = null, $bind_params = null){
        $query = "SELECT ";
        foreach ($fields as $field) {
            $query .= $field . ", ";
        }
        $query = rtrim($query, ", "); # ELiminar la última coma ','
        $query .= " FROM $table";
        if($where != null){
            $query .= " WHERE $where";
        }
        $query .= ";";
        $ps = $this->execute($query, $bind_params);
        return $ps;
    }

    private function insert($table, $post_array) {
        $fields = "";
        $values = "";
        $bind_params = [];
        foreach ($post_array as $field => $value) { //* El "name" de los campos del form deben ser iguales que las col de la tabla para poder hacer la query automática
            $fields .= $field . ',';
            $bind_param = ":$field";
            $values .= $bind_param . ',';
            $bind_params[$bind_param] = $value; //* En cada ciclo se añade un bind_param a $bind_params con el valor de $value, es decir, el valor del campo del form
        }
        $fields = \substr($fields, 0, -1);
        $values = \substr($values, 0, -1);
        $query = "INSERT INTO $table ($fields) VALUES ($values)";
        return $this->execute($query, $bind_params);
    }      
    
    private function edit($table, $put_array, $pk_table, $pk_searched) {
        $fields = '';
        $bind_params = [];
        foreach ($put_array as $field => $value) {
            if ($field !== '_method') { //* Check de que no es el campo oculto "_method".
                $fields .= "$field = :$field,";
                $bind_param = ":$field";
                $bind_params[$bind_param] = $value; //* En cada ciclo se añade un bind_param a $bind_params con el valor de $value, es decir, el valor del campo del form
            }
        }
        $fields = \substr($fields, 0, -1);
        $bind_params[":$pk_table"] = $pk_searched;
        $query = "UPDATE $table SET $fields WHERE $pk_table = :$pk_table"; //EJ: WHERE id = 36;
        return $this->execute($query, $bind_params);
    }    
    
    private function delete($table, $pk_table, $pk_searched){
        $bind_params[":$pk_table"] = $pk_searched;
        $query = "DELETE FROM $table WHERE $pk_table = :$pk_table;"; //EJ: WHERE id = 36;
        return $this->execute($query, $bind_params);
    }

    private function execute($query, $bind_params) {
        $pdo = Connection::get_instance()::get_pdo(); # Get the connection
        $ps = $pdo->prepare($query);
        $ps->execute($bind_params);
        return $ps->fetchAll(\PDO::FETCH_ASSOC); # Array de todos los registros conseguidos
    }

    public static function __callStatic($name, $arguments){
        return (new static)->$name(...$arguments);
    }
}
?>