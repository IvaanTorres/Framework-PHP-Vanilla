<?php

namespace app\models;

use core\Model;

class Pelicula extends Model{
    
    protected $table = 'peliculas';

    protected function getDirectores($pk_searched){
        $fields_directores = ["directores.id", "directores.nombre"];
        $directores = $this->belongsToMany($fields_directores, "directores", "id", "pelicula_director", "id_pelicula", "id_director", $pk_searched);
        return $directores;
    }

    protected function getActores($pk_searched){
        $fields_actores = ["actores.id", "actores.nombre"];
        $actores = $this->belongsToMany($fields_actores, "actores", "id", "pelicula_actor", "id_pelicula", "id_actor", $pk_searched);
        return $actores;
    }

    protected function getCriticas($pk_searched){
        $fields_criticas = ["criticas.*"];
        $criticas = $this->hasMany($fields_criticas, "criticas", "id_pelicula", $pk_searched);
        return $criticas;
    }

}