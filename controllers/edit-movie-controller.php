<?php
session_start();

require_once __DIR__ . '/../classes/Movie.php';
require_once __DIR__ . '/../classes/DB.php';

if ('POST' !== $_SERVER['REQUEST_METHOD']) {
    exit('Method is Not Allowed.');
}

$_SESSION['errors'] = [];

$movie = new Movie();
$errors = $movie->validateMovieFields($_POST['name'], $_FILES['image']['tmp_name'] ?? $_POST['oldImage'], $_POST['releaseDate'] ?? null);

$_SESSION['errors'] = $errors;
if (!empty ($_SESSION['errors'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

if ($_FILES['newImage']['name'] != null) {
    if (file_exists('/var/www/html/'. $_POST['oldImage'])) {
        unlink('/var/www/html/' . $_POST['oldImage']);
    }
    $uploadDirectory = dirname(__DIR__) . '/storage';
    $unique_id = date("Y-m-d H:i:s");

    $uploadFilePath = $uploadDirectory . '/' . $unique_id . $_FILES['newImage']['name'];

    move_uploaded_file($_FILES['newImage']['tmp_name'], $uploadFilePath);

    $uploadFilePathBase = 'storage/' . $unique_id . $_FILES['newImage']['name'];
}
else {
    $uploadFilePathBase = $_POST['oldImage'];
}

$updateMovieData = [
    'name' => trim($_POST['name']),
    'movieId' => $_POST['movieId'],
    'image' => $uploadFilePathBase,
    'releaseDate' => $_POST['releaseDate'],
    'description' => trim($_POST['description']) ?? null,
    'uploadFilePathBase' => $uploadFilePathBase,
];
$movie = new Movie;
$movie->updateMovie($updateMovieData);

header('Location: ' . '/../movie.php?movieId=' . $_POST['movieId']);
exit();

