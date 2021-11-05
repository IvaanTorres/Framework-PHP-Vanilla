<?php

namespace app\controllers;

use core\Controller;
use app\models\Director as model_director;

class Director extends Controller{

    function showFicha($vars){
        $director = model_director::find($vars['id_director']);
        echo $this->templates->render('director_ficha', ['director' => $director]);
    }
}