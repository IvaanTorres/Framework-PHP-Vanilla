<?php

namespace app\controllers;

use core\Controller;
use app\models\Pelicula as model_pelicula;
use app\models\Critica as model_critica;

class Critica extends Controller{

    public function showPeliculas(){
        $peliculas = model_pelicula::all();
        echo $this->templates->render('criticas', ['peliculas' => $peliculas]);
    }

    public function showCritica($vars){
        $critica = model_critica::find($vars['id']);
        echo $this->templates->render('criticas_ficha', ['critica' => $critica]);
    }

    public function showInsertForm($vars){
        echo $this->templates->render('criticas_insertar', ['id_pelicula' => $vars['id']]);
    }

    public function insertCritica($vars) {
        model_critica::insert();
        header('Location: ' . $_ENV['APP_URL'] . '/peliculas/' . $vars['id'] . '/criticas');
    }

    public function showEditForm($vars) {
        $critica = model_critica::find($vars['id_critica']);
        echo $this->templates->render('criticas_editar', ['id_pelicula' => $vars['id_pelicula'], 'critica' => $critica]);
    }

    public function editCritica($vars) {
        model_critica::edit($vars['id_critica']);
        header('Location: ' . $_ENV['APP_URL'] . '/peliculas/' . $vars['id_pelicula'] . '/criticas');
    }

    public function deleteCritica($vars) {
        model_critica::delete($vars['id_critica']);
        header('Location: ' . $_ENV['APP_URL'] . '/peliculas/' . $vars['id_pelicula'] . '/criticas');
    } 
}