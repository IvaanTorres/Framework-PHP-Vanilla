<?php
    $this->layout('main', ['title' => 'Ficha']);
?>

<?php 
echo "<b>Nombre: </b>" . $director['nombre'] . "<br>"; 
echo "<b>Año: </b>" . $director['anyo'] . "<br>"; 
echo "<b>Pais: </b>" . $director['pais'] . "<br>"; 
?>