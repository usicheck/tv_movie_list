<?php
session_start();

require_once __DIR__ . '/../classes/Movie.php';
require_once __DIR__ . '/../classes/DB.php';

if ('POST' !== $_SERVER['REQUEST_METHOD']) {
    exit('Method is Not Allowed.');
}
$_SESSION['errors'] = [];

$movie = new Movie();
$errors = $movie->validateMovieFields($_POST['name'], $_FILES['image']['tmp_name'], $_POST['releaseDate'] ?? null);

$_SESSION['errors'] = $errors;

if (!empty ($_SESSION['errors'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
else{
    $movieData = [
        'name' => trim($_POST['name']),
        'image' => $_FILES['image'],
        'releaseDate' => $_POST['releaseDate'],
        'description' => trim($_POST['description']) ?? null,
        'image_name'=> $_FILES['image']['name'],
        'image_tmp_name'=> $_FILES['image']['tmp_name'],
    ];

    $movie->addMovie($movieData);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

