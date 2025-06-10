<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$n_db = 'manga';

$db = mysqli_connect($host, $user, $pass, $n_db) or die('Erreur de connexion'.mysqli_connect_errno($db))
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>