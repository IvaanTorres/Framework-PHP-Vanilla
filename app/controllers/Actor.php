<?php

namespace app\controllers;

use core\Controller;
use app\models\Actor as model_actor;

class Actor extends Controller{

    function showFicha($vars){
        $actor = model_actor::find($vars['id_actor']);
        echo $this->templates->render('actor_ficha', ['actor' => $actor]);
    }
}