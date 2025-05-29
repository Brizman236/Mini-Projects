<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$bd = 'ism';

$con = mysqli_connect($host, $user, $pass, $bd)
or die("Erreur de connexion".mysqli_connect_errno($con));

?>