<?php

namespace app\controllers;

use core\Controller;
use app\models\Pelicula as model_pelicula;

class Pelicula extends Controller{

    public function showPeliculas(){
        $peliculas = model_pelicula::all(); //Devuelve un array de objetos Pelicula
        echo $this->templates->render('peliculas', ['peliculas' => $peliculas]);
    }

    public function showFicha($vars){
        $info = model_pelicula::find($vars['id']);
        $directores = model_pelicula::getDirectores($vars['id']);
        $actores = model_pelicula::getActores($vars['id']);
        $criticas = model_pelicula::getCriticas($vars['id']);

        echo $this->templates->render('pelicula_ficha', ['info' => $info, 'directores' => $directores, 'actores' => $actores, 'criticas' => $criticas]);
        //*Dentro de la plantilla deberia llamar a $info, $director o $actores (key)
    }

    public function showCriticas($vars){
        $criticas = model_pelicula::getCriticas($vars['id']);
        echo $this->templates->render('peliculas_criticas',['id_pelicula' => $vars['id'], 'criticas' => $criticas]);
    }
}