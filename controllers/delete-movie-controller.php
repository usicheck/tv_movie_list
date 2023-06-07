<?php

require_once __DIR__ . '/../classes/Movie.php';
require_once __DIR__ . '/../classes/DB.php';

if ('GET' !== $_SERVER['REQUEST_METHOD']) {
    exit('Method is Not Allowed.');
}
$movieId = (int)$_GET['movieId'];
$movie = new Movie();
$movie->deleteMovie($movieId);
header('Location: ' . '/../index.php');
exit();

