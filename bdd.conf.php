<?php
try
{
/* @var $bdd PDO */
$bdd = new PDO('mysql:host=localhost;dbname=id3847705_blogtp;charset=utf8', 'id3847705_root', 'e6g6y566');
$bdd->exec("set names utf8");
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
?>

