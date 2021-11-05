<?php
    $this->layout('main', ['title' => 'Ficha']);
?>

<?php 
echo "<b>Nombre: </b>" . $actor['nombre'] . "<br>"; 
echo "<b>Año: </b>" . $actor['anyo'] . "<br>"; 
echo "<b>Pais: </b>" . $actor['pais'] . "<br>"; 
?>