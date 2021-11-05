<?php
    $this->layout('main', ['title' => 'Peliculas']);
?>

<div class="row mx-auto">
    <?php
    foreach ($peliculas as $pelicula) {
    ?>
        <div class="col-3">
            <br>
            <a href=<?=$_ENV['APP_URL'] . "/peliculas/" . $pelicula['id']?> class="custom-card">
            
                <div class="card" style="width: 100%;margin:auto">
                    <img class="card-img-top" src=<?=$_ENV['APP_URL'] . "/public/img/peliculas/" . $pelicula['id'] . ".jpg" ?>>
                    <div class="card-body">
                        <h5 class="card-title text-center font-weight-bold">
                            <?=$pelicula['titulo'];?>
                        </h5>
                    </div>
                </div>
            </a>
        </div>
    <?php
    }
    ?>
</div>